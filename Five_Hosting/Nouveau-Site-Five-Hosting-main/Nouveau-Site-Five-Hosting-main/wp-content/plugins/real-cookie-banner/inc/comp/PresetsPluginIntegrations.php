<?php

namespace DevOwl\RealCookieBanner\comp;

use DevOwl\RealCookieBanner\presets\BlockerPresets;
use DevOwl\RealCookieBanner\presets\CookiePresets;
use DevOwl\RealCookieBanner\presets\PresetIdentifierMap;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Provide native integrations to known plugins which are associated to a preset.
 *
 * Example: RankMath SEO: Deactivate Analytics preset when the "Install code" option is activated.
 */
class PresetsPluginIntegrations {
    const SLUG_RANKMATH_SEO_PRO = 'seo-by-rank-math-pro';
    const SLUG_RANKMATH_SEO_FREE = 'seo-by-rank-math';
    const SLUG_ANALYTIFY_PRO = 'wp-analytify-pro';
    const SLUG_ANALYTIFY_FREE = 'wp-analytify';
    const SLUG_EXACTMETRICS_PRO = 'google-analytics-dashboard-for-wp-premium';
    const SLUG_EXACTMETRICS_FREE = 'google-analytics-dashboard-for-wp';
    const SLUG_MONSTERINSIGHTS_PRO = 'google-analytics-premium';
    const SLUG_MONSTERINSIGHTS_FREE = 'google-analytics-for-wordpress';
    const SLUG_GA_GOOGLE_ANALYTICS_PRO = 'ga-google-analytics-pro';
    const SLUG_GA_GOOGLE_ANALYTICS_FREE = 'ga-google-analytics';
    const SLUG_WOOCOMMERCE_GOOGLE_ANALYTICS_FREE = 'woocommerce-google-analytics-integration';
    const SLUG_WOOCOMMERCE_GOOGLE_ANALYTICS_PRO = 'woocommerce-google-analytics-pro';
    const SLUG_WP_PIWIK = 'wp-piwik';
    const SLUG_MATOMO_PLUGIN = 'matomo';
    const OPTION_NAME_USERS_CAN_REGISTER = 'users_can_register';
    const OPTION_NAME_RANK_MATH_GA = 'rank_math_google_analytic_options';
    const OPTION_NAME_ANALYTIFY_AUTHENTICATION = 'wp-analytify-authentication';
    const OPTION_NAME_ANALYTIFY_PROFILE = 'wp-analytify-profile';
    const OPTION_NAME_ANALYTIFY_GOOGLE_TOKEN = 'pa_google_token';
    const OPTION_NAME_EXACTMETRICS_SITE_PROFILE = 'exactmetrics_site_profile';
    const OPTION_NAME_MONSTERINSIGHTS_SITE_PROFILE = 'monsterinsights_site_profile';
    const OPTION_NAME_GA_GOOGLE_ANALYTICS = 'gap_options';
    const OPTION_NAME_WOOCOMMERCE_GOOGLE_ANALYTICS = 'woocommerce_google_analytics_settings';
    const OPTION_NAME_WP_PIWIK = 'wp-piwik_global-track_mode';
    const OPTION_NAME_MATOMO_PLUGIN = 'matomo-global-option';
    // Network options
    const OPTION_NAME_EXACTMETRICS_NETWORK_PROFIL = 'exactmetrics_network_profile';
    const OPTION_NAME_MONSTERINSIGHTS_NETWORK_PROFIL = 'monsterinsights_network_profile';
    const INVALIDATE_WHEN_OPTION_CHANGES = [
        self::OPTION_NAME_USERS_CAN_REGISTER,
        self::OPTION_NAME_RANK_MATH_GA,
        self::OPTION_NAME_ANALYTIFY_AUTHENTICATION,
        self::OPTION_NAME_ANALYTIFY_PROFILE,
        self::OPTION_NAME_ANALYTIFY_GOOGLE_TOKEN,
        self::OPTION_NAME_EXACTMETRICS_SITE_PROFILE,
        self::OPTION_NAME_MONSTERINSIGHTS_SITE_PROFILE,
        self::OPTION_NAME_GA_GOOGLE_ANALYTICS,
        self::OPTION_NAME_WOOCOMMERCE_GOOGLE_ANALYTICS,
        self::OPTION_NAME_WP_PIWIK,
        self::OPTION_NAME_MATOMO_PLUGIN
    ];
    const INVALIDATE_WHEN_SITE_OPTION_CHANGES = [
        self::OPTION_NAME_EXACTMETRICS_NETWORK_PROFIL,
        self::OPTION_NAME_MONSTERINSIGHTS_NETWORK_PROFIL
    ];
    /**
     * C'tor.
     *
     * @codeCoverageIgnore
     */
    protected function __construct() {
        // Silence is golden.
    }
    /**
     * Initialize update hooks.
     */
    public function init() {
        $callback = [$this, 'invalidate'];
        foreach (self::INVALIDATE_WHEN_OPTION_CHANGES as $optionName) {
            add_action('update_option_' . $optionName, $callback);
            add_action('add_option_' . $optionName, $callback);
            add_action('delete_option_' . $optionName, $callback);
        }
        foreach (self::INVALIDATE_WHEN_SITE_OPTION_CHANGES as $optionName) {
            add_action('update_site_option_' . $optionName, $callback);
            add_action('add_site_option_' . $optionName, $callback);
            add_action('delete_site_option_' . $optionName, $callback);
        }
    }
    /**
     * Invalidate cookie and blocker presets.
     */
    public function invalidate() {
        (new \DevOwl\RealCookieBanner\presets\CookiePresets())->forceRegeneration();
        (new \DevOwl\RealCookieBanner\presets\BlockerPresets())->forceRegeneration();
    }
    /**
     * Automatically set the `recommended` attribute to `true` for some special cases.
     *
     * @param array $preset
     */
    public function middleware_cookies_recommended(&$preset) {
        switch ($preset['id']) {
            case \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::WORDPRESS_USER_LOGIN:
                $preset['recommended'] = get_option(self::OPTION_NAME_USERS_CAN_REGISTER) > 0;
                break;
            case \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::CLOUDFLARE:
                $preset['recommended'] =
                    isset($_SERVER['HTTP_CF_CONNECTING_IP']) && !empty($_SERVER['HTTP_CF_CONNECTING_IP']);
                break;
            case \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::EZOIC_ESSENTIAL:
            case \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::EZOIC_MARKETING:
            case \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::EZOIC_PREFERENCES:
            case \DevOwl\RealCookieBanner\presets\PresetIdentifierMap::EZOIC_STATISTIC:
                $preset['recommended'] = isset($header['x-middleton']);
                break;
            default:
                break;
        }
        return $preset;
    }
    /**
     * Automatically set the `recommended` attribute to `true` for some special cases.
     *
     * @param array $preset
     */
    public function middleware_blocker_recommended(&$preset) {
        switch ($preset['id']) {
            // Paste your exceptions here
            default:
                break;
        }
        return $preset;
    }
    /**
     * Check multiple plugins for native integration.
     *
     * @param boolean $isActive
     * @param string $plugin
     * @param string $identifier
     * @param string $type
     */
    public function presets_active($isActive, $plugin, $identifier, $type) {
        switch ($plugin) {
            case self::SLUG_RANKMATH_SEO_PRO:
            case self::SLUG_RANKMATH_SEO_FREE:
                $option = get_option(self::OPTION_NAME_RANK_MATH_GA);
                return \is_array($option) && isset($option['install_code']) && $option['install_code'];
            case self::SLUG_ANALYTIFY_PRO:
            case self::SLUG_ANALYTIFY_FREE:
                $googleToken = get_option(self::OPTION_NAME_ANALYTIFY_GOOGLE_TOKEN);
                $auth = get_option(self::OPTION_NAME_ANALYTIFY_AUTHENTICATION);
                if (!empty($googleToken)) {
                    $profile = get_option(self::OPTION_NAME_ANALYTIFY_PROFILE);
                    return \is_array($profile) &&
                        isset($profile['install_ga_code']) &&
                        $profile['install_ga_code'] === 'on';
                }
                return \is_array($auth) && isset($auth['manual_ua_code']) && !empty($auth['manual_ua_code']);
            case self::SLUG_EXACTMETRICS_PRO:
            case self::SLUG_EXACTMETRICS_FREE:
                return \function_exists('exactmetrics_get_ua') && !empty(exactmetrics_get_ua());
            case self::SLUG_MONSTERINSIGHTS_PRO:
            case self::SLUG_MONSTERINSIGHTS_FREE:
                return \function_exists('monsterinsights_get_ua') && !empty(monsterinsights_get_ua());
            case self::SLUG_GA_GOOGLE_ANALYTICS_PRO:
            case self::SLUG_GA_GOOGLE_ANALYTICS_FREE:
                if (!\function_exists('ga_google_analytics_options')) {
                    return \false;
                }
                $option = ga_google_analytics_options();
                return \is_array($option) && isset($option['tracking_id']) && !empty($option['tracking_id']);
            case self::SLUG_WOOCOMMERCE_GOOGLE_ANALYTICS_PRO:
            case self::SLUG_WOOCOMMERCE_GOOGLE_ANALYTICS_FREE:
                $option = get_option(self::OPTION_NAME_WOOCOMMERCE_GOOGLE_ANALYTICS);
                if (!\is_array($option)) {
                    return \false;
                }
                return isset($option['ga_id'], $option['ga_standard_tracking_enabled']) &&
                    !empty($option['ga_id']) &&
                    $option['ga_standard_tracking_enabled'] !== 'no';
                break;
            case self::SLUG_WP_PIWIK:
                return get_option(self::OPTION_NAME_WP_PIWIK) !== 'disabled';
            case self::SLUG_MATOMO_PLUGIN:
                $option = get_option(self::OPTION_NAME_MATOMO_PLUGIN);
                if (!\is_array($option) || !isset($option['track_mode'])) {
                    return \false;
                }
                return $option['track_mode'] !== 'disabled';
            default:
                break;
        }
        return $isActive;
    }
    /**
     * New instance.
     *
     * @codeCoverageIgnore
     */
    public static function instance() {
        return new \DevOwl\RealCookieBanner\comp\PresetsPluginIntegrations();
    }
}
