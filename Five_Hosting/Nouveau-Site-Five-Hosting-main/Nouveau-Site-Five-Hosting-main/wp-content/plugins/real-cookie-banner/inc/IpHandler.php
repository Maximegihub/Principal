<?php

namespace DevOwl\RealCookieBanner;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\settings\Consent;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Handle IPs hashed correctly depending on settings.
 */
class IpHandler {
    use UtilsProvider;
    const FLOODING_SECONDS = 60;
    const FLOODING_MAX_ENTRIES_IN_DEFINED_SECONDS = 255;
    /**
     * Singleton instance.
     *
     * @var IpHandler
     */
    private static $me = null;
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Checks the current IP if it is already persisted, it avoids to
     * flood the API all x seconds.
     *
     * @return boolean Returns true if you are allowed to create a new consent
     */
    public function isFlooding() {
        global $wpdb;
        $ips = $this->persistIp();
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\UserConsent::TABLE_NAME);
        /**
         * IP flooding is implemented to forbid a new user consent by max requests to the API.
         * Here you can modify the flooding seconds.
         *
         * @hook RCB/IpHandler/FloodingSeconds
         * @param {int} $seconds
         * @returns {int}
         */
        $floodingSeconds = \intval(apply_filters('RCB/IpHandler/FloodingSeconds', self::FLOODING_SECONDS));
        /**
         * IP flooding is implemented to forbid a new user consent by max requests to the API.
         * Here you can modify the maximum allowed entries within the given flooding seconds.
         *
         * @hook RCB/IpHandler/FloodingMaxEntries
         * @param {int} $max
         * @returns {int}
         */
        $floodingMaxEntries = \intval(
            apply_filters('RCB/IpHandler/FloodingMaxEntries', self::FLOODING_MAX_ENTRIES_IN_DEFINED_SECONDS)
        );
        // phpcs:disable WordPress.DB.PreparedSQL
        $sql = \str_ireplace(
            "= 'NULL'",
            'IS NULL',
            $wpdb->prepare(
                "SELECT COUNT(*)\n                    FROM {$table_name}\n                    WHERE ipv4 = %d\n                    AND ipv6 = %s\n                    AND ipv4_hash = %s\n                    AND ipv6_hash = %s\n                    AND created > (NOW() - INTERVAL " .
                    $floodingSeconds .
                    ' SECOND)',
                $ips['ipv4'] === null ? 'NULL' : $ips['ipv4'],
                $ips['ipv6'] === null ? 'NULL' : $ips['ipv6'],
                $ips['ipv4_hash'] === null ? 'NULL' : $ips['ipv4_hash'],
                $ips['ipv6_hash'] === null ? 'NULL' : $ips['ipv6_hash']
            )
        );
        $result = $wpdb->get_var($sql);
        // phpcs:enable WordPress.DB.PreparedSQL
        $isFlooding = \intval($result) > $floodingMaxEntries;
        /**
         * IP flooding is implemented to forbid a new user consent by max requests to the API.
         *
         * @hook RCB/IpHandler/Flooding
         * @param {boolean} isFlooding
         * @returns {boolean}
         */
        return \boolval(apply_filters('RCB/IpHandler/Flooding', $isFlooding));
    }
    /**
     * Get persistable IP for database. It also respects IP settings.
     * If the IP is not stored, we need to truncate the last IP block so it
     * is annonymous.
     *
     * @see https://www.onlinemarketingrecht.de/2017/09/ip-adressen-anonymisieren-wann-wie-und-warum/
     */
    public function persistIp() {
        $saveIp = \DevOwl\RealCookieBanner\settings\Consent::getInstance()->isSaveIpEnabled();
        $ip = $_SERVER['REMOTE_ADDR'];
        $ipVersion = \strpos($ip, ':') === \false ? 4 : 6;
        $ipDel = $ipVersion === 6 ? ':' : '.';
        // Truncate plain IP for annonymous hashing
        $truncateIp = \explode($ipDel, $ip);
        \array_pop($truncateIp);
        $truncateIp[] = 0;
        $truncateIp = \join($ipDel, $truncateIp);
        // Always use the truncated IP as hash
        $hashIp = \DevOwl\RealCookieBanner\Utils::hash($truncateIp);
        $result = ['ipv4' => null, 'ipv6' => null, 'ipv4_hash' => null, 'ipv6_hash' => null];
        if ($ipVersion === 4) {
            if ($saveIp) {
                $result['ipv4'] = \ip2long($ip);
            }
            $result['ipv4_hash'] = $hashIp;
        } else {
            if ($saveIp) {
                $result['ipv6'] = \inet_pton($ip);
            }
            $result['ipv6_hash'] = $hashIp;
        }
        return $result;
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\IpHandler()) : self::$me;
    }
}
