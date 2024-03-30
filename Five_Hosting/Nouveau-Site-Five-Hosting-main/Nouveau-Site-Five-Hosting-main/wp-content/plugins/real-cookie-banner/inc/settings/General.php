<?php

namespace DevOwl\RealCookieBanner\settings;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\lite\settings\General as LiteGeneral;
use DevOwl\RealCookieBanner\overrides\interfce\settings\IOverrideGeneral;
use DevOwl\RealCookieBanner\view\customize\banner\Legal;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * General settings.
 */
class General implements \DevOwl\RealCookieBanner\overrides\interfce\settings\IOverrideGeneral {
    use LiteGeneral;
    use UtilsProvider;
    const OPTION_GROUP = 'options';
    const SETTING_BANNER_ACTIVE = RCB_OPT_PREFIX . '-banner-active';
    const SETTING_BLOCKER_ACTIVE = RCB_OPT_PREFIX . '-blocker-active';
    /**
     * Refresh site after consent.
     *
     * @deprecated See #m9dey3
     */
    const SETTING_REFRESH_SITE_AFTER_CONSENT = RCB_OPT_PREFIX . '-refresh-site-after-consent';
    const SETTING_IMPRINT_ID = \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_IMPRINT;
    const SETTING_IMPRINT_EXTERNAL_URL = \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_IMPRINT_EXTERNAL_URL;
    const SETTING_IMPRINT_IS_EXTERNAL_URL = \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_IMPRINT_IS_EXTERNAL_URL;
    const SETTING_PRIVACY_POLICY_ID = \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_PRIVACY_POLICY;
    const SETTING_PRIVACY_POLICY_EXTERNAL_URL = \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_PRIVACY_POLICY_EXTERNAL_URL;
    const SETTING_PRIVACY_POLICY_IS_EXTERNAL_URL = \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_PRIVACY_POLICY_IS_EXTERNAL_URL;
    const SETTING_HIDE_PAGE_IDS = RCB_OPT_PREFIX . '-hide-page-ids';
    const SETTING_SET_COOKIES_VIA_MANAGER = RCB_OPT_PREFIX . '-set-cookies-via-manager';
    const DEFAULT_BANNER_ACTIVE = \false;
    const DEFAULT_BLOCKER_ACTIVE = \true;
    /**
     * Refresh site after consent.
     *
     * @deprecated See #m9dey3
     */
    const DEFAULT_REFRESH_SITE_AFTER_CONSENT = \false;
    const DEFAULT_IMPRINT_ID = \DevOwl\RealCookieBanner\view\customize\banner\Legal::DEFAULT_IMPRINT;
    const DEFAULT_IMPRINT_EXTERNAL_URL = \DevOwl\RealCookieBanner\view\customize\banner\Legal::DEFAULT_IMPRINT_EXTERNAL_URL;
    const DEFAULT_IMPRINT_IS_EXTERNAL_URL = \DevOwl\RealCookieBanner\view\customize\banner\Legal::DEFAULT_IMPRINT_IS_EXTERNAL_URL;
    const DEFAULT_PRIVACY_POLICY_ID = \DevOwl\RealCookieBanner\view\customize\banner\Legal::DEFAULT_PRIVACY_POLICY;
    const DEFAULT_PRIVACY_POLICY_EXTERNAL_URL = \DevOwl\RealCookieBanner\view\customize\banner\Legal::DEFAULT_PRIVACY_POLICY_EXTERNAL_URL;
    const DEFAULT_PRIVACY_POLICY_IS_EXTERNAL_URL = \DevOwl\RealCookieBanner\view\customize\banner\Legal::DEFAULT_PRIVACY_POLICY_IS_EXTERNAL_URL;
    const DEFAULT_HIDE_PAGE_IDS = '';
    const DEFAULT_SET_COOKIES_VIA_MANAGER = 'none';
    /**
     * Singleton instance.
     *
     * @var General
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
        self::enableOptionAutoload(self::SETTING_BANNER_ACTIVE, self::DEFAULT_BANNER_ACTIVE, 'boolval');
        self::enableOptionAutoload(self::SETTING_BLOCKER_ACTIVE, self::DEFAULT_BLOCKER_ACTIVE, 'boolval');
        self::enableOptionAutoload(
            self::SETTING_REFRESH_SITE_AFTER_CONSENT,
            self::DEFAULT_REFRESH_SITE_AFTER_CONSENT,
            'boolval'
        );
        self::enableOptionAutoload(self::SETTING_IMPRINT_ID, self::DEFAULT_IMPRINT_ID, 'intval');
        self::enableOptionAutoload(self::SETTING_IMPRINT_EXTERNAL_URL, self::DEFAULT_IMPRINT_EXTERNAL_URL);
        self::enableOptionAutoload(
            self::SETTING_IMPRINT_IS_EXTERNAL_URL,
            self::DEFAULT_IMPRINT_IS_EXTERNAL_URL,
            'boolval'
        );
        self::enableOptionAutoload(self::SETTING_PRIVACY_POLICY_ID, $this->getDefaultPrivacyPolicy(), 'intval');
        self::enableOptionAutoload(
            self::SETTING_PRIVACY_POLICY_EXTERNAL_URL,
            self::DEFAULT_PRIVACY_POLICY_EXTERNAL_URL
        );
        self::enableOptionAutoload(
            self::SETTING_PRIVACY_POLICY_IS_EXTERNAL_URL,
            self::DEFAULT_PRIVACY_POLICY_IS_EXTERNAL_URL,
            'boolval'
        );
        $this->overrideEnableOptionsAutoload();
    }
    /**
     * Register settings.
     */
    public function register() {
        register_setting(self::OPTION_GROUP, self::SETTING_BANNER_ACTIVE, [
            'type' => 'boolean',
            'show_in_rest' => \true
        ]);
        register_setting(self::OPTION_GROUP, self::SETTING_BLOCKER_ACTIVE, [
            'type' => 'boolean',
            'show_in_rest' => \true
        ]);
        register_setting(self::OPTION_GROUP, self::SETTING_REFRESH_SITE_AFTER_CONSENT, [
            'type' => 'boolean',
            'show_in_rest' => \true
        ]);
        register_setting(self::OPTION_GROUP, self::SETTING_IMPRINT_ID, ['type' => 'number', 'show_in_rest' => \true]);
        register_setting(self::OPTION_GROUP, self::SETTING_IMPRINT_EXTERNAL_URL, [
            'type' => 'string',
            'show_in_rest' => \true
        ]);
        register_setting(self::OPTION_GROUP, self::SETTING_IMPRINT_IS_EXTERNAL_URL, [
            'type' => 'boolean',
            'show_in_rest' => \true
        ]);
        register_setting(self::OPTION_GROUP, self::SETTING_PRIVACY_POLICY_ID, [
            'type' => 'number',
            'show_in_rest' => \true
        ]);
        register_setting(self::OPTION_GROUP, self::SETTING_PRIVACY_POLICY_EXTERNAL_URL, [
            'type' => 'string',
            'show_in_rest' => \true
        ]);
        register_setting(self::OPTION_GROUP, self::SETTING_PRIVACY_POLICY_IS_EXTERNAL_URL, [
            'type' => 'boolean',
            'show_in_rest' => \true
        ]);
        $this->overrideRegister();
    }
    /**
     * Is the banner active?
     *
     * @return boolean
     */
    public function isBannerActive() {
        return get_option(self::SETTING_BANNER_ACTIVE);
    }
    /**
     * Is the content blocker active?
     *
     * @return boolean
     */
    public function isBlockerActive() {
        return get_option(self::SETTING_BLOCKER_ACTIVE);
    }
    /**
     * Should the page refresh after consent?
     *
     * @return boolean
     */
    public function isRefreshSiteAfterConsent() {
        return get_option(self::SETTING_REFRESH_SITE_AFTER_CONSENT);
    }
    /**
     * Get the imprint page URL.
     *
     * @param mixed $default
     * @return string
     */
    public function getImprintPageUrl($default = \false) {
        $imprintIsExternalUrl = get_option(self::SETTING_IMPRINT_IS_EXTERNAL_URL);
        if ($imprintIsExternalUrl) {
            $imprintExternalUrl = get_option(self::SETTING_IMPRINT_EXTERNAL_URL);
            if (!empty($imprintExternalUrl)) {
                return $imprintExternalUrl;
            }
        } else {
            $id = get_option(self::SETTING_IMPRINT_ID);
            if ($id > 0) {
                $permalink = get_permalink($id);
                if ($permalink !== \false) {
                    return $permalink;
                }
            }
        }
        return $default;
    }
    /**
     * Get the privacy policy page URL.
     *
     * @param mixed $default
     * @return string
     */
    public function getPrivacyPolicyUrl($default = \false) {
        $privacyPolicyIsExternalUrl = get_option(self::SETTING_PRIVACY_POLICY_IS_EXTERNAL_URL);
        if ($privacyPolicyIsExternalUrl) {
            $privacyPolicyExternalUrl = get_option(self::SETTING_PRIVACY_POLICY_EXTERNAL_URL);
            if (!empty($privacyPolicyExternalUrl)) {
                return $privacyPolicyExternalUrl;
            }
        } else {
            $id = get_option(self::SETTING_PRIVACY_POLICY_ID, $this->getDefaultPrivacyPolicy());
            if ($id > 0) {
                $permalink = get_permalink($id);
                if ($permalink !== \false) {
                    return $permalink;
                }
            }
        }
        return $default;
    }
    /**
     * Get default privacy policy post ID.
     */
    public function getDefaultPrivacyPolicy() {
        return \intval(get_option('wp_page_for_privacy_policy', self::DEFAULT_PRIVACY_POLICY_ID));
    }
    /**
     * Return a map of `post_id` to permalink URL for imprint and privacy policy.
     */
    public function getPermalinkMap() {
        $result = [];
        $imprintId = get_option(self::SETTING_IMPRINT_ID);
        $imprintIsExternalUrl = get_option(self::SETTING_IMPRINT_IS_EXTERNAL_URL);
        if ($imprintId > 0 && !$imprintIsExternalUrl) {
            $result[$imprintId] = $this->getImprintPageUrl();
        }
        $privacyPolicyId = get_option(self::SETTING_PRIVACY_POLICY_ID);
        $privacyPolicyIsExternalUrl = get_option(self::SETTING_PRIVACY_POLICY_IS_EXTERNAL_URL);
        if ($privacyPolicyId > 0 && !$privacyPolicyIsExternalUrl) {
            $result[$privacyPolicyId] = $this->getPrivacyPolicyUrl();
        }
        return $result;
    }
    /**
     * Get singleton instance.
     *
     * @return General
     * @codeCoverageIgnore
     */
    public static function getInstance() {
        return self::$me === null ? (self::$me = new \DevOwl\RealCookieBanner\settings\General()) : self::$me;
    }
    /**
     * Add an option to autoloading and also with default.
     *
     * @param string $optionName
     * @param mixed $default
     * @param callable $filter
     */
    public static function enableOptionAutoload($optionName, $default, $filter = null) {
        // Avoid overwriting and read current
        $currentValue = get_option($optionName, $default);
        $newValue = $filter === null ? $currentValue : \call_user_func($filter, $currentValue);
        add_option($optionName, $newValue);
        if ($filter !== null) {
            add_filter('option_' . $optionName, $filter);
        }
    }
}
