<?php

namespace DevOwl\RealCookieBanner;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\settings\Consent;
use DevOwl\RealCookieBanner\settings\General;
use DevOwl\RealCookieBanner\settings\Revision;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Handle consents of "me".
 */
class MyConsent {
    use UtilsProvider;
    const COOKIE_NAME_USER_PREFIX = 'real_cookie_banner';
    /**
     * Singleton instance.
     *
     * @var MyConsent
     */
    private static $me = null;
    private $cacheCurrentUser = null;
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Persist an user consent to the database.
     *
     * @param array|string $consent A set of accepted cookie groups + cookies or a predefined set like `all` or `essentials` (see `UserConsent::validateConsent`)
     * @param boolean $markAsDoNotTrack
     * @param string $buttonClicked
     * @param int $viewPortWidth
     * @param int $viewPortHeight
     * @param string $referer
     * @param int $blocker If the consent came from a content blocker, mark this in our database
     * @param int $forwarded The reference to the consent ID of the source website (only for forwarded consents)
     * @param string $forwardedUuid The UUID reference of the source website
     * @param boolean $forwardedBlocker Determine if forwarded consent came through a content blocker
     * @param string $tcfString TCF compatibility; encoded TCF string (not the vendor string; `isForVendors = false`)
     * @param string $customBypass Allows to set a custom bypass which causes the banner to be hidden (e.g. Geolocation)
     * @return array The current used user
     */
    public function persist(
        $consent,
        $markAsDoNotTrack,
        $buttonClicked,
        $viewPortWidth,
        $viewPortHeight,
        $referer,
        $blocker = 0,
        $forwarded = 0,
        $forwardedUuid = null,
        $forwardedBlocker = \false,
        $tcfString = null,
        $customBypass = null
    ) {
        $args = \get_defined_vars();
        global $wpdb;
        $consent = \DevOwl\RealCookieBanner\UserConsent::getInstance()->validate($consent);
        if (is_wp_error($consent)) {
            return $consent;
        }
        $revision = \DevOwl\RealCookieBanner\settings\Revision::getInstance();
        $currentHash = $revision->getCurrentHash();
        $revisionHash = $revision->create(\true, \false)['hash'];
        $customizeHash = $revision->createIndependent(\true)['hash'];
        // Create the cookie on client-side with the latest requested consent hash instead of current real-time hash
        // Why? So, the frontend can safely compare latest requested hash to user-consent hash
        // What is true, cookie hash or database? I can promise, the database shows the consent hash!
        $user = $this->ensureUser($currentHash, $forwardedUuid);
        $consent_hash = \md5(\json_encode($consent));
        $ips = \DevOwl\RealCookieBanner\IpHandler::getInstance()->persistIp();
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\UserConsent::TABLE_NAME);
        $wpdb->query(
            // phpcs:disable WordPress.DB.PreparedSQL
            \str_ireplace(
                "'NULL'",
                'NULL',
                $wpdb->prepare(
                    "INSERT IGNORE INTO {$table_name}\n                        (ipv4, ipv6, ipv4_hash, ipv6_hash, uuid, revision, revision_independent, previous_decision, decision, decision_hash, blocker, dnt, custom_bypass, button_clicked, context, viewport_width, viewport_height, referer, pure_referer, url_imprint, url_privacy_policy, forwarded, forwarded_blocker, tcf_string, created)\n                        VALUES\n                        (%d, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %d, %s, %s, %s, %d, %d, %s, %s, %s, %s, %s, %s, %s, %s)",
                    $ips['ipv4'] === null ? 'NULL' : $ips['ipv4'],
                    $ips['ipv6'] === null ? 'NULL' : $ips['ipv6'],
                    $ips['ipv4_hash'] === null ? 'NULL' : $ips['ipv4_hash'],
                    $ips['ipv6_hash'] === null ? 'NULL' : $ips['ipv6_hash'],
                    $user['uuid'],
                    $revisionHash,
                    $customizeHash,
                    \json_encode($user['decision'] === \false ? [] : $user['decision']),
                    \json_encode($consent),
                    $consent_hash,
                    $blocker > 0 ? $blocker : 'NULL',
                    $markAsDoNotTrack,
                    $customBypass === null ? 'NULL' : $customBypass,
                    $buttonClicked,
                    $revision->getContextVariablesString(),
                    $viewPortWidth,
                    $viewPortHeight,
                    $referer,
                    \DevOwl\RealCookieBanner\Utils::removeNonPermalinkQueryFromUrl($referer),
                    \DevOwl\RealCookieBanner\settings\General::getInstance()->getImprintPageUrl(),
                    \DevOwl\RealCookieBanner\settings\General::getInstance()->getPrivacyPolicyUrl(),
                    $forwarded > 0 ? $forwarded : 'NULL',
                    // %s used for 'NULL' transformation
                    $forwardedBlocker,
                    // %s used for 'NULL' transformation
                    $tcfString === null ? 'NULL' : $tcfString,
                    current_time('mysql')
                )
            )
        );
        $insertId = $wpdb->insert_id;
        $this->setCookie($user['uuid'], $currentHash, $consent);
        // Why $currentHash? See above
        // Persist stats (only when not forwarded)
        if ($forwarded === 0) {
            \DevOwl\RealCookieBanner\Stats::getInstance()->persist($consent, $user['decision'], $user['created']);
        }
        $result = \array_merge($this->getCurrentUser(\true), ['updated' => \true, 'consent_id' => $insertId]);
        /**
         * An user has given a new consent.
         *
         * @hook RCB/Consent/Created
         * @param {array} $result
         * @param {array} $args Passed arguments to `MyConsent::persist` as map (since 2.0.0)
         */
        do_action('RCB/Consent/Created', $result, $args);
        return $result;
    }
    /**
     * Ensures an user is connected with the current PHP session. In detail,
     * it does the following:
     *
     * 1. If the user cookie is set, it gets the uuid and revision hash
     * 2. If there is no user cookie, it will generate a uuid with current
     *    consent hash + set it as cookie
     *
     * @param string $revision Hash
     * @param string $useUuid Force to use an existing UUID (useful for forwarded consents)
     * @return array 'uuid', 'created', 'cookie_revision', 'consent_revision', 'decision', 'decision_hash'
     */
    protected function ensureUser($revision, $useUuid = null) {
        $cookieUser = $this->getCurrentUser();
        // There isn't any consent from an user, create one
        if ($cookieUser === \false) {
            $uuid = empty($useUuid) ? $this->createUuid() : $useUuid;
            $this->setCookie($uuid, $revision, []);
            return [
                'uuid' => $uuid,
                'created' => mysql2date('c', current_time('mysql'), \false),
                'cookie_revision' => $revision,
                'consent_revision' => \false,
                'decision' => \false,
                'decision_hash' => \false
            ];
        }
        return $cookieUser;
    }
    /**
     * Set or update the existing cookie to the latest revision. It also respect the fact, that
     * cross-site cookies needs to be set with `SameSite=None` attribute.
     *
     * @param string $uuid
     * @param string $revision
     * @param array $consent
     * @see https://developer.wordpress.org/reference/functions/wp_set_auth_cookie/
     * @see https://stackoverflow.com/a/46971326/5506547
     */
    public function setCookie($uuid = null, $revision = null, $consent = null) {
        $cookieName = $this->getCookieName();
        $doDelete = $uuid === null;
        $cookieValue = $doDelete ? '' : "{$uuid}:{$revision}:" . \json_encode($consent);
        $expire = $doDelete
            ? -1
            : \time() +
                \constant('DAY_IN_SECONDS') *
                    \DevOwl\RealCookieBanner\settings\Consent::getInstance()->getCookieDuration();
        $result = \DevOwl\RealCookieBanner\Utils::setCookie(
            $cookieName,
            $cookieValue,
            $expire,
            \constant('COOKIEPATH'),
            \constant('COOKIE_DOMAIN'),
            is_ssl(),
            \false,
            'None'
        );
        if ($result) {
            /**
             * Real Cookie Banner saved the cookie which holds information about the user with
             * UUID, revision and consent choices.
             *
             * @hook RCB/Consent/SetCookie
             * @param {string} $cookieName
             * @param {string} $cookieValue
             * @param {boolean} $result Got the cookie successfully created?
             * @param {boolean} $revoke `true` if the cookie should be deleted
             * @param {string} $uuid
             * @param {array}
             * @since 2.0.0
             */
            do_action('RCB/Consent/SetCookie', $cookieName, $cookieValue, $result, $doDelete, $uuid);
        }
        return $result;
    }
    /**
     * Get's the current user from the cookie. The result will hold the unique
     * user id and the accepted revision hash. This function is also ported to JS via `getUserDecision.tsx`.
     *
     * @param boolean $force
     * @return array 'uuid', 'created', 'cookie_revision', 'consent_revision', 'decision', 'decision_in_cookie', 'decision_hash'
     */
    public function getCurrentUser($force = \false) {
        if ($this->cacheCurrentUser !== null && !$force) {
            return $this->cacheCurrentUser;
        }
        // Cookie set?
        $cookieName = $this->getCookieName();
        if (!isset($_COOKIE[$cookieName])) {
            return \false;
        }
        $parsed = $this->parseCookieValue($_COOKIE[$cookieName]);
        if ($parsed === \false) {
            return \false;
        }
        // Save in cache
        $this->cacheCurrentUser = $parsed;
        return $this->cacheCurrentUser;
    }
    /**
     * Parse a consent from a given cookie value. The result will hold the unique
     * user id and the accepted revision hash.
     *
     * @param string $value
     * @return array 'uuid', 'created', 'cookie_revision', 'consent_revision', 'decision', 'decision_in_cookie', 'decision_hash'
     */
    protected function parseCookieValue($value) {
        global $wpdb;
        // Cookie empty? (https://stackoverflow.com/a/32567915/5506547)
        $result = \stripslashes($value);
        if (empty($result)) {
            return \false;
        }
        // Cookie scheme valid?
        $result = \explode(':', $result, 3);
        if (\count($result) !== 3) {
            return \false;
        }
        $cookieDecision = \json_decode($result[2], ARRAY_A);
        // Parse out data (${uuid}-${revision})
        $uuid = $result[0];
        $revision = $result[1];
        // Check if any consent was ever set by this user
        // phpcs:disable WordPress.DB.PreparedSQL
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\UserConsent::TABLE_NAME);
        $result = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT revision, revision_independent, decision, decision_hash, created\n                FROM {$table_name}\n                WHERE uuid = %s\n                ORDER BY created DESC LIMIT 1",
                $uuid
            ),
            ARRAY_A
        );
        // phpcs:enable WordPress.DB.PreparedSQL
        // No row found
        if ($result === null) {
            return \false;
        }
        return [
            'uuid' => $uuid,
            'created' => mysql2date('c', $result['created'], \false),
            'cookie_revision' => $revision,
            'consent_revision' => $result['revision'],
            'consent_revision_independent' => $result['revision_independent'],
            'decision' => \json_decode($result['decision'], ARRAY_A),
            'decision_in_cookie' => $cookieDecision,
            'decision_hash' => $result['decision_hash']
        ];
    }
    /**
     * Create an unique id for the current user.
     */
    protected function createUuid() {
        // Read from existing cookies (context-depending)
        foreach ($_COOKIE as $key => $value) {
            if (\DevOwl\RealCookieBanner\Utils::startsWith($key, self::COOKIE_NAME_USER_PREFIX)) {
                $parsed = $this->parseCookieValue($value);
                if ($parsed !== \false) {
                    return $parsed['uuid'];
                }
            }
        }
        return wp_generate_uuid4();
    }
    /**
     * Get the history of the current user.
     */
    public function getCurrentHistory() {
        global $wpdb;
        $user = $this->getCurrentUser();
        $result = [];
        if ($user !== \false) {
            // Read from database
            $table_name = $this->getTableName(\DevOwl\RealCookieBanner\UserConsent::TABLE_NAME);
            $table_name_revision = $this->getTableName(\DevOwl\RealCookieBanner\settings\Revision::TABLE_NAME);
            $table_name_revision_independent = $this->getTableName(
                \DevOwl\RealCookieBanner\settings\Revision::TABLE_NAME_INDEPENDENT
            );
            // phpcs:disable WordPress.DB.PreparedSQL
            $rows = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT uc.id, uc.created, uc.decision, r.json_revision, ri.json_revision AS json_revision_independent, uc.dnt, uc.blocker, uc.forwarded, uc.tcf_string\n                    FROM {$table_name} uc\n                    INNER JOIN {$table_name_revision} r\n                    ON r.hash = uc.revision\n                    INNER JOIN {$table_name_revision_independent} ri\n                    ON ri.hash = uc.revision_independent\n                    WHERE uuid = %s\n                    ORDER BY uc.created DESC\n                    LIMIT 0, 100",
                    $user['uuid']
                ),
                ARRAY_A
            );
            // phpcs:enable WordPress.DB.PreparedSQL
            foreach ($rows as $row) {
                $jsonRevision = \json_decode($row['json_revision'], ARRAY_A);
                $jsonRevisionIndependent = \json_decode($row['json_revision_independent'], ARRAY_A);
                $obj = [
                    'id' => \intval($row['id']),
                    'uuid' => $user['uuid'],
                    'isDoNotTrack' => \boolval($row['dnt']),
                    'isUnblock' => \boolval($row['blocker']),
                    'isForwarded' => $row['forwarded'] > 0,
                    'created' => mysql2date('c', $row['created'], \false),
                    'groups' => $jsonRevision['groups'],
                    'decision' => \json_decode($row['decision'], ARRAY_A),
                    // TCF compatibility
                    'tcf' => isset($jsonRevision['tcf'])
                        ? [
                            'tcf' => $jsonRevision['tcf'],
                            'tcfMeta' => $jsonRevisionIndependent['tcfMeta'],
                            'tcfString' => $row['tcf_string']
                        ]
                        : null
                ];
                $result[] = $obj;
            }
        }
        return $result;
    }
    /**
     * Get cookie name for the current page.
     */
    public function getCookieName() {
        $revision = \DevOwl\RealCookieBanner\settings\Revision::getInstance();
        $implicitString = $revision->getContextVariablesString(\true);
        $contextString = $revision->getContextVariablesString();
        return self::COOKIE_NAME_USER_PREFIX .
            (empty($implicitString) ? '' : '-' . $implicitString) .
            (empty($contextString) ? '' : '-' . $contextString);
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\MyConsent()) : self::$me;
    }
}
