<?php

namespace DevOwl\RealCookieBanner\comp\migration;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractSyncPlugin;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\settings\CookieGroup;
use DevOwl\RealCookieBanner\settings\TCF;
use DevOwl\RealCookieBanner\settings\CountryBypass;
use DevOwl\RealCookieBanner\Utils;
use DevOwl\RealCookieBanner\view\BannerCustomize;
use DevOwl\RealCookieBanner\view\customize\banner\individual\Texts as IndividualTexts;
use DevOwl\RealCookieBanner\view\customize\banner\Texts;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Migration for Major version 2.
 *
 * @see https://app.clickup.com/t/g75t1p
 */
class DashboardTileMigrationMajor2 extends \DevOwl\RealCookieBanner\comp\migration\AbstractDashboardTileMigration {
    const DELETE_LANGUAGES = ['de', 'en'];
    const DELETE_OPTIONS_TEXTS = [
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_HEADLINE,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_DESCRIPTION,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_EPRIVACY_USA,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_AGE_NOTICE,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_AGE_NOTICE_BLOCKER,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_CONSENT_FORWARDING,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_ACCEPT_ALL,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_ACCEPT_ESSENTIALS,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_ACCEPT_INDIVIDUAL,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_POWERED_BY_TEXT,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_BLOCKER_HEADLINE,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_BLOCKER_LINK_SHOW_MISSING,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_BLOCKER_LOAD_BUTTON,
        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SETTING_BLOCKER_ACCEPT_INFO,
        \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SETTING_HEADLINE,
        \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SETTING_DESCRIPTION,
        \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SETTING_SAVE,
        \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SETTING_SHOW_MORE,
        \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SETTING_HIDE_MORE
    ];
    // Documented in AbstractDashboardTileMigration
    public function __construct() {
        parent::__construct();
        $isTcfActive = \DevOwl\RealCookieBanner\settings\TCF::getInstance()->isActive();
        $isCountryBypassActive = \DevOwl\RealCookieBanner\settings\CountryBypass::getInstance()->isActive();
        $core = \DevOwl\RealCookieBanner\Core::getInstance();
        if ($this->isActive()) {
            add_filter('RCB/Presets/Banner', [$this, 'bannerPresets']);
        }
        $this->addAction(
            'texts',
            __('Updated texts (German, English)', RCB_TD),
            \join(' ', [
                __(
                    'We have adjusted the texts in the cookie banner and service groups (not in cookie/content blocker templates). The adjustments improve the legal security of your cookie banner, as the general purpose of the consent is now more clearly described, and we have added legal teachings. If you want to use the TCF compatibility, the previous texts are no longer permitted. You can let previous texts be overwritten by the new texts. All texts can be customized in the WordPress Customizer or in Services (Cookies). After applying the texts, be sure to verify if the new texts apply to your website!',
                    RCB_TD
                ),
                \sprintf(
                    // translators:
                    __(
                        'Before you apply the new texts, you can %1$screate an export%2$s to backup the old texts.',
                        RCB_TD
                    ),
                    '<a href="#/import">',
                    '</a>'
                )
            ]),
            [
                'linkText' => __('Apply new texts', RCB_TD),
                'confirmText' => __(
                    'Are you sure? All your current texts will be overwritten (this does not include service and content blocker texts!).',
                    RCB_TD
                ),
                'callback' => [$this, 'applyNewTexts']
            ]
        )
            ->addAction(
                'tcf',
                __('TCF Compatibility', RCB_TD),
                __(
                    'You can now obtain consent according to the TCF standard from IAB Europe. You need this type of consent mostly when you work with big marketers, e.g. Google Adsense, so they can be sure that you have obtained consent from your visitors. If you turn on TCF compatibility, some features of Real Cookie Banner will change so that your cookie banner is compliant with the rules of the standard.',
                    RCB_TD
                ),
                [
                    'linkText' => $isTcfActive ? __('Already enabled', RCB_TD) : __('Enable TCF compatibility', RCB_TD),
                    'linkDisabled' => $isTcfActive,
                    'callback' => $this->getConfigUrl('/settings/tcf'),
                    'previewImage' => $core->getBaseAssetsUrl(__('pro-modal/tcf-compatibility.png', RCB_TD))
                ]
            )
            ->addAction(
                'geo-restriction',
                __('Geo-restriction', RCB_TD),
                __(
                    'Cookie banners must be displayed only for users from certain countries. Real Cookie Banner can now detect which country your visitor comes from and depending on that decide whether to display a cookie banner. This way you don\'t annoy e.g. visitors from non EU countries.',
                    RCB_TD
                ),
                [
                    'linkText' => $isCountryBypassActive
                        ? __('Already enabled', RCB_TD)
                        : __('Enable Geo-restriction', RCB_TD),
                    'linkDisabled' => $isCountryBypassActive,
                    'callback' => $this->getConfigUrl('/settings/country-bypass'),
                    'previewImage' => $core->getBaseAssetsUrl(__('pro-modal/geo-restriction.png', RCB_TD))
                ]
            )
            ->addAction(
                'standard-design',
                __('Standard banner design', RCB_TD),
                __(
                    'We have added a new standard design for the cookie banner, which makes a more friendly and clean impression. If you are using the standard design so far, it\'s worth a look if the new one fits better to your website!',
                    RCB_TD
                ),
                [
                    'linkText' => __('View new design', RCB_TD),
                    'callback' => add_query_arg(
                        [
                            'autofocus[panel]' => \DevOwl\RealCookieBanner\view\BannerCustomize::PANEL_MAIN,
                            'customAutofocus[rcb-presets]' => 1,
                            'return' => wp_get_raw_referer()
                        ],
                        admin_url('customize.php')
                    )
                ]
            );
    }
    /**
     * Show a "NEW!" badge to the new standard presets.
     *
     * @param array $presets
     */
    public function bannerPresets($presets) {
        $badge = ['success', __('NEW!', RCB_TD)];
        $presets['light']['tags'][] = $badge;
        $presets['light-banner']['tags'][] = $badge;
        return $presets;
    }
    /**
     * Apply new customizer and groups texts and overwrite existing.
     *
     * @param array $result
     */
    public function applyNewTexts($result) {
        if (!is_wp_error($result)) {
            $compLanguage = \DevOwl\RealCookieBanner\Core::getInstance()->getCompLanguage();
            // Prepare a list of all languages so we can also consider `LanguageDependingOption` options
            $suffixes = [];
            if ($compLanguage instanceof \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractSyncPlugin) {
                foreach ($compLanguage->getActiveLanguages() as $locale) {
                    foreach (self::DELETE_LANGUAGES as $langToDelete) {
                        if (\DevOwl\RealCookieBanner\Utils::startsWith(\strtolower($locale), $langToDelete)) {
                            $suffixes[] = '-' . $locale;
                            // See `LanguageDependingOption::getOptionName`
                            continue;
                        }
                    }
                }
            }
            // Delete customizer options
            $deletedOptionsTexts = [];
            foreach (self::DELETE_OPTIONS_TEXTS as $optionName) {
                if (delete_option($optionName)) {
                    $deletedOptionsTexts[] = $optionName;
                }
                foreach ($suffixes as $suffix) {
                    $suffixOptionName = $optionName . $suffix;
                    if (delete_option($suffixOptionName)) {
                        $deletedOptionsTexts[] = $suffixOptionName;
                    }
                }
            }
            // Update group texts
            if ($compLanguage instanceof \DevOwl\RealCookieBanner\Vendor\DevOwl\Multilingual\AbstractSyncPlugin) {
                // Only sync-plugins create clones of terms
                $compLanguage->iterateAllLanguagesContext(function ($locale) {
                    $this->applyNewGroupTexts($locale);
                });
            } else {
                $this->applyNewGroupTexts(get_locale());
            }
            $result['success'] = \true;
            $result['deleted_options_texts'] = $deletedOptionsTexts;
            $result['redirect'] = add_query_arg(
                [
                    'autofocus[section]' => \DevOwl\RealCookieBanner\view\customize\banner\Texts::SECTION,
                    'return' => wp_get_raw_referer()
                ],
                admin_url('customize.php')
            );
        }
        return $result;
    }
    /**
     * Upgrade the group texts.
     *
     * @param string $locale
     */
    public function applyNewGroupTexts($locale) {
        // Check if we have texts for this language
        $found = \false;
        foreach (self::DELETE_LANGUAGES as $langToDelete) {
            if (\DevOwl\RealCookieBanner\Utils::startsWith(\strtolower($locale), $langToDelete)) {
                $found = \true;
                break;
            }
        }
        if (!$found) {
            return;
        }
        // Update terms
        $td = \DevOwl\RealCookieBanner\comp\language\Hooks::getInstance()->createTemporaryTextDomain();
        $groupDescriptions = \DevOwl\RealCookieBanner\settings\CookieGroup::getInstance()->getDefaultDescriptions();
        $groupNames = [
            'essential' => __('Essential', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
            'functional' => __('Functional', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
            'statistics' => __('Statistics', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
            'statistic' => __('Statistic', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
            'marketing' => __('Marketing', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED)
        ];
        foreach ($groupDescriptions as $type => $description) {
            $name = $groupNames[$type] ?? null;
            if (empty($name)) {
                continue;
            }
            // Find term by name
            $term = get_term_by('name', $name, \DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME);
            if ($term === \false) {
                continue;
            }
            $term = $term->term_id;
            wp_update_term($term, \DevOwl\RealCookieBanner\settings\CookieGroup::TAXONOMY_NAME, [
                'description' => $description
            ]);
        }
        $td->teardown();
    }
    // Documented in AbstractDashboardTileMigration
    public function getId() {
        return 'v2';
    }
    // Documented in AbstractDashboardTileMigration
    public function getHeadline() {
        return __('Updates in v2.0: Make your cookie banner more safe!', RCB_TD);
    }
    // Documented in AbstractDashboardTileMigration
    public function getDescription() {
        return \sprintf(
            // translators:
            __(
                'We have released a major update with Real Cookie Banner 2.0. Find out what\'s new in our %1$sblog article%2$s. <strong>You should definitely take a look at the following points, as we have adjusted the behavior of the cookie banner.</strong> All changes can be optionally activated or ignored. We will not change your cookie banner fundamentally without your consent.',
                RCB_TD
            ),
            \sprintf(
                '<a href="%s" target="_blank">',
                __('https://devowl.io/2021/real-cookie-banner-2-0-cookie-consent/', RCB_TD)
            ),
            '</a>'
        );
    }
    // Documented in AbstractDashboardTileMigration
    public function isActive() {
        return $this->hasMajorPreviouslyInstalled(1);
    }
    // Documented in AbstractDashboardTileMigration
    public function dismiss() {
        return $this->removeMajorVersionFromPreviouslyInstalled(1);
    }
}
