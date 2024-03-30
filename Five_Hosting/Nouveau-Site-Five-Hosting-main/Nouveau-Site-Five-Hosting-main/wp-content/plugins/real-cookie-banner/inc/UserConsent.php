<?php

namespace DevOwl\RealCookieBanner;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\settings\Cookie;
use DevOwl\RealCookieBanner\settings\CookieGroup;
use DevOwl\RealCookieBanner\settings\Revision;
use DevOwl\RealCookieBanner\view\Blocker;
use DevOwl\RealCookieBanner\view\shortcode\LinkShortcode;
use WP_Error;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Handle consents of users.
 */
class UserConsent {
    use UtilsProvider;
    const TABLE_NAME = 'consent';
    const CLICKABLE_BUTTONS = [
        'none',
        'main_all',
        'main_essential',
        'main_custom',
        'ind_all',
        'ind_essential',
        'ind_custom',
        \DevOwl\RealCookieBanner\view\shortcode\LinkShortcode::BUTTON_CLICKED_IDENTIFIER,
        \DevOwl\RealCookieBanner\view\Blocker::BUTTON_CLICKED_IDENTIFIER
    ];
    /**
     * If you do not want to decode data like `revision` or `decision` to real objects (useful for CSV exports).
     */
    const BY_CRITERIA_RESULT_TYPE_NO_DECODE = 'noDecode';
    const BY_CRITERIA_RESULT_TYPE_JSON_DECODE = 'jsonDecode';
    const BY_CRITERIA_RESULT_TYPE_COUNT = 'count';
    const BY_CRITERIA_RESULT_TYPE_SQL_QUERY = 'sqlQuery';
    /**
     * Singleton instance.
     *
     * @var UserConsent
     */
    private static $me = null;
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Apply a custom decision (e.g. opt-out a single cookie in a cookie group) to a new
     * consent. This is e.g. helpful if you are providing a Custom Bypass (e.g. Geolocation)
     * and want to overtake an opt-out / opt-in from the previous consent.
     *
     * @param int $essentialGroupId
     * @param array|string $previousConsent
     * @param array|string $newConsent
     * @param string $overtake Can be `opt-in` or `opt-out`
     */
    public function applyCustomDecisionFromPreviousConsent($previousConsent, $newConsent, $overtake) {
        $previousConsent = $this->validate($previousConsent);
        $newConsent = $this->validate($newConsent);
        if (is_wp_error($previousConsent) || is_wp_error($newConsent)) {
            return $previousConsent;
        }
        $essentialGroupId = \DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->getEssentialGroup()->term_id;
        $allPreviousCookies = \DevOwl\RealCookieBanner\Utils::flatten($previousConsent);
        $allCookies = \DevOwl\RealCookieBanner\Utils::flatten($this->validate('all'));
        if ($overtake === 'opt-out') {
            foreach ($newConsent as $group => $cookies) {
                if (\intval($group) === $essentialGroupId) {
                    // Skip essentials as they need always be accepted
                    continue;
                }
                foreach ($cookies as $idx => $cookie) {
                    if (!\in_array($cookie, $allPreviousCookies, \true)) {
                        // Remove from our new consent, too
                        unset($newConsent[$group][$idx]);
                        $newConsent[$group] = \array_values($newConsent[$group]);
                        // Force to be numbered array
                        continue;
                    }
                }
            }
        } elseif ($overtake === 'opt-in') {
            foreach ($previousConsent as $group => $cookies) {
                if (\intval($group) === $essentialGroupId) {
                    // Skip essentials as they need always be accepted
                    continue;
                }
                foreach ($cookies as $cookie) {
                    if (!\in_array($cookie, $allCookies, \true)) {
                        // Does no longer exist, skip
                        continue;
                    }
                    $newConsent[$group][] = $cookie;
                }
            }
        }
        return $newConsent;
    }
    /**
     * Check if passed array is valid consent.
     *
     * @param array|string $consent
     * @return array|WP_Error Sanitized consent array
     */
    public function validate($consent) {
        if (\is_array($consent)) {
            foreach ($consent as $key => &$value) {
                if (!\is_numeric($key) || !\is_array($value)) {
                    return new \WP_Error('rcb_user_consent_invalid');
                }
                foreach ($value as $cookieId) {
                    if (!\is_numeric($cookieId)) {
                        return new \WP_Error('rcb_user_consent_invalid');
                    }
                }
                $value = \array_map('intval', $value);
            }
            return $consent;
        }
        if (\is_string($consent)) {
            // Automatically set cookies to "All"
            $result = [];
            foreach (
                $consent === 'all'
                    ? \DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->getOrdered()
                    : [\DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->getEssentialGroup()]
                as $group
            ) {
                $result[$group->term_id] = \array_map(function ($cookie) {
                    return $cookie->ID;
                }, \DevOwl\RealCookieBanner\settings\Cookie::getInstance()->getOrdered($group->term_id));
            }
            return $result;
        }
        return new \WP_Error('rcb_user_consent_invalid');
    }
    /**
     * Delete all available user consents with revisions and stats.
     *
     * @return boolean|array Array with deleted counts of the database tables
     */
    public function purge() {
        global $wpdb;
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\UserConsent::TABLE_NAME);
        $table_name_revision = $this->getTableName(\DevOwl\RealCookieBanner\settings\Revision::TABLE_NAME);
        $table_name_revision_independent = $this->getTableName(
            \DevOwl\RealCookieBanner\settings\Revision::TABLE_NAME_INDEPENDENT
        );
        $table_name_stats = $this->getTableName(\DevOwl\RealCookieBanner\Stats::TABLE_NAME);
        // The latest revision should not be deleted
        $revisionHash = \DevOwl\RealCookieBanner\settings\Revision::getInstance()->getCurrentHash();
        // phpcs:disable WordPress.DB
        $consent = $wpdb->query("DELETE FROM {$table_name}");
        $revision = $wpdb->query(
            $wpdb->prepare("DELETE FROM {$table_name_revision} WHERE `hash` != %s", $revisionHash)
        );
        $revision_independent = $wpdb->query("DELETE FROM {$table_name_revision_independent}");
        $stats = $wpdb->query("DELETE FROM {$table_name_stats}");
        // phpcs:enable WordPress.DB
        return [
            'consent' => $consent,
            'revision' => $revision,
            'revision_independent' => $revision_independent,
            'stats' => $stats
        ];
    }
    /**
     * Fetch user consents by criteria.
     *
     * @param array $args 'uuid', 'ip', 'offset', 'perPage', 'from', 'to', 'pure_referer', 'context'
     * @param string $returnType
     */
    public function byCriteria($args, $returnType = self::BY_CRITERIA_RESULT_TYPE_JSON_DECODE) {
        global $wpdb;
        // Parse arguments
        $args = \array_merge(
            [
                'uuid' => '',
                'ip' => '',
                'offset' => 0,
                'perPage' => 10,
                'from' => '',
                'to' => '',
                'pure_referer' => '',
                'context'
            ],
            $args
        );
        $ip = $args['ip'];
        $uuid = $args['uuid'];
        $limitOffset = $args['offset'];
        $perPage = $args['perPage'];
        $from = $args['from'];
        $to = $args['to'];
        $pure_referer = $args['pure_referer'];
        $context = $args['context'];
        // Prepare parameters
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\UserConsent::TABLE_NAME);
        $table_name_revision = $this->getTableName(\DevOwl\RealCookieBanner\settings\Revision::TABLE_NAME);
        $table_name_revision_independent = $this->getTableName(
            \DevOwl\RealCookieBanner\settings\Revision::TABLE_NAME_INDEPENDENT
        );
        // Build WHERE statement for filtering
        $where = [];
        $where[] = empty($uuid) ? '1 = 1' : $wpdb->prepare('(c.uuid = %s)', $uuid);
        $useIpv4 = \ip2long($ip);
        $useIpv6 = \inet_pton($ip);
        $hashIp = \DevOwl\RealCookieBanner\Utils::hash($ip);
        $where[] = empty($ip)
            ? '1 = 1'
            : $wpdb->prepare(
                '(c.ipv4 = %d OR c.ipv6 = %s OR c.ipv4_hash = %s OR c.ipv6_hash = %s OR c.ipv4_hash = %s OR c.ipv6_hash = %s)',
                $useIpv4 === \false ? 1 : $useIpv4,
                $useIpv6 === \false ? 1 : $useIpv6,
                $ip,
                $ip,
                // When the IP is entered plain, also respect hashed IPs
                $hashIp,
                $hashIp
            );
        $where[] = empty($pure_referer) ? '1 = 1' : $wpdb->prepare('c.pure_referer = %s', $pure_referer);
        $where[] = !empty($from) && !empty($to) ? $wpdb->prepare('c.created BETWEEN %s AND %s', $from, $to) : '1 = 1';
        $where[] = empty($context) ? '1 = 1' : $wpdb->prepare('c.context = %s', $context);
        $fields = [
            'c.id',
            'c.ipv4',
            'c.ipv6',
            'c.ipv4_hash',
            'c.ipv6_hash',
            'c.uuid',
            'c.previous_decision',
            'c.decision',
            'c.created',
            'c.blocker',
            'c.dnt',
            'c.custom_bypass',
            'c.user_country',
            'c.button_clicked',
            'c.context',
            'c.viewport_width',
            'c.viewport_height',
            'c.referer as viewed_page',
            'c.url_imprint',
            'c.url_privacy_policy',
            'c.forwarded',
            'c.forwarded_blocker',
            'c.tcf_string'
        ];
        if ($returnType === self::BY_CRITERIA_RESULT_TYPE_SQL_QUERY) {
            // For e.g. Export we need to export the complete revision as object
            $fields[] = 'rev.json_revision AS revision';
            $fields[] = 'revc.json_revision AS revision_independent';
        } elseif ($returnType === self::BY_CRITERIA_RESULT_TYPE_COUNT) {
            $fields = ['COUNT(*) AS cnt'];
        } else {
            // For all other implementations we should definitely lazy load the revision object via shortcode
            $fields[] = 'rev.hash AS revision_hash';
            $fields[] = 'revc.hash AS revision_independent_hash';
        }
        // Read data
        // phpcs:disable WordPress.DB
        $sql = $wpdb->prepare(
            'SELECT ' .
                \join(',', $fields) .
                '
                FROM ' .
                $table_name .
                ' AS c INNER JOIN ' .
                $table_name_revision .
                ' AS rev ON rev.hash = c.revision INNER JOIN ' .
                $table_name_revision_independent .
                ' AS revc ON revc.hash = c.revision_independent WHERE ' .
                \join(' AND ', $where) .
                ($returnType === self::BY_CRITERIA_RESULT_TYPE_COUNT ? '' : ' ORDER BY c.created DESC LIMIT %d, %d'),
            $limitOffset,
            $perPage
        );
        if ($returnType === self::BY_CRITERIA_RESULT_TYPE_SQL_QUERY) {
            return $sql;
        }
        $results = $wpdb->get_results($sql);
        // phpcs:enable WordPress.DB
        if ($returnType === self::BY_CRITERIA_RESULT_TYPE_COUNT) {
            return \intval($results[0]->cnt);
        }
        $this->castReadRows($results, $returnType === self::BY_CRITERIA_RESULT_TYPE_JSON_DECODE);
        return $results;
    }
    /**
     * Cast read rows from database to correct types.
     *
     * @param object[] $results
     * @param boolean $jsonDecode Pass `false` if you do not want to decode data like `revision` or `decision` to real objects (useful for CSV exports)
     */
    public function castReadRows(&$results, $jsonDecode = \true) {
        $revisionHashes = [];
        foreach ($results as &$row) {
            $row->id = \intval($row->id);
            $row->ipv4 = $row->ipv4 === '0' ? null : $row->ipv4;
            $row->context = empty($row->context)
                ? ''
                : \DevOwl\RealCookieBanner\settings\Revision::getInstance()->translateContextVariablesString(
                    $row->context
                );
            if ($jsonDecode) {
                $row->previous_decision = \json_decode($row->previous_decision);
                $row->decision = \json_decode($row->decision);
                // Only populate decision_labels if we also decode the decision
                $revisionHashes[] = $row->revision_hash;
            }
            $row->blocker = $row->blocker === null ? null : \intval($row->blocker);
            $row->dnt = $row->dnt === '1';
            $row->created = mysql2date('c', $row->created, \false);
            $row->viewport_width = \intval($row->viewport_width);
            $row->viewport_height = \intval($row->viewport_height);
            $row->forwarded = $row->forwarded === null ? null : \intval($row->forwarded);
            $row->forwarded_blocker = $row->forwarded_blocker === '1';
            if ($row->ipv4 !== null) {
                $row->ipv4 = \long2ip($row->ipv4);
            }
            if ($row->ipv6 !== null) {
                $row->ipv6 = \inet_ntop($row->ipv6);
            }
        }
        // Populate decision_labels so we can show the decision in table
        if (\count($revisionHashes)) {
            $revisionHashes = \DevOwl\RealCookieBanner\settings\Revision::getInstance()->getByHash($revisionHashes);
            // Iterate all table items
            foreach ($results as &$row) {
                $decision = $row->decision;
                $labels = [];
                $groups = $revisionHashes[$row->revision_hash]['groups'];
                // Iterate all decision groups
                foreach ($decision as $groupId => $cookies) {
                    $cookiesCount = \count($cookies);
                    if ($cookiesCount > 0) {
                        // Iterate all available revision groups to find the decision group
                        foreach ($groups as $group) {
                            if ($group['id'] === \intval($groupId)) {
                                $name = $group['name'];
                                $itemsCount = \count($group['items']);
                                $labels[] =
                                    $name .
                                    ($cookiesCount !== $itemsCount
                                        ? \sprintf(' (%d / %d)', $cookiesCount, $itemsCount)
                                        : '');
                                break;
                            }
                        }
                    }
                }
                $row->decision_labels = $labels;
            }
        }
        return $revisionHashes;
    }
    /**
     * Get the total count of current consents.
     */
    public function getCount() {
        global $wpdb;
        $table_name = $this->getTableName(self::TABLE_NAME);
        // phpcs:disable WordPress.DB.PreparedSQL
        return \intval($wpdb->get_var("SELECT COUNT(*) FROM {$table_name}"));
        // phpcs:enable WordPress.DB.PreparedSQL
    }
    /**
     * Get all referer across all consents.
     *
     * @return string[]
     */
    public function getReferer() {
        global $wpdb;
        $table_name = $this->getTableName(self::TABLE_NAME);
        // phpcs:disable WordPress.DB.PreparedSQL
        return $wpdb->get_col("SELECT DISTINCT(pure_referer) FROM {$table_name} WHERE pure_referer <> ''");
        // phpcs:enable WordPress.DB.PreparedSQL
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\UserConsent()) : self::$me;
    }
}
