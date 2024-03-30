<?php

namespace DevOwl\RealCookieBanner\settings;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Cache;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration;
use DevOwl\RealCookieBanner\presets\BlockerPresets;
use DevOwl\RealCookieBanner\presets\CookiePresets;
use WP_Error;
use WP_Post;
use WP_REST_Posts_Controller;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Register content blocker custom post type.
 */
class Blocker {
    use UtilsProvider;
    const CPT_NAME = 'rcb-blocker';
    const META_NAME_PRESET_ID = 'presetId';
    const META_NAME_PRESET_VERSION = 'presetVersion';
    const META_NAME_HOSTS = 'hosts';
    const META_NAME_CRITERIA = 'criteria';
    const META_NAME_TCF_VENDORS = 'tcfVendors';
    const META_NAME_COOKIES = 'cookies';
    const META_NAME_VISUAL = 'visual';
    const META_NAME_FORCE_HIDDEN = 'forceHidden';
    const DEFAULT_CRITERIA = self::CRITERIA_COOKIES;
    const CRITERIA_COOKIES = 'cookies';
    const CRITERIA_TCF_VENDORS = 'tcfVendors';
    const SYNC_OPTIONS_COPY_AND_COPY_ONCE = [
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_HOSTS,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_CRITERIA,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_TCF_VENDORS,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_COOKIES,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_VISUAL,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_FORCE_HIDDEN,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_VERSION
    ];
    const SYNC_OPTIONS = [
        'meta' => [
            'copy' => \DevOwl\RealCookieBanner\settings\Blocker::SYNC_OPTIONS_COPY_AND_COPY_ONCE,
            'copy-once' => \DevOwl\RealCookieBanner\settings\Blocker::SYNC_OPTIONS_COPY_AND_COPY_ONCE
        ]
    ];
    const META_KEYS = [
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_HOSTS,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_CRITERIA,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_TCF_VENDORS,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_COOKIES,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_VISUAL,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_FORCE_HIDDEN,
        \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID
    ];
    /**
     * Singleton instance.
     *
     * @var Blocker
     */
    private static $me = null;
    private $cacheGetOrdered = [];
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Register capabilities to administrator role to allow content blocker management.
     *
     * @see https://wordpress.stackexchange.com/a/290093/83335
     * @see https://wordpress.stackexchange.com/a/257401/83335
     */
    public function register_cap() {
        foreach (wp_roles()->roles as $key => $value) {
            $role = get_role($key);
            if ($role->has_cap('manage_options')) {
                foreach (\DevOwl\RealCookieBanner\settings\Cookie::CAPABILITIES as $cap) {
                    $role->add_cap(\sprintf($cap, self::CPT_NAME));
                }
            }
        }
    }
    /**
     * Register custom post type.
     */
    public function register() {
        $labels = ['name' => __('Content Blockers', RCB_TD), 'singular_name' => __('Content Blocker', RCB_TD)];
        $args = [
            'label' => $labels['name'],
            'labels' => $labels,
            'description' => '',
            'public' => \false,
            'publicly_queryable' => \false,
            'show_ui' => \true,
            'show_in_rest' => \true,
            'rest_base' => self::CPT_NAME,
            'rest_controller_class' => \WP_REST_Posts_Controller::class,
            'has_archive' => \false,
            'show_in_menu' => \false,
            'show_in_nav_menus' => \false,
            'delete_with_user' => \false,
            'exclude_from_search' => \true,
            'capability_type' => self::CPT_NAME,
            'map_meta_cap' => \true,
            'hierarchical' => \false,
            'rewrite' => \false,
            'query_var' => \true,
            'supports' => ['title', 'editor', 'custom-fields']
        ];
        register_post_type(self::CPT_NAME, $args);
        register_meta('post', self::META_NAME_PRESET_ID, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_PRESET_VERSION, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'number',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        // This meta is stored as JSON (this shouldn't be done usually - 3rd normal form - but it's ok here)
        register_meta('post', self::META_NAME_HOSTS, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_CRITERIA, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true,
            'default' => self::DEFAULT_CRITERIA
        ]);
        // This meta is stored as JSON (this shouldn't be done usually - 3rd normal form - but it's ok here)
        register_meta('post', self::META_NAME_TCF_VENDORS, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        // This meta is stored as JSON (this shouldn't be done usually - 3rd normal form - but it's ok here)
        register_meta('post', self::META_NAME_COOKIES, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'string',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_VISUAL, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'boolean',
            'single' => \true,
            'show_in_rest' => \true
        ]);
        register_meta('post', self::META_NAME_FORCE_HIDDEN, [
            'object_subtype' => self::CPT_NAME,
            'type' => 'boolean',
            'single' => \true,
            'show_in_rest' => \true
        ]);
    }
    /**
     * Modify revision array and add non-visual blockers so they trigger a new "Request new consent".
     *
     * @param array $result
     */
    public function revisionArray($result) {
        $nonVisual = [];
        $blockers = $this->getOrdered();
        foreach ($blockers as $blocker) {
            // Visuals should not trigger a new consent
            if ($blocker->metas[self::META_NAME_VISUAL]) {
                continue;
            }
            $criteria = $blocker->metas[self::META_NAME_CRITERIA];
            $nonVisualRow = ['id' => $blocker->ID, self::META_NAME_HOSTS => $blocker->metas[self::META_NAME_HOSTS]];
            if ($criteria !== self::DEFAULT_CRITERIA) {
                $nonVisualRow[self::META_NAME_CRITERIA] = $criteria;
            }
            switch ($blocker->metas[self::META_NAME_CRITERIA]) {
                case self::CRITERIA_COOKIES:
                    $nonVisualRow[self::META_NAME_COOKIES] = $blocker->metas[self::META_NAME_COOKIES];
                    break;
                case self::CRITERIA_TCF_VENDORS:
                    $nonVisualRow[self::META_NAME_TCF_VENDORS] = $blocker->metas[self::META_NAME_TCF_VENDORS];
                    break;
                default:
                    break;
            }
            $nonVisual[] = $nonVisualRow;
        }
        $result['nonVisualBlocker'] = $nonVisual;
        return $result;
    }
    /**
     * A blocker was saved.
     *
     * @param int $post_ID
     * @param WP_Post $post
     * @param boolean $update
     */
    public function save_post($post_ID, $post, $update) {
        // Keep "Already exists" in cookie presets intact
        if (!$update) {
            (new \DevOwl\RealCookieBanner\presets\CookiePresets())->forceRegeneration();
            (new \DevOwl\RealCookieBanner\presets\BlockerPresets())->forceRegeneration();
        }
    }
    /**
     * A cookie got deleted, also delete all associations from content blocker.
     *
     * @param int $postId
     */
    public function deleted_post($postId) {
        $post_type = get_post_type($postId);
        if (
            $post_type === \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME ||
            ($this->isPro() && $post_type === \DevOwl\RealCookieBanner\lite\settings\TcfVendorConfiguration::CPT_NAME)
        ) {
            $blockers = $this->getOrdered(
                \false,
                get_posts(
                    \DevOwl\RealCookieBanner\Core::getInstance()->queryArguments(
                        [
                            'post_type' => \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME,
                            'orderby' => ['ID' => 'DESC'],
                            'numberposts' => -1,
                            'nopaging' => \true,
                            'post_status' => ['publish', 'private', 'draft']
                        ],
                        'blockerDeleteCookies'
                    )
                )
            );
            foreach ($blockers as $blocker) {
                $metaKey =
                    $post_type === \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME
                        ? \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_COOKIES
                        : \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_TCF_VENDORS;
                $cookies = $blocker->metas[$metaKey];
                if (($key = \array_search($postId, $cookies, \true)) !== \false) {
                    unset($cookies[$key]);
                    update_post_meta($blocker->ID, $metaKey, \join(',', $cookies));
                }
            }
        }
        // Cleanup transients so presets get regenerated
        if (
            \in_array(
                $post_type,
                [
                    \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME,
                    \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME
                ],
                \true
            )
        ) {
            (new \DevOwl\RealCookieBanner\presets\CookiePresets())->forceRegeneration();
            (new \DevOwl\RealCookieBanner\presets\BlockerPresets())->forceRegeneration();
        }
        // Clear cache for blockers
        if ($post_type === \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME) {
            \DevOwl\RealCookieBanner\Cache::getInstance()->invalidate();
        }
    }
    /**
     * Get all available content blocker ordered.
     *
     * @param boolean $force
     * @param WP_Post[] $usePosts If set, only meta is applied to the passed posts
     * @return WP_Post[]|WP_Error
     */
    public function getOrdered($force = \false, $usePosts = null) {
        $context = \DevOwl\RealCookieBanner\settings\Revision::getInstance()->getContextVariablesString();
        if ($force === \false && isset($this->cacheGetOrdered[$context]) && $usePosts === null) {
            return $this->cacheGetOrdered[$context];
        }
        $posts =
            $usePosts === null
                ? get_posts(
                    \DevOwl\RealCookieBanner\Core::getInstance()->queryArguments(
                        [
                            'post_type' => self::CPT_NAME,
                            'orderby' => ['ID' => 'DESC'],
                            'numberposts' => -1,
                            'nopaging' => \true,
                            'post_status' => 'publish'
                        ],
                        'blockerGetOrdered'
                    )
                )
                : $usePosts;
        foreach ($posts as &$post) {
            $post->metas = [];
            foreach (self::META_KEYS as $meta_key) {
                $metaValue = get_post_meta($post->ID, $meta_key, \true);
                switch ($meta_key) {
                    case self::META_NAME_HOSTS:
                        $metaValue = \explode("\n", $metaValue);
                        $metaValue = \array_values(\array_filter(\array_map('trim', $metaValue), 'strlen'));
                        break;
                    case self::META_NAME_TCF_VENDORS:
                    case self::META_NAME_COOKIES:
                        $metaValue = empty($metaValue) ? [] : \array_map('intval', \explode(',', $metaValue));
                        break;
                    case self::META_NAME_VISUAL:
                    case self::META_NAME_FORCE_HIDDEN:
                        $metaValue = \boolval($metaValue);
                        break;
                    default:
                        break;
                }
                $post->metas[$meta_key] = $metaValue;
            }
        }
        if ($usePosts === null) {
            $this->cacheGetOrdered[$context] = $posts;
        }
        return $posts;
    }
    /**
     * Get a total count of all blockers.
     *
     * @return int
     */
    public function getAllCount() {
        return \array_sum(\array_map('intval', \array_values((array) wp_count_posts(self::CPT_NAME))));
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\settings\Blocker()) : self::$me;
    }
}
