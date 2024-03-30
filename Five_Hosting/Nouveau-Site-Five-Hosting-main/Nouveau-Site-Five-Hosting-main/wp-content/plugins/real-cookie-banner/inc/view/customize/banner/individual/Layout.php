<?php

namespace DevOwl\RealCookieBanner\view\customize\banner\individual;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\view\BannerCustomize;
use DevOwl\RealCookieBanner\view\customize\banner\BodyDesign;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Cookie banner layout for "Individual Privacy" settings.
 */
class Layout {
    use UtilsProvider;
    const SECTION = \DevOwl\RealCookieBanner\view\BannerCustomize::PANEL_MAIN . '-individual-layout';
    const SETTING = RCB_OPT_PREFIX . '-individual-layout';
    const SETTING_INHERIT_DIALOG_MAX_WIDTH = self::SETTING . '-inherit-dialog-max-width';
    const SETTING_DIALOG_MAX_WIDTH = self::SETTING . '-dialog-max-width';
    const SETTING_INHERIT_BANNER_MAX_WIDTH = self::SETTING . '-inherit-banner-max-width';
    const SETTING_BANNER_MAX_WIDTH = self::SETTING . '-banner-max-width';
    const SETTING_DESCRIPTION_TEXT_ALIGN = self::SETTING . '-desc-text-align';
    const DEFAULT_INHERIT_DIALOG_MAX_WIDTH = \false;
    const DEFAULT_DIALOG_MAX_WIDTH = 970;
    const DEFAULT_INHERIT_BANNER_MAX_WIDTH = \true;
    const DEFAULT_BANNER_MAX_WIDTH = 1980;
    const DEFAULT_DESCRIPTION_TEXT_ALIGN = 'left';
    /**
     * Return arguments for this section.
     */
    public function args() {
        return [
            'name' => 'individualLayout',
            'title' => __('Layout', RCB_TD),
            'controls' => [
                self::SETTING_INHERIT_DIALOG_MAX_WIDTH => [
                    'name' => 'inheritDialogMaxWidth',
                    'label' => __('Adopt maximum width', RCB_TD),
                    'type' => 'checkbox',
                    'setting' => [
                        'default' => self::DEFAULT_INHERIT_DIALOG_MAX_WIDTH,
                        'sanitize_callback' => [
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::class,
                            'sanitize_checkbox'
                        ]
                    ]
                ],
                self::SETTING_DIALOG_MAX_WIDTH => [
                    'name' => 'dialogMaxWidth',
                    'label' => __('Maximum width (px)', RCB_TD),
                    'type' => 'number',
                    'input_attrs' => ['step' => 5, 'min' => 200],
                    'setting' => ['default' => self::DEFAULT_DIALOG_MAX_WIDTH, 'sanitize_callback' => 'absint']
                ],
                self::SETTING_INHERIT_BANNER_MAX_WIDTH => [
                    'name' => 'inheritBannerMaxWidth',
                    'label' => __('Adopt maximum width', RCB_TD),
                    'type' => 'checkbox',
                    'setting' => [
                        'default' => self::DEFAULT_INHERIT_BANNER_MAX_WIDTH,
                        'sanitize_callback' => [
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::class,
                            'sanitize_checkbox'
                        ]
                    ]
                ],
                self::SETTING_BANNER_MAX_WIDTH => [
                    'name' => 'bannerMaxWidth',
                    'label' => __('Maximum width (px)', RCB_TD),
                    'type' => 'number',
                    'input_attrs' => ['step' => 5, 'min' => 200],
                    'setting' => ['default' => self::DEFAULT_BANNER_MAX_WIDTH, 'sanitize_callback' => 'absint']
                ],
                self::SETTING_DESCRIPTION_TEXT_ALIGN => [
                    'name' => 'descriptionTextAlign',
                    'label' => __('Description text align', RCB_TD),
                    'type' => 'select',
                    'choices' => \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::getTextAlignChoices(),
                    'setting' => ['default' => self::DEFAULT_DESCRIPTION_TEXT_ALIGN]
                ]
            ]
        ];
    }
}
