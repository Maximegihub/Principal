<?php

namespace DevOwl\RealCookieBanner\presets\middleware;

use DevOwl\RealCookieBanner\presets\AbstractBlockerPreset;
use DevOwl\RealCookieBanner\presets\AbstractCookiePreset;
use DevOwl\RealCookieBanner\Utils;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Middleware to enable `'needs': ['wp:elementor', 'wp:elementor-pro']` in cookie and content blocker presets.
 */
class DisablePresetByNeedsMiddleware {
    const WP_PREFIX = 'wp:';
    /**
     * Pass preset metadata with attributes and disable the preset when none of the given plugins is active.
     *
     * @param array $preset
     * @param AbstractCookiePreset|AbstractBlockerPreset $instance
     */
    public function middleware(&$preset, $instance) {
        if (isset($preset['needs']) && !isset($preset['disabled']) && $instance !== null) {
            $type = $instance instanceof \DevOwl\RealCookieBanner\presets\AbstractCookiePreset ? 'cookie' : 'blocker';
            $foundActive = self::check($preset['needs'], $preset['id'], $type);
            $preset['disabled'] = !$foundActive;
            unset($preset['needs']);
        }
        return $preset;
    }
    /**
     * Check by an array of dependencies if one is active.
     *
     * @param string[] $needs
     * @param string $presetIdentifier
     * @param string $type Can be `cookie` or `blocker`
     */
    public static function check($needs, $presetIdentifier, $type) {
        foreach ($needs as $dep) {
            if (\DevOwl\RealCookieBanner\Utils::startsWith($dep, self::WP_PREFIX)) {
                $plugin = \substr($dep, \strlen(self::WP_PREFIX));
                if (\DevOwl\RealCookieBanner\Utils::isPluginActive($plugin)) {
                    /**
                     * Allows you to deactivate a false-positive plugin preset.
                     *
                     * Example: Someone has RankMath SEO active, but deactivated the GA function.
                     *
                     * Attention: This filter is only applied for active plugins!
                     *
                     * @hook RCB/Blocker/SkipIfActive
                     * @param {boolean} $isActive
                     * @param {string} $plugin The active plugin (can be slug or file)
                     * @param {string} $identifier The preset identifier
                     * @param {string} $type Can be `cookie` or `blocker`
                     * @return {boolean}
                     * @since 2.6.0
                     */
                    if (apply_filters('RCB/Presets/Active', \true, $plugin, $presetIdentifier, $type)) {
                        return \true;
                    }
                }
            }
        }
        return \false;
    }
    /**
     * Generate the `needs` keyword for a set of slugs.
     *
     * @param string[] $slugs
     */
    public static function generateNeedsForSlugs($slugs) {
        foreach ($slugs as &$slug) {
            $slug = \sprintf('%s%s', self::WP_PREFIX, $slug);
        }
        return $slugs;
    }
}
