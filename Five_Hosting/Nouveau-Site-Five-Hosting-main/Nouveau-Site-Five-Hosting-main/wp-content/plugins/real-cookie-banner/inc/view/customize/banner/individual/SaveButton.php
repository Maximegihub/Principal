<?php

namespace DevOwl\RealCookieBanner\view\customize\banner\individual;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CssMarginInput;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\view\BannerCustomize;
use DevOwl\RealCookieBanner\view\customize\banner\BodyDesign;
use WP_Customize_Color_Control;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * "Save" button in Individual Privacy settings.
 */
class SaveButton {
    use UtilsProvider;
    const SECTION = \DevOwl\RealCookieBanner\view\BannerCustomize::PANEL_MAIN . '-save-button';
    const HEADLINE_FONT = self::SECTION . '-headline-font';
    const HEADLINE_BORDER = self::SECTION . '-headline-border';
    const HEADLINE_HOVER = self::SECTION . '-headline-hover';
    const SETTING = RCB_OPT_PREFIX . '-save-button';
    const SETTING_TYPE = self::SETTING . '-type';
    const SETTING_PADDING = self::SETTING . '-padding';
    const SETTING_BG = self::SETTING . '-bg';
    const SETTING_TEXT_ALIGN = self::SETTING . '-text-align';
    const SETTING_FONT_SIZE = self::SETTING . '-font-size';
    const SETTING_FONT_COLOR = self::SETTING . '-font-color';
    const SETTING_FONT_WEIGHT = self::SETTING . '-font-weight';
    const SETTING_BORDER_WIDTH = self::SETTING . '-border-width';
    const SETTING_BORDER_COLOR = self::SETTING . '-border-color';
    const SETTING_HOVER_BG = self::SETTING . '-hover-bg';
    const SETTING_HOVER_BORDER_COLOR = self::SETTING . '-hover-border-color';
    const SETTING_HOVER_FONT_COLOR = self::SETTING . '-hover-font-color';
    const DEFAULT_TYPE = 'button';
    const DEFAULT_PADDING = \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_PADDING;
    const DEFAULT_BG = \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_BG;
    const DEFAULT_TEXT_ALIGN = \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_TEXT_ALIGN;
    const DEFAULT_FONT_SIZE = \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE;
    const DEFAULT_FONT_COLOR = \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR;
    const DEFAULT_FONT_WEIGHT = \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::DEFAULT_BUTTON_ACCEPT_ALL_FONT_WEIGHT;
    const DEFAULT_BORDER_WIDTH = \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH;
    const DEFAULT_BORDER_COLOR = \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR;
    const DEFAULT_HOVER_BG = \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG;
    const DEFAULT_HOVER_BORDER_COLOR = \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR;
    const DEFAULT_HOVER_FONT_COLOR = \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR;
    /**
     * Return arguments for this section.
     */
    public function args() {
        return [
            'name' => 'saveButton',
            'title' => __('"Save" button', RCB_TD),
            'controls' => [
                self::SETTING_TYPE => [
                    'name' => 'type',
                    'label' => __('Type', RCB_TD),
                    'type' => 'radio',
                    'choices' => ['button' => __('Button', RCB_TD), 'link' => __('Link', RCB_TD)],
                    'setting' => ['default' => self::DEFAULT_TYPE]
                ],
                self::SETTING_PADDING => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CssMarginInput::class,
                    'name' => 'padding',
                    'label' => __('Padding', RCB_TD),
                    'description' => __('Define the inner distance of the button.', RCB_TD),
                    'dashicon' => 'editor-contract',
                    'setting' => ['default' => self::DEFAULT_PADDING]
                ],
                self::SETTING_BG => [
                    'name' => 'bg',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Background color', RCB_TD),
                    'setting' => ['default' => self::DEFAULT_BG, 'sanitize_callback' => 'sanitize_hex_color']
                ],
                self::SETTING_TEXT_ALIGN => [
                    'name' => 'textAlign',
                    'label' => __('Text align', RCB_TD),
                    'type' => 'select',
                    'choices' => \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::getTextAlignChoices(),
                    'setting' => ['default' => self::DEFAULT_TEXT_ALIGN]
                ],
                self::HEADLINE_FONT => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'saveButtonFont',
                    'label' => __('Font', RCB_TD)
                ],
                self::SETTING_FONT_SIZE => [
                    'name' => 'fontSize',
                    'label' => __('Size', RCB_TD),
                    'type' => 'range',
                    'input_attrs' => ['min' => 10, 'max' => 30, 'step' => 0],
                    'setting' => ['default' => self::DEFAULT_FONT_SIZE, 'sanitize_callback' => 'absint']
                ],
                self::SETTING_FONT_COLOR => [
                    'name' => 'fontColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Color', RCB_TD),
                    'setting' => ['default' => self::DEFAULT_FONT_COLOR, 'sanitize_callback' => 'sanitize_hex_color']
                ],
                self::SETTING_FONT_WEIGHT => [
                    'name' => 'fontWeight',
                    'label' => __('Font weight', RCB_TD),
                    'type' => 'select',
                    'choices' => \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::getFontWeightChoices(),
                    'setting' => ['default' => self::DEFAULT_FONT_WEIGHT]
                ],
                self::HEADLINE_BORDER => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'saveButtonBorder',
                    'label' => __('Border', RCB_TD)
                ],
                self::SETTING_BORDER_WIDTH => [
                    'name' => 'borderWidth',
                    'type' => 'number',
                    'input_attrs' => ['min' => 0],
                    'label' => __('Border width (px)', RCB_TD),
                    'setting' => ['default' => self::DEFAULT_BORDER_WIDTH, 'sanitize_callback' => 'absint']
                ],
                self::SETTING_BORDER_COLOR => [
                    'name' => 'borderColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Color', RCB_TD),
                    'setting' => ['default' => self::DEFAULT_BORDER_COLOR, 'sanitize_callback' => 'sanitize_hex_color']
                ],
                self::HEADLINE_HOVER => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'saveButtonHover',
                    'label' => __('Transition on hover', RCB_TD),
                    'description' => __(
                        'When the user moves the mouse over the button/link, it changes its color.',
                        RCB_TD
                    )
                ],
                self::SETTING_HOVER_BG => [
                    'name' => 'hoverBg',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Background color', RCB_TD),
                    'setting' => ['default' => self::DEFAULT_HOVER_BG, 'sanitize_callback' => 'sanitize_hex_color']
                ],
                self::SETTING_HOVER_FONT_COLOR => [
                    'name' => 'hoverFontColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Font color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_HOVER_FONT_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_HOVER_BORDER_COLOR => [
                    'name' => 'hoverBorderColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Border color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_HOVER_BORDER_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ]
            ]
        ];
    }
}
