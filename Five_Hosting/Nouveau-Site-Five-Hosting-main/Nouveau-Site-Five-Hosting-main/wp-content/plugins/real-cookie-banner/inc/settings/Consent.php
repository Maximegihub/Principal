<?php

namespace DevOwl\RealCookieBanner\settings;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\lite\settings\Consent as LiteConsent;
use DevOwl\RealCookieBanner\overrides\interfce\settings\IOverrideConsent;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Settings > Consent.
 */
class Consent implements \DevOwl\RealCookieBanner\overrides\interfce\settings\IOverrideConsent {
    use LiteConsent;
    use UtilsProvider;
    const OPTION_GROUP = 'options';
    const SETTING_ACCEPT_ALL_FOR_BOTS = RCB_OPT_PREFIX . '-accept-all-for-bots';
    const SETTING_RESPECT_DO_NOT_TRACK = RCB_OPT_PREFIX . '-respect-do-not-track';
    const SETTING_COOKIE_DURATION = RCB_OPT_PREFIX . '-cookie-duration';
    const SETTING_SAVE_IP = RCB_OPT_PREFIX . '-save-ip';
    const SETTING_EPRIVACY_USA = RCB_OPT_PREFIX . '-eprivacy-usa';
    const SETTING_AGE_NOTICE = RCB_OPT_PREFIX . '-age-notice';
    const DEFAULT_ACCEPT_ALL_FOR_BOTS = \true;
    const DEFAULT_RESPECT_DO_NOT_TRACK = \false;
    const DEFAULT_COOKIE_DURATION = 365;
    const DEFAULT_SAVE_IP = \false;
    const DEFAULT_EPRIVACY_USA = \false;
    const DEFAULT_AGE_NOTICE = \true;
    /**
     * Singleton instance.
     *
     * @var Consent
     */
    private static $me = null;
    /**
     * C'tor.
     */
    private function __construct() {
        // Silence is golden.
    }
    /**
     * Initially `add_option` to avoid autoloading issues.
     */
    public function enableOptionsAutoload() {
        \DevOwl\RealCookieBanner\settings\General::enableOptionAutoload(
            self::SETTING_ACCEPT_ALL_FOR_BOTS,
            self::DEFAULT_ACCEPT_ALL_FOR_BOTS,
            'boolval'
        );
        \DevOwl\RealCookieBanner\settings\General::enableOptionAutoload(
            self::SETTING_RESPECT_DO_NOT_TRACK,
            self::DEFAULT_RESPECT_DO_NOT_TRACK,
            'boolval'
        );
        \DevOwl\RealCookieBanner\settings\General::enableOptionAutoload(
            self::SETTING_COOKIE_DURATION,
            self::DEFAULT_COOKIE_DURATION,
            'intval'
        );
        \DevOwl\RealCookieBanner\settings\General::enableOptionAutoload(
            self::SETTING_SAVE_IP,
            self::DEFAULT_SAVE_IP,
            'boolval'
        );
        \DevOwl\RealCookieBanner\settings\General::enableOptionAutoload(
            self::SETTING_AGE_NOTICE,
            self::DEFAULT_AGE_NOTICE,
            'boolval'
        );
        $this->overrideEnableOptionsAutoload();
    }
    /**
     * Register settings.
     */
    public function register() {
        register_setting(self::OPTION_GROUP, self::SETTING_ACCEPT_ALL_FOR_BOTS, [
            'type' => 'boolean',
            'show_in_rest' => \true
        ]);
        register_setting(self::OPTION_GROUP, self::SETTING_RESPECT_DO_NOT_TRACK, [
            'type' => 'boolean',
            'show_in_rest' => \true
        ]);
        register_setting(self::OPTION_GROUP, self::SETTING_COOKIE_DURATION, [
            'type' => 'number',
            'show_in_rest' => \true
        ]);
        register_setting(self::OPTION_GROUP, self::SETTING_SAVE_IP, ['type' => 'boolean', 'show_in_rest' => \true]);
        register_setting(self::OPTION_GROUP, self::SETTING_AGE_NOTICE, ['type' => 'boolean', 'show_in_rest' => \true]);
        $this->overrideRegister();
    }
    /**
     * Check if bots should acceppt all cookies automatically.
     *
     * @return boolean
     */
    public function isAcceptAllForBots() {
        return get_option(self::SETTING_ACCEPT_ALL_FOR_BOTS);
    }
    /**
     * Check if "Do not Track" header is respected.
     *
     * @return boolean
     */
    public function isRespectDoNotTrack() {
        return get_option(self::SETTING_RESPECT_DO_NOT_TRACK);
    }
    /**
     * Check if IPs should be saved in plain in database.
     *
     * @return boolean
     */
    public function isSaveIpEnabled() {
        return get_option(self::SETTING_SAVE_IP);
    }
    /**
     * Check if age notice hint is enabled
     *
     * @return boolean
     */
    public function isAgeNoticeEnabled() {
        return get_option(self::SETTING_AGE_NOTICE);
    }
    /**
     * Get the cookie duration for the consent cookies.
     *
     * @return int
     */
    public function getCookieDuration() {
        return get_option(self::SETTING_COOKIE_DURATION);
    }
    /**
     * The cookie duration may not be greater than 365 days.
     *
     * @param mixed $value
     * @since 1.10
     */
    public function option_cookie_duration($value) {
        // Use `is_numeric` as it can be a string
        if (\is_numeric($value) && \intval($value) > 365) {
            return 365;
        }
        return $value;
    }
    /**
     * Get singleton instance.
     *
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\settings\Consent()) : self::$me;
    }
}
