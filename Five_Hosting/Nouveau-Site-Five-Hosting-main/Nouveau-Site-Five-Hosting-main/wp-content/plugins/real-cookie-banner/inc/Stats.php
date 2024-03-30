<?php

namespace DevOwl\RealCookieBanner;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\lite\Stats as LiteStats;
use DevOwl\RealCookieBanner\overrides\interfce\IOverrideStats;
use DevOwl\RealCookieBanner\settings\Cookie;
use DevOwl\RealCookieBanner\settings\CookieGroup;
use DevOwl\RealCookieBanner\settings\Revision;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Consent stats handling. Most features are implemented in Pro override.
 */
class Stats implements \DevOwl\RealCookieBanner\overrides\interfce\IOverrideStats {
    use UtilsProvider;
    use LiteStats;
    const TABLE_NAME = 'stats';
    const STATS_ACCEPTED_TYPE_ALL = 2;
    const STATS_ACCEPTED_TYPE_PARTIAL = 1;
    const STATS_ACCEPTED_TYPE_NONE = 0;
    const STATS_ACCEPTED_ALL_TYPES = [
        self::STATS_ACCEPTED_TYPE_ALL,
        self::STATS_ACCEPTED_TYPE_NONE,
        self::STATS_ACCEPTED_TYPE_PARTIAL
    ];
    /**
     * Singleton instance.
     *
     * @var Stats
     */
    private static $me = null;
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Persist a new consent to a given group to the stats database table.
     *
     * @param array $consent
     * @param array $previousConsent Do not count recurring users in stats
     * @param string $previousCreated ISO string of previous consent
     */
    public function persist($consent, $previousConsent, $previousCreated) {
        global $wpdb;
        $table_name = $this->getTableName(self::TABLE_NAME);
        $newConsentAcceptTypes = $this->calculateGroupAcceptTypes($consent);
        $contextString = \DevOwl\RealCookieBanner\settings\Revision::getInstance()->getContextVariablesString();
        $dayIso = mysql2date('Y-m-d', current_time('mysql'));
        foreach ($newConsentAcceptTypes as $term_id => $accepted) {
            $term_name = get_term($term_id)->name;
            $wpdb->query(
                // phpcs:disable WordPress.DB.PreparedSQL
                $wpdb->prepare(
                    "INSERT INTO {$table_name}\n                        (`day`, `context`, `term_name`, `term_id`, `accepted`, `count`)\n                        VALUES\n                        (%s, %s, %s, %d, %d, 1)\n                        ON DUPLICATE KEY UPDATE `count` = `count` + 1",
                    $dayIso,
                    $contextString,
                    $term_name,
                    $term_id,
                    $accepted
                )
            );
            // Also persist other accept-types so the stats are intact
            foreach (\array_diff(self::STATS_ACCEPTED_ALL_TYPES, [$accepted]) as $missingAccepted) {
                $wpdb->query(
                    // phpcs:disable WordPress.DB.PreparedSQL
                    $wpdb->prepare(
                        "INSERT IGNORE INTO {$table_name}\n                            (`day`, `context`, `term_name`, `term_id`, `accepted`, `count`)\n                            VALUES\n                            (%s, %s, %s, %d, %d, 0)",
                        $dayIso,
                        $contextString,
                        $term_name,
                        $term_id,
                        $missingAccepted
                    )
                );
            }
        }
        // Subtract recurring users
        if (\is_array($previousConsent) && !empty($previousConsent)) {
            $previousConsentAcceptTypes = $this->calculateGroupAcceptTypes($previousConsent);
            // Simply reduce by one each group / accept type because it still get's added above
            // With this method, it is ensured that only differences are subtracted
            foreach ($previousConsentAcceptTypes as $term_id => $accepted) {
                $wpdb->query(
                    // phpcs:disable WordPress.DB.PreparedSQL
                    $wpdb->prepare(
                        "UPDATE {$table_name}\n                            SET `count` = `count` - 1\n                            WHERE `count` > 0\n                            AND context = %s\n                            AND day = %s\n                            AND term_id = %d\n                            AND accepted = %d",
                        $contextString,
                        mysql2date('Y-m-d', $previousCreated),
                        $term_id,
                        $accepted
                    )
                );
            }
        }
    }
    /**
     * Calculate the accept types for a given consent. It returns an array of keyed term id
     * with accept type.
     *
     * @param array $consent
     */
    private function calculateGroupAcceptTypes($consent) {
        $result = [];
        $groups = \DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->getOrdered();
        foreach ($groups as $term) {
            $term_id = $term->term_id;
            $term_id_string = \strval($term->term_id);
            if (!isset($consent[$term_id_string]) || \count($consent[$term_id_string]) === 0) {
                $accepted = self::STATS_ACCEPTED_TYPE_NONE;
            } else {
                $allCount = \count(\DevOwl\RealCookieBanner\settings\Cookie::getInstance()->getOrdered($term_id));
                $accepted =
                    $allCount === \count($consent[$term_id_string])
                        ? self::STATS_ACCEPTED_TYPE_ALL
                        : self::STATS_ACCEPTED_TYPE_PARTIAL;
            }
            $result[$term_id] = $accepted;
        }
        return $result;
    }
    /**
     * Fires after a group got changed, let's update the plain name in database
     * for future display when the group got deleted.
     *
     * @param int $term_id
     */
    public function edited_group($term_id) {
        global $wpdb;
        $table_name = $this->getTableName(self::TABLE_NAME);
        $term_name = get_term($term_id)->name;
        $wpdb->query(
            // phpcs:disable WordPress.DB.PreparedSQL
            $wpdb->prepare("UPDATE {$table_name} SET term_name = %s WHERE term_id = %d", $term_name, $term_id)
        );
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\Stats()) : self::$me;
    }
}
