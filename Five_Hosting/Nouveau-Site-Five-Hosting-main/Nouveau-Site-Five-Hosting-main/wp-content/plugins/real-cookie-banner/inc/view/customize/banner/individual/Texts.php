<?php

namespace DevOwl\RealCookieBanner\view\customize\banner\individual;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\TinyMCE;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\comp\language\Hooks;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\view\BannerCustomize;
use DevOwl\RealCookieBanner\view\customize\banner\Texts as BannerTexts;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Cookie banner texts for "Individual Privacy" settings.
 */
class Texts {
    use UtilsProvider;
    const SECTION = \DevOwl\RealCookieBanner\view\BannerCustomize::PANEL_MAIN . '-individual-texts';
    const HEADLINE_GENERAL = self::SECTION . '-headline-general';
    const SETTING = RCB_OPT_PREFIX . '-individual-texts';
    const SETTING_HEADLINE = self::SETTING . '-headline';
    const SETTING_DESCRIPTION = self::SETTING . '-description';
    const SETTING_SAVE = self::SETTING . '-save';
    const SETTING_SHOW_MORE = self::SETTING . '-show-more';
    const SETTING_HIDE_MORE = self::SETTING . '-hide-more';
    /**
     * Return arguments for this section.
     */
    public function args() {
        $defaultButtonTexts = self::getDefaultButtonTexts();
        return [
            'name' => 'individualTexts',
            'title' => __('Texts', RCB_TD),
            'controls' => [
                self::HEADLINE_GENERAL => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'label' => __('General', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true
                ],
                self::SETTING_HEADLINE => [
                    'name' => 'headline',
                    'label' => __('Headline', RCB_TD),
                    'setting' => ['default' => $defaultButtonTexts['headline'], 'allowEmpty' => \true]
                ],
                self::SETTING_DESCRIPTION => [
                    'name' => 'description',
                    'label' => __('Description', RCB_TD),
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\TinyMCE::class,
                    'type' => 'textarea',
                    'setting' => [
                        'default' => $defaultButtonTexts['description'],
                        'sanitize_callback' => 'wp_kses_post',
                        'allowEmpty' => \true
                    ]
                ],
                self::SETTING_SAVE => [
                    'name' => 'save',
                    'label' => __('"Save" button/link', RCB_TD),
                    'setting' => ['default' => $defaultButtonTexts['save']]
                ],
                self::SETTING_SHOW_MORE => [
                    'name' => 'showMore',
                    'label' => __('"Show service information" link', RCB_TD),
                    'setting' => ['default' => $defaultButtonTexts['showMore']]
                ],
                self::SETTING_HIDE_MORE => [
                    'name' => 'hideMore',
                    'label' => __('"Hide service information" link', RCB_TD),
                    'setting' => ['default' => $defaultButtonTexts['hideMore']]
                ]
            ]
        ];
    }
    /**
     * Get the button default texts.
     */
    public static function getDefaultButtonTexts() {
        $tempTd = \DevOwl\RealCookieBanner\comp\language\Hooks::getInstance()->createTemporaryTextDomain();
        $defaults = [
            'headline' => __('Individual privacy preferences', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
            'description' => __(
                'We use cookies and similar technologies on our website and process personal data about you, such as your IP address. We also share this data with third parties. Data processing may be done with your consent or on the basis of a legitimate interest, which you can object to. You have the right to consent to essential services only and to modify or revoke your consent at a later time in the privacy policy. Below you will find an overview of all services used by this website. You can view detailed information about each service and agree to them individually or exercise your right to object.',
                \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED
            ),
            'save' => __('Save custom choices', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
            'showMore' => __('Show service information', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED),
            'hideMore' => __('Hide service information', \DevOwl\RealCookieBanner\comp\language\Hooks::TD_FORCED)
        ];
        $tempTd->teardown();
        return $defaults;
    }
}
