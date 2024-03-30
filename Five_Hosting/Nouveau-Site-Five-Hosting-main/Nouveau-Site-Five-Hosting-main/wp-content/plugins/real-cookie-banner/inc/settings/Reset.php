<?php

namespace DevOwl\RealCookieBanner\settings;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration;
use DevOwl\RealCookieBanner\presets\BlockerPresets;
use DevOwl\RealCookieBanner\presets\CookiePresets;
use DevOwl\RealCookieBanner\scanner\AutomaticScanStarter;
use DevOwl\RealCookieBanner\scanner\Persist;
use DevOwl\RealCookieBanner\scanner\Scanner;
use DevOwl\RealCookieBanner\UserConsent;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Allows to reset all data of RCB including cookies, options, and cookie groups.
 */
class Reset {
    use UtilsProvider;
    /**
     * Singleton instance.
     *
     * @var Reset
     */
    private static $me = null;
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Clear all data.
     */
    public function all() {
        global $wpdb;
        (new \DevOwl\RealCookieBanner\presets\CookiePresets())->forceRegeneration();
        (new \DevOwl\RealCookieBanner\presets\BlockerPresets())->forceRegeneration();
        // Custom post types
        $postIds = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT ID FROM {$wpdb->posts} WHERE post_type IN (%s, %s)",
                \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME,
                \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME
            )
        );
        if ($this->isPro()) {
            $postIds = \array_merge(
                $postIds,
                $wpdb->get_col(
                    $wpdb->prepare(
                        "SELECT ID FROM {$wpdb->posts} WHERE post_type IN (%s)",
                        \DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration::CPT_NAME
                    )
                )
            );
        }
        if (!empty($postIds)) {
            foreach ($postIds as $postId) {
                wp_delete_post($postId, \true);
            }
        }
        // Custom taxonomies
        $terms = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT term_id, taxonomy FROM {$wpdb->term_taxonomy} WHERE taxonomy IN (%s)",
                \DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME
            )
        );
        if (!empty($terms)) {
            foreach ($terms as $term) {
                wp_delete_term($term->term_id, $term->taxonomy);
            }
        }
        // Options
        $optionNames = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s AND option_name NOT IN('rcb-installation-date')",
                RCB_OPT_PREFIX . '-%'
            )
        );
        if (!empty($optionNames)) {
            foreach ($optionNames as $option_name) {
                delete_option($option_name);
            }
        }
        // Scanner
        $table_name = $this->getTableName(\DevOwl\RealCookieBanner\scanner\Persist::TABLE_NAME);
        // phpcs:disable WordPress.DB.PreparedSQL
        $wpdb->query("TRUNCATE TABLE {$table_name}");
        // phpcs:enable WordPress.DB.PreparedSQL
        // Queue items
        $queuePersist = \DevOwl\RealCookieBanner\Core::getInstance()
            ->getRealQueue()
            ->getPersist();
        $queuePersist->deleteByType(\DevOwl\RealCookieBanner\scanner\AutomaticScanStarter::REAL_QUEUE_TYPE);
        $queuePersist->deleteByType(\DevOwl\RealCookieBanner\scanner\Scanner::REAL_QUEUE_TYPE);
        \DevOwl\RealCookieBanner\UserConsent::getInstance()->purge();
        \DevOwl\RealCookieBanner\Core::getInstance()
            ->getActivator()
            ->addInitialContent();
    }
    /**
     * Get singleton instance.
     *
     * @return Reset
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\settings\Reset()) : self::$me;
    }
}
