<?php

namespace DevOwl\RealCookieBanner\view;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\Utils;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AttributesHelper;
use DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractOutputBufferPlugin;
use DevOwl\RealCookieBanner\Assets;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\Localization;
use DevOwl\RealCookieBanner\MyConsent;
use DevOwl\RealCookieBanner\settings\Blocker as SettingsBlocker;
use DevOwl\RealCookieBanner\settings\General as SettingsGeneral;
use DevOwl\RealCookieBanner\settings\Cookie;
use DevOwl\RealCookieBanner\settings\CookieGroup;
use DevOwl\RealCookieBanner\settings\General;
use DevOwl\RealCookieBanner\Utils as RealCookieBannerUtils;
use DevOwl\RealCookieBanner\view\customize\banner\BasicLayout;
use DevOwl\RealCookieBanner\view\customize\banner\CustomCss;
use DevOwl\RealCookieBanner\view\customize\banner\FooterDesign;
use DevOwl\RealCookieBanner\view\customize\banner\Legal;
use DevOwl\RealCookieBanner\view\customize\banner\Texts;
use WP_Admin_Bar;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Main banner.
 */
class Banner {
    use UtilsProvider;
    const ACTION_CLEAR_CURRENT_COOKIE = 'rcb-clear-current-cookie';
    const HTML_ATTRIBUTE_SKIP_IF_ACTIVE = 'skip-if-active';
    const HTML_ATTRIBUTE_SKIP_WRITE = 'skip-write';
    /**
     * Example:
     *
     * ```html
     * <script unique-write-name="gtag">console.log("this gets written to DOM");</script>
     * <script unique-write-name="gtag">console.log("this gets skipped");</script>
     * ```
     */
    const HTML_ATTRIBUTE_UNIQUE_WRITE_NAME = 'unique-write-name';
    /**
     * For "Code on page load" we need to ensure no other plugin is lazy loading it. E.g.
     * WP Rocket transforms inline scripts to `rocketlazyloadscript`.
     *
     * `js-extra` is a common string which does caching plugins or lazy loading plugins ignore
     * as it is similar to the `wp_localize_script` output tag.
     */
    const HTML_ATTRIBUTE_SKIP_LAZY_LOADING_PLUGINS = 'data-skip-lazy-load="js-extra"';
    /**
     * The customize handler
     *
     * @var BannerCustomize
     */
    private $customize;
    /**
     * C'tor.
     */
    private function __construct() {
        $this->customize = \DevOwl\RealCookieBanner\view\BannerCustomize::instance();
    }
    /**
     * Show a "Show banner again" button in the admin toolbar in frontend.
     *
     * @param WP_Admin_Bar $admin_bar
     */
    public function admin_bar_menu($admin_bar) {
        if (
            !is_admin() &&
            $this->shouldLoadAssets(\DevOwl\RealCookieBanner\Assets::$TYPE_FRONTEND) &&
            current_user_can(\DevOwl\RealCookieBanner\Core::MANAGE_MIN_CAPABILITY)
        ) {
            if (isset($_GET[self::ACTION_CLEAR_CURRENT_COOKIE])) {
                \DevOwl\RealCookieBanner\MyConsent::getInstance()->setCookie();
                wp_safe_redirect(add_query_arg(self::ACTION_CLEAR_CURRENT_COOKIE, \false));
                exit();
            }
            $icon = \sprintf(
                '<span class="custom-icon" style="float:left;width:22px !important;height:22px !important;margin: 5px 5px 0 !important;background-image:url(\'%s\');"></span>',
                \DevOwl\RealCookieBanner\view\ConfigPage::getIconAsSvgBase64()
            );
            $title = __('Show cookie banner again', RCB_TD);
            $admin_bar->add_menu([
                'id' => self::ACTION_CLEAR_CURRENT_COOKIE,
                'title' => $icon . $title,
                'href' => add_query_arg(self::ACTION_CLEAR_CURRENT_COOKIE, \true)
            ]);
        }
    }
    /**
     * Checks if the banner is active for the current page. This does not check any
     * user relevant conditions because they need to be done in frontend (caching).
     *
     * @param string $context The context passed to `Assets#enqueue_script_and_styles`
     * @see https://app.clickup.com/t/5yty88
     */
    public function shouldLoadAssets($context) {
        // Are we on website frontend?
        if (
            !\in_array(
                $context,
                [\DevOwl\RealCookieBanner\Assets::$TYPE_FRONTEND, \DevOwl\RealCookieBanner\Assets::$TYPE_LOGIN],
                \true
            ) ||
            \DevOwl\RealCookieBanner\Utils::isPageBuilder()
        ) {
            return \false;
        }
        // ALways show in customize preview
        if (is_customize_preview()) {
            return \true;
        }
        // Is the banner activated?
        if (!\DevOwl\RealCookieBanner\settings\General::getInstance()->isBannerActive()) {
            return \false;
        }
        return \true;
    }
    /**
     * Determine if the current page should not handle a predecision.
     * See also `useBannerPreDecisionGateway.tsx`.
     */
    public function isPreventPreDecision() {
        // Is the banner active on this site?
        if (is_page()) {
            $hideIds = \DevOwl\RealCookieBanner\settings\General::getInstance()->getAdditionalPageHideIds();
            $pageId = \DevOwl\RealCookieBanner\Core::getInstance()
                ->getCompLanguage()
                ->getOriginalPostId(get_the_ID(), 'page');
            if (\in_array($pageId, $hideIds, \true)) {
                return \true;
            }
        }
        // Is the banner hidden due a legal setting?
        if ($this->isHiddenDueLegal()) {
            return \true;
        }
        return \false;
    }
    /**
     * The `codeOnPageLoad` can be directly rendered to the Output Buffer cause
     * it does not stand in conflict with any caching plugin (no conditional rendering).
     */
    public function wp_head() {
        $groups = \DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->getOrdered();
        foreach ($groups as $group) {
            // Populate cookies
            $cookies = \DevOwl\RealCookieBanner\settings\Cookie::getInstance()->getOrdered($group->term_id);
            foreach ($cookies as $cookie) {
                $script = $cookie->metas[\DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_ON_PAGE_LOAD];
                if (!empty($script)) {
                    // Output and never do block them through Content Blocker
                    echo \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\AttributesHelper::skipHtmlTagsInContentBlocker(
                        $script,
                        self::HTML_ATTRIBUTE_SKIP_LAZY_LOADING_PLUGINS
                    );
                }
            }
        }
        // Web vitals: Avoid large rerenderings when the content blocker gets overlapped the original item
        // E.g. SVGs are loaded within the blocked element.
        echo \sprintf(
            '<style>[%s]:not(.rcb-content-blocker):not([%s]):not([%s^="children:"]){opacity:0!important;}</style>',
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_BLOCKER_ID,
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_UNBLOCKED_TRANSACTION_COMPLETE,
            \DevOwl\RealCookieBanner\Vendor\DevOwl\HeadlessContentBlocker\Constants::HTML_ATTRIBUTE_VISUAL_PARENT
        );
    }
    /**
     * Localize available cookie groups for frontend.
     */
    public function localizeGroups() {
        $output = [];
        $groups = \DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->getOrdered();
        foreach ($groups as $group) {
            $value = [
                'id' => $group->term_id,
                'name' => $group->name,
                'slug' => $group->slug,
                'description' => $group->description,
                'items' => []
            ];
            // Populate cookies
            $cookies = \DevOwl\RealCookieBanner\settings\Cookie::getInstance()->getOrdered($group->term_id);
            foreach ($cookies as $cookie) {
                $metas = $cookie->metas;
                foreach (
                    [
                        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_IN,
                        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_OPT_OUT,
                        \DevOwl\RealCookieBanner\settings\Cookie::META_NAME_CODE_ON_PAGE_LOAD
                    ]
                    as $codeKey
                ) {
                    $metas[$codeKey] = $this->modifySkipIfActive(
                        $metas[$codeKey],
                        $cookie->metas[\DevOwl\RealCookieBanner\settings\Blocker::META_NAME_PRESET_ID] ?? null
                    );
                }
                $value['items'][] = \array_merge(
                    ['id' => $cookie->ID, 'name' => $cookie->post_title, 'purpose' => $cookie->post_content],
                    $metas
                );
            }
            $output[] = $value;
        }
        return \DevOwl\RealCookieBanner\Core::getInstance()
            ->getCompLanguage()
            ->translateArray(
                $output,
                \array_merge(
                    \DevOwl\RealCookieBanner\settings\Cookie::SYNC_META_COPY,
                    \DevOwl\RealCookieBanner\Localization::COMMON_SKIP_KEYS,
                    ['poweredBy']
                )
            );
    }
    /**
     * Make `skip-if-active` work with comma-separated list of active plugins. That means, if
     * a given plugin is active it automatically skips the HTML tag.
     *
     * @param string $html
     * @param string $identifier The preset identifier (can be `null`)
     * @see https://regex101.com/r/gIPJRq/2
     */
    public function modifySkipIfActive($html, $identifier = null) {
        return \preg_replace_callback(
            \sprintf('/\\s+(%s=")([^"]+)(")/m', self::HTML_ATTRIBUTE_SKIP_IF_ACTIVE),
            /**
             * Available matches:
             *      $match[0] => Full string
             *      $match[1] => Tagname
             *      $match[2] => Comma separated string
             *      $match[3] => Quote
             */
            function ($m) use ($identifier) {
                $plugins = \explode(',', $m[2]);
                $result = \array_map(function ($plugin) use ($identifier) {
                    $isActive = \DevOwl\RealCookieBanner\Utils::isPluginActive($plugin);
                    if ($isActive && !empty($identifier)) {
                        // Documented in `DisablePresetByNeedsMiddleware`
                        // We need to also make sure here to deactivate the script if e.g. RankMath SEO has
                        // deactivated the Google Analytics functionality.
                        $isActive = apply_filters('RCB/Presets/Active', $isActive, $plugin, $identifier, 'cookie');
                    }
                    return $isActive;
                }, $plugins);
                return \in_array(\true, $result, \true) ? ' ' . self::HTML_ATTRIBUTE_SKIP_WRITE : '';
            },
            $html
        );
    }
    /**
     * Print out the overlay so it is server-side rendered (avoid flickering as early as possible).
     *
     * See also inlineStyle.tsx#overlay for more information!
     */
    public function wp_footer() {
        $customize = $this->getCustomize();
        $shouldLoadAssets = $this->shouldLoadAssets(\DevOwl\RealCookieBanner\Assets::$TYPE_FRONTEND);
        if ($shouldLoadAssets && !is_customize_preview()) {
            $type = $customize->getSetting(\DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE);
            $showOverlay = $customize->getSetting(
                \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY
            );
            $antiAdBlocker = bool_from_yn(
                $customize->getSetting(
                    \DevOwl\RealCookieBanner\view\customize\banner\CustomCss::SETTING_ANTI_AD_BLOCKER
                )
            );
            // Calculate background color
            $bgStyle = '';
            if ($showOverlay) {
                $overlayBg = $customize->getSetting(
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG
                );
                $overlayBgAlpha = $customize->getSetting(
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA
                );
                $bgStyle = \sprintf(
                    'background-color: %s;',
                    \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\Utils::calculateOverlay(
                        $overlayBg,
                        $overlayBgAlpha
                    )
                );
            }
            echo \sprintf(
                '<div id="%s" class="%s" data-bg="%s" style="%s position:fixed;top:0;left:0;right:0;bottom:0;z-index:99999;pointer-events:%s;display:none;" %s></div>%s',
                \DevOwl\RealCookieBanner\Core::getInstance()->getPageRequestUuid4(),
                $antiAdBlocker
                    ? ''
                    : \sprintf('rcb-banner rcb-banner-%s %s', $type, empty($bgStyle) ? 'overlay-deactivated' : ''),
                $bgStyle,
                $bgStyle,
                empty($bgStyle) ? 'none' : 'all',
                \DevOwl\RealCookieBanner\Core::getInstance()
                    ->getCompLanguage()
                    ->getSkipHTMLForTag(),
                get_option(\DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_POWERED_BY_LINK)
                    ? $this->poweredLink()
                    : ''
            );
        }
    }
    /**
     * Get the "Powered by" link.
     */
    protected function poweredLink() {
        $compLanguage = \DevOwl\RealCookieBanner\Core::getInstance()->getCompLanguage();
        // TranslatePress / Weglot: We need to ensure that the powered by texts are not translated through `gettext`
        // to avoid tags like `data-gettext`
        $poweredByTexts = \DevOwl\RealCookieBanner\view\customize\banner\Texts::getPoweredByLinkTexts(
            !$compLanguage instanceof \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractOutputBufferPlugin
        );
        $currentPoweredByText = get_option(
            \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_POWERED_BY_TEXT,
            0
        );
        $footerText = $compLanguage->translateArray([$poweredByTexts[$currentPoweredByText]])[0];
        return \sprintf(
            '<a href="%s" target="_blank" %s>%s</a>',
            __('https://devowl.io/wordpress-real-cookie-banner/', RCB_TD),
            $compLanguage->getSkipHTMLForTag(),
            $footerText
        );
    }
    /**
     * Checks if the overlay should be hidden due to legal setting. E. g. hide
     * cookie banner on imprint page. This is also a port of `useHiddenDueLegal.tsx`.
     */
    public function isHiddenDueLegal() {
        if (get_post_type() === 'page') {
            $pageId = \DevOwl\RealCookieBanner\Core::getInstance()
                ->getCompLanguage()
                ->getOriginalPostId(get_the_ID(), 'page');
            $customize = $this->getCustomize();
            $privacyPolicy = $customize->getSetting(
                \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_PRIVACY_POLICY
            );
            $privacyPolicyHide = $customize->getSetting(
                \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_PRIVACY_POLICY_HIDE
            );
            $imprint = $customize->getSetting(\DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_IMPRINT);
            $imprintHide = $customize->getSetting(
                \DevOwl\RealCookieBanner\view\customize\banner\Legal::SETTING_IMPRINT_HIDE
            );
            $checkArray = [];
            if ($imprintHide) {
                $checkArray[] = $imprint;
            }
            if ($privacyPolicyHide) {
                $checkArray[] = $privacyPolicy;
            }
            return \in_array($pageId, $checkArray, \true);
        }
    }
    /**
     * Getter.
     *
     * @codeCoverageIgnore
     */
    public function getCustomize() {
        return $this->customize;
    }
    /**
     * New instance.
     *
     * @codeCoverageIgnore
     */
    public static function instance() {
        return new \DevOwl\RealCookieBanner\view\Banner();
    }
}
