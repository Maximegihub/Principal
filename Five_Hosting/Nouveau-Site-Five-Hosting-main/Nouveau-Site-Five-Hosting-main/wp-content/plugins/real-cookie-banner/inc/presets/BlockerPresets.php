<?php

namespace DevOwl\RealCookieBanner\presets;

use DevOwl\RealCookieBanner\settings\Blocker;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\presets\free\blocker\FontAwesomePreset;
use DevOwl\RealCookieBanner\presets\free\blocker\GravatarPreset;
use DevOwl\RealCookieBanner\presets\free\blocker\GoogleFontsPreset;
use DevOwl\RealCookieBanner\presets\free\blocker\YoutubePreset;
use DevOwl\RealCookieBanner\presets\free\blocker\JetPackSiteStatsPreset;
use DevOwl\RealCookieBanner\presets\free\blocker\JetPackCommentsPreset;
use DevOwl\RealCookieBanner\presets\free\blocker\WordPressCommentsPreset;
use DevOwl\RealCookieBanner\presets\free\blocker\WordPressEmojisPreset;
use DevOwl\RealCookieBanner\presets\free\blocker\WordPressPluginEmbed;
use DevOwl\RealCookieBanner\presets\free\blocker\WordPressUserLoginPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AmazonAssociatesWidgetPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\AwinPublisherMasterTagPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\BingAdsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FoundEePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\FreshchatPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleAdsensePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GoogleAdsPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\GtmPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\HCaptchaPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\HelpCrunchChatPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\HelpScoutChatPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\LuckyOrangePreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MatomoPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\MtmPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\PaddleComPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\ReamazeChatPreset;
use DevOwl\RealCookieBanner\presets\pro\blocker\TikTokPixelPreset;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Predefined presets for blocker.
 */
class BlockerPresets extends \DevOwl\RealCookieBanner\presets\Presets {
    const CLASSES = [
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_FONTS =>
            \DevOwl\RealCookieBanner\presets\free\blocker\GoogleFontsPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::YOUTUBE =>
            \DevOwl\RealCookieBanner\presets\free\blocker\YoutubePreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::JETPACK_SITE_STATS =>
            \DevOwl\RealCookieBanner\presets\free\blocker\JetPackSiteStatsPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::JETPACK_COMMENTS =>
            \DevOwl\RealCookieBanner\presets\free\blocker\JetPackCommentsPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GRAVATAR =>
            \DevOwl\RealCookieBanner\presets\free\blocker\GravatarPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDPRESS_EMOJIS =>
            \DevOwl\RealCookieBanner\presets\free\blocker\WordPressEmojisPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FONTAWESOME =>
            \DevOwl\RealCookieBanner\presets\free\blocker\FontAwesomePreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDPRESS_USER_LOGIN =>
            \DevOwl\RealCookieBanner\presets\free\blocker\WordPressUserLoginPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDPRESS_PLUGIN_EMBED =>
            \DevOwl\RealCookieBanner\presets\free\blocker\WordPressPluginEmbed::class,
        // Hidden content blocker just for scanning purposes
        // FREE
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDPRESS_COMMENTS =>
            \DevOwl\RealCookieBanner\presets\free\blocker\WordPressCommentsPreset::class,
        // PRO
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::AWIN_PUBLISHER_MASTERTAG =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\AwinPublisherMasterTagPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FOUND_EE =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\FoundEePreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::FRESHCHAT =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\FreshchatPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_ADS =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleAdsPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GOOGLE_AD_SENSE =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\GoogleAdsensePreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::GTM =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\GtmPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::HCAPTCHA =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\HCaptchaPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::HELP_CRUNCH_CHAT =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\HelpCrunchChatPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::HELP_SCOUT_CHAT =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\HelpScoutChatPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::LUCKY_ORANGE =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\LuckyOrangePreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MATOMO =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\MatomoPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::MTM =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\MtmPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::BING_ADS =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\BingAdsPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::PADDLE_COM =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\PaddleComPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::REAMAZE_CHAT =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\ReamazeChatPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::AMAZON_ASSOCIATES_WIDGET =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\AmazonAssociatesWidgetPreset::class,
        \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::TIKTOK_PIXEL =>
            \DevOwl\RealCookieBanner\presets\pro\blocker\TikTokPixelPreset::class
    ];
    const PRESETS_TYPE = 'blocker';
    /**
     * C'tor.
     */
    public function __construct() {
        parent::__construct(self::PRESETS_TYPE);
    }
    // Documented in Presets
    public function getClassList($force = \false) {
        /**
         * Filters available presets for blocker.
         *
         * @hook RCB/Presets/Blocker
         * @param {string} $presets All available presets. `[id => <extends AbstractBlockerPreset>::class]`
         * @returns {string}
         */
        $list = apply_filters('RCB/Presets/Blocker', self::CLASSES);
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
             * Available presets for blockers got persisted.
             *
             * @hook RCB/Presets/Blocker/Persisted
             * @param {array[]} $presets All available presets as array
             * @since 2.6.0
             */
            do_action('RCB/Presets/Blocker/Persisted', $items);
        }
        return $persist;
    }
    // Documented in Presets
    public function getOtherMetaKeys() {
        // Make hosts always available in cache cause we need this for the scanner
        return [\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_HOSTS, 'extended', 'mustHosts'];
    }
    /**
     * Resolve `attributes.cookies` so we can e.g. show created cookies in "Connected cookies"
     * in blocker edit form.
     *
     * @param array $preset Result of `getWithAttributes()`
     */
    public function resolveAvailableCookies(&$preset) {
        $cookiePresets = new \DevOwl\RealCookieBanner\presets\CookiePresets();
        $existingCookies = \DevOwl\RealCookieBanner\presets\CookiePresets::getCookiesWithPreset();
        if ($preset !== \false && isset($preset['attributes'], $preset['attributes']['cookies'])) {
            $newCookies = [];
            foreach ($preset['attributes']['cookies'] as $cookie) {
                if (\is_string($cookie)) {
                    // It should reference to an existing preset, let's resolve the ID
                    foreach ($existingCookies as $existingCookie) {
                        if (
                            $existingCookie->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID] ===
                            $cookie
                        ) {
                            $newCookies[] = $existingCookie->ID;
                            continue 2;
                        }
                    }
                    // Cookie preset is available, but does not actually exist as cookie
                    $cookieAttributes = $cookiePresets->getFromCache($cookie);
                    $cookieName = $cookieAttributes['name'];
                    $cookieDescription = $cookieAttributes['description'] ?? '';
                    $newCookies[] = [
                        'id' => $cookie,
                        'name' =>
                            $cookieName . (empty($cookieDescription) ? '' : \sprintf(' (%s)', $cookieDescription)),
                        'version' => $cookieAttributes['version'],
                        'attributes' => $cookiePresets->getWithAttributes($cookie)['attributes']
                    ];
                } else {
                    $newCookies[] = $cookie;
                }
            }
            $preset['attributes']['cookies'] = $newCookies;
        }
        return $preset;
    }
    // Documented in Presets
    public function fromClassList($clazzes) {
        $result = [];
        $existingBlockers = self::getBlockerWithPreset();
        $existingCookies = \DevOwl\RealCookieBanner\presets\CookiePresets::getCookiesWithPreset();
        foreach ($clazzes as $id => $clazz) {
            /**
             * Instance.
             *
             * @var AbstractBlockerPreset
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
     * See filter `RCB/Presets/Blocker/Middleware`.
     *
     * @param array $preset
     * @param WP_Post[] $existingCookies
     * @param WP_Post[] $existingBlockers
     * @param array $result
     */
    public function applyMiddleware(&$preset, $existingCookies, $existingBlockers, &$result) {
        /**
         * Inject some middleware directly to the content blocker preset. This can be useful to
         * enhance the preset with functionalities like `extends`.
         *
         * @hook RCB/Presets/Blocker/Middleware
         * @param {array} $preset The preset passed as reference
         * @param {AbstractCookiePreset} $instance Preset instance
         * @param {WP_Post[]} $existingBlockers
         * @param {WP_Post[]} $existingCookies
         * @param {array[]} $result All collected presets (since 2.6.0); when requesting a single preset attributes, this can be of size 1
         * @param {Presets} $presetsInstance
         * @returns {array}
         */
        $preset = apply_filters_ref_array('RCB/Presets/Blocker/Middleware', [
            &$preset,
            $preset['instance'] ?? null,
            $existingBlockers,
            $existingCookies,
            &$result,
            $this
        ]);
        // Make `hosts` always available in metadata (needed for scanner)
        if (
            isset(
                $preset['attributes'],
                $preset['attributes'][\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_HOSTS]
            )
        ) {
            $preset[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_HOSTS] =
                $preset['attributes'][\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_HOSTS];
        }
        unset($preset['instance']);
    }
    /**
     * Get all available blocker with a preset.
     */
    public static function getBlockerWithPreset() {
        return \DevOwl\RealCookieBanner\settings\Blocker::getInstance()->getOrdered(
            \false,
            get_posts(
                \DevOwl\RealCookieBanner\Core::getInstance()->queryArguments(
                    [
                        'post_type' => \DevOwl\RealCookieBanner\settings\Blocker::CPT_NAME,
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
                    'blockerWithPreset'
                )
            )
        );
    }
}
