<?php

namespace DevOwl\RealCookieBanner\presets;

use DevOwl\RealCookieBanner\presets\free\GoogleFontsPreset;
use DevOwl\RealCookieBanner\presets\free\JetPackCommentsPreset;
use DevOwl\RealCookieBanner\presets\free\RealCookieBannerPreset;
use DevOwl\RealCookieBanner\presets\free\WordPressCommentsPreset;
use DevOwl\RealCookieBanner\presets\free\WordPressUserLoginPreset;
use DevOwl\RealCookieBanner\presets\free\YoutubePreset;
use DevOwl\RealCookieBanner\presets\free\JetpackSiteStatsPreset;
use DevOwl\RealCookieBanner\presets\free\GravatarPreset;
use DevOwl\RealCookieBanner\presets\free\WordPressEmojisPreset;
use DevOwl\RealCookieBanner\settings\Blocker;
use DevOwl\RealCookieBanner\settings\Cookie;
use DevOwl\RealCookieBanner\settings\CookieGroup;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\free\ElementorPreset;
use DevOwl\RealCookieBanner\presets\free\FontAwesomePreset;
use DevOwl\RealCookieBanner\presets\free\WordPressPluginEmbed;
use DevOwl\RealCookieBanner\scanner\ScanPresets;
use DevOwl\RealCookieBanner\view\ConfigPage;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Predefined presets for cookies.
 */
class CookiePresets extends \DevOwl\RealCookieBanner\presets\Presets {
    const CLASSES = [
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::REAL_COOKIE_BANNER =>
            \DevOwl\RealCookieBanner\presets\free\RealCookieBannerPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDPRESS_USER_LOGIN =>
            \DevOwl\RealCookieBanner\presets\free\WordPressUserLoginPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDPRESS_COMMENTS =>
            \DevOwl\RealCookieBanner\presets\free\WordPressCommentsPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::JETPACK_COMMENTS =>
            \DevOwl\RealCookieBanner\presets\free\JetPackCommentsPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_FONTS =>
            \DevOwl\RealCookieBanner\presets\free\GoogleFontsPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::YOUTUBE =>
            \DevOwl\RealCookieBanner\presets\free\YoutubePreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::JETPACK_SITE_STATS =>
            \DevOwl\RealCookieBanner\presets\free\JetpackSiteStatsPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GRAVATAR =>
            \DevOwl\RealCookieBanner\presets\free\GravatarPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDPRESS_EMOJIS =>
            \DevOwl\RealCookieBanner\presets\free\WordPressEmojisPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::ELEMENTOR =>
            \DevOwl\RealCookieBanner\presets\free\ElementorPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FONTAWESOME =>
            \DevOwl\RealCookieBanner\presets\free\FontAwesomePreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDPRESS_PLUGIN_EMBED =>
            \DevOwl\RealCookieBanner\presets\free\WordPressPluginEmbed::class
    ];
    const PRESETS_TYPE = 'cookie';
    /**
     * C'tor.
     */
    public function __construct() {
        parent::__construct(self::PRESETS_TYPE);
    }
    // Documented in Presets
    public function getClassList($force = \false) {
        /**
         * Filters available presets for cookies.
         *
         * @hook RCB/Presets/Cookies
         * @param {string[]} $presets All available presets. `[id => <extends AbstractCookiePreset>::class]`
         * @returns {string[]}
         */
        $list = apply_filters('RCB/Presets/Cookies', self::CLASSES);
        if ($this->needsRecalculation() || $force) {
            $this->persist($this->fromClassList($list));
        }
        return $list;
    }
    // Documented in Presets
    public function persist($items) {
        $persist = parent::persist($items);
        if ($persist) {
            /**
             * Available presets for cookies got persisted.
             *
             * @hook RCB/Presets/Cookies/Persisted
             * @param {array[]} $presets All available presets as array
             * @since 2.6.0
             */
            do_action('RCB/Presets/Cookies/Persisted', $items);
        }
        return $persist;
    }
    // Documented in Presets
    public function getOtherMetaKeys() {
        return ['blockerPresets', 'extended'];
    }
    // Documented in Presets
    public function expandResult(&$rows) {
        (new \DevOwl\RealCookieBanner\scanner\ScanPresets())->expandResult($rows);
    }
    /**
     * Create a cookie from a cookie preset.
     *
     * @param int $identifier
     * @param int $group
     */
    public function createFromPreset($identifier, $group) {
        $preset = $this->getWithAttributes($identifier);
        if ($preset !== \false) {
            $attributes = $preset['attributes'];
            $name = $attributes['name'];
            $purpose = $attributes['purpose'];
            unset($attributes['name'], $attributes['group'], $attributes['purpose']);
            // Cast some attributes
            foreach ($attributes as $key => $value) {
                switch ($key) {
                    case \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_TECHNICAL_DEFINITIONS:
                        $attributes[$key] = \json_encode($value);
                        break;
                    default:
                        break;
                }
            }
            $post = wp_insert_post(
                [
                    'post_title' => $name,
                    'post_type' => \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME,
                    'post_status' => 'publish',
                    'post_content' => $purpose,
                    'meta_input' => \array_merge(
                        [
                            \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID => $identifier,
                            \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_VERSION => $preset['version']
                        ],
                        $attributes
                    )
                ],
                \true
            );
            if (is_wp_error($post)) {
                return $post;
            }
            return wp_set_object_terms($post, $group, \DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME);
        }
        return \false;
    }
    // Documented in Presets
    public function fromClassList($clazzes) {
        $result = [];
        $existingCookies = self::getCookiesWithPreset();
        $existingBlockers = \DevOwl\RealCookieBanner\presets\BlockerPresets::getBlockerWithPreset();
        foreach ($clazzes as $id => $clazz) {
            /**
             * Instance.
             *
             * @var AbstractCookiePreset
             */
            $instance = new $clazz();
            $preset = $instance->common();
            $preset['instance'] = $instance;
            if (!isset($preset['tags'])) {
                $preset['tags'] = [];
            }
            $result[$id] = $preset;
        }
        // Iterate again to apply middleware
        foreach ($result as &$preset) {
            $this->applyMiddleware($preset, $existingCookies, $existingBlockers, $result);
        }
        return $result;
    }
    /**
     * See filter `RCB/Presets/Cookies/Middleware`.
     *
     * @param array $preset
     * @param WP_Post[] $existingCookies
     * @param WP_Post[] $existingBlockers
     * @param array $result
     */
    public function applyMiddleware(&$preset, $existingCookies, $existingBlockers, &$result) {
        /**
         * Inject some middleware directly to the cookie preset. This can be useful to
         * enhance the preset with functionalities like `extends`.
         *
         * @hook RCB/Presets/Cookies/Middleware
         * @param {array} $preset The preset passed as reference
         * @param {AbstractCookiePreset} $instance Preset instance
         * @param {WP_Post[]} $existingCookies
         * @param {WP_Post[]} $existingBlocker
         * @param {array[]} $result All collected presets (since 2.6.0); when requesting a single preset attributes, this can be of size 1
         * @param {Presets} $presetsInstance
         * @returns {array}
         */
        $preset = apply_filters_ref_array('RCB/Presets/Cookies/Middleware', [
            &$preset,
            $preset['instance'] ?? null,
            $existingCookies,
            $existingBlockers,
            &$result,
            $this
        ]);
        unset($preset['instance']);
    }
    /**
     * Get all available cookies with a preset.
     */
    public static function getCookiesWithPreset() {
        return \DevOwl\RealCookieBanner\settings\Cookie::getInstance()->getOrdered(
            null,
            \false,
            get_posts(
                \DevOwl\RealCookieBanner\Core::getInstance()->queryArguments(
                    [
                        'post_type' => \DevOwl\RealCookieBanner\settings\Cookie::CPT_NAME,
                        'numberposts' => -1,
                        'nopaging' => \true,
                        'meta_query' => [
                            [
                                'key' => \DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID,
                                'compare' => 'EXISTS'
                            ]
                        ],
                        'post_status' => ['publish', 'private', 'draft']
                    ],
                    'cookiesWithPreset'
                )
            )
        );
    }
    /**
     * Get the URL to create a new cookie from a preset identifier.
     *
     * @param string $identifier
     */
    public static function getCreateUrl($identifier) {
        return admin_url(
            \sprintf(
                'admin.php?page=%s#/cookies/%d/new?force=%s',
                \DevOwl\RealCookieBanner\view\ConfigPage::COMPONENT_ID,
                \DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->getEssentialGroup()->term_id,
                $identifier
            )
        );
    }
}
