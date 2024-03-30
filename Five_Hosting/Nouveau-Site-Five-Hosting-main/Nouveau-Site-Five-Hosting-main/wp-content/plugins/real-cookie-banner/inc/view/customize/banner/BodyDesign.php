<?php

namespace DevOwl\RealCookieBanner\view\customize\banner;

use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CssMarginInput;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CustomHTML;
use DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline;
use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\view\BannerCustomize;
use WP_Customize_Color_Control;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Body design.
 */
class BodyDesign {
    use UtilsProvider;
    const SECTION = \DevOwl\RealCookieBanner\view\BannerCustomize::PANEL_MAIN . '-body-design';
    const CUSTOM_HTML_BUTTON_ACCEPT_ALL_ONE_ROW_LAYOUT_NOTICE =
        self::SECTION . '-custom-html-button-accept-all-one-row-layout-notice';
    const CUSTOM_HTML_BUTTON_ACCEPT_ALL_SIMILAR_NOTICE =
        self::SECTION . '-custom-html-button-accept-all-similar-notice';
    const HEADLINE_TEACHINGS = self::SECTION . '-headline-teachings';
    const HEADLINE_TEACHINGS_FONT = self::SECTION . '-headline-teachings-font';
    const HEADLINE_TEACHINGS_SEPARATOR = self::SECTION . '-headline-teachings-separator';
    const HEADLINE_BUTTON_ACCEPT_ALL = self::SECTION . '-headline-btn-accept-all';
    const HEADLINE_BUTTON_ACCEPT_ALL_FONT = self::SECTION . '-headline-btn-accept-all-font';
    const HEADLINE_BUTTON_ACCEPT_ALL_BORDER = self::SECTION . '-headline-btn-accept-all-border';
    const HEADLINE_BUTTON_ACCEPT_ALL_HOVER = self::SECTION . '-headline-btn-accept-all-hover';
    const HEADLINE_BUTTON_ACCEPT_ESSENTIALS = self::SECTION . '-headline-btn-accept-essentials';
    const HEADLINE_BUTTON_ACCEPT_ESSENTIALS_FONT = self::SECTION . '-headline-btn-accept-essentials-font';
    const HEADLINE_BUTTON_ACCEPT_ESSENTIALS_BORDER = self::SECTION . '-headline-btn-accept-essentials-border';
    const HEADLINE_BUTTON_ACCEPT_ESSENTIALS_HOVER = self::SECTION . '-headline-btn-accept-essentials-hover';
    const HEADLINE_BUTTON_ACCEPT_INDIVIDUAL = self::SECTION . '-headline-btn-accept-individual';
    const HEADLINE_BUTTON_ACCEPT_INDIVIDUAL_FONT = self::SECTION . '-headline-btn-accept-individual-font';
    const HEADLINE_BUTTON_ACCEPT_INDIVIDUAL_BORDER = self::SECTION . '-headline-btn-accept-individual-border';
    const HEADLINE_BUTTON_ACCEPT_INDIVIDUAL_HOVER = self::SECTION . '-headline-btn-accept-individual-hover';
    const SETTING = RCB_OPT_PREFIX . '-banner-body-design';
    const SETTING_PADDING = self::SETTING . '-padding';
    const SETTING_DESCRIPTION_INHERIT_FONT_SIZE = self::SETTING . '-desc-inherit-font-size';
    const SETTING_DESCRIPTION_FONT_SIZE = self::SETTING . '-desc-font-size';
    const SETTING_DOTTED_GROUPS_INHERIT_FONT_SIZE = self::SETTING . '-dotted-groups-inherit-font-size';
    const SETTING_DOTTED_GROUPS_FONT_SIZE = self::SETTING . '-dotted-groups-font-size';
    const SETTING_DOTTED_GROUPS_BULLET_COLOR = self::SETTING . '-dotted-groups-bullet-color';
    const SETTING_TEACHINGS_INHERIT_FONT_SIZE = self::SETTING . '-teachings-inherit-font-size';
    const SETTING_TEACHINGS_FONT_SIZE = self::SETTING . '-teachings-font-size';
    const SETTING_TEACHINGS_INHERIT_FONT_COLOR = self::SETTING . '-teachings-inherit-font-color';
    const SETTING_TEACHINGS_FONT_COLOR = self::SETTING . '-teachings-font-color';
    const SETTING_TEACHINGS_INHERIT_TEXT_ALIGN = self::SETTING . '-teachings-inherit-text-align';
    const SETTING_TEACHINGS_TEXT_ALIGN = self::SETTING . '-teachings-text-align';
    const SETTING_TEACHINGS_SEPARATOR_ACTIVE = self::SETTING . '-teachings-separator';
    const SETTING_TEACHINGS_SEPARATOR_WIDTH = self::SETTING . '-teachings-separator-width';
    const SETTING_TEACHINGS_SEPARATOR_HEIGHT = self::SETTING . '-teachings-separator-height';
    const SETTING_TEACHINGS_SEPARATOR_COLOR = self::SETTING . '-teachings-separator-color';
    const SETTING_BUTTON_ACCEPT_ALL_TYPE = self::SETTING . '-btn-accept-all-type';
    const SETTING_BUTTON_ACCEPT_ALL_ONE_ROW_LAYOUT = self::SETTING . '-btn-accept-all-one-row-layout';
    const SETTING_BUTTON_ACCEPT_ALL_PADDING = self::SETTING . '-btn-accept-all-padding';
    const SETTING_BUTTON_ACCEPT_ALL_BG = self::SETTING . '-btn-accept-all-bg';
    const SETTING_BUTTON_ACCEPT_ALL_TEXT_ALIGN = self::SETTING . '-btn-accept-all-text-align';
    const SETTING_BUTTON_ACCEPT_ALL_FONT_SIZE = self::SETTING . '-btn-accept-all-font-size';
    const SETTING_BUTTON_ACCEPT_ALL_FONT_COLOR = self::SETTING . '-btn-accept-all-font-color';
    const SETTING_BUTTON_ACCEPT_ALL_FONT_WEIGHT = self::SETTING . '-btn-accept-all-font-weight';
    const SETTING_BUTTON_ACCEPT_ALL_BORDER_WIDTH = self::SETTING . '-btn-accept-all-border-width';
    const SETTING_BUTTON_ACCEPT_ALL_BORDER_COLOR = self::SETTING . '-btn-accept-all-border-color';
    const SETTING_BUTTON_ACCEPT_ALL_HOVER_BG = self::SETTING . '-btn-accept-all-hover-bg';
    const SETTING_BUTTON_ACCEPT_ALL_HOVER_BORDER_COLOR = self::SETTING . '-btn-accept-all-hover-border-color';
    const SETTING_BUTTON_ACCEPT_ALL_HOVER_FONT_COLOR = self::SETTING . '-btn-accept-all-hover-font-color';
    const SETTING_BUTTON_ACCEPT_ESSENTIALS_TYPE = self::SETTING . '-btn-accept-essentials-type';
    const SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING = self::SETTING . '-btn-accept-essentials-padding';
    const SETTING_BUTTON_ACCEPT_ESSENTIALS_BG = self::SETTING . '-btn-accept-essentials-bg';
    const SETTING_BUTTON_ACCEPT_ESSENTIALS_TEXT_ALIGN = self::SETTING . '-btn-accept-essentials-text-align';
    const SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE = self::SETTING . '-btn-accept-essentials-font-size';
    const SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR = self::SETTING . '-btn-accept-essentials-font-color';
    const SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_WEIGHT = self::SETTING . '-btn-accept-essentials-font-weight';
    const SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH = self::SETTING . '-btn-accept-essentials-border-width';
    const SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR = self::SETTING . '-btn-accept-essentials-border-color';
    const SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG = self::SETTING . '-btn-accept-essentials-hover-bg';
    const SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =
        self::SETTING . '-btn-accept-essentials-hover-border-color';
    const SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR = self::SETTING . '-btn-accept-essentials-hover-font-color';
    const SETTING_BUTTON_ACCEPT_INDIVIDUAL_TYPE = self::SETTING . '-btn-accept-individual-type';
    const SETTING_BUTTON_ACCEPT_INDIVIDUAL_PADDING = self::SETTING . '-btn-accept-individual-padding';
    const SETTING_BUTTON_ACCEPT_INDIVIDUAL_BG = self::SETTING . '-btn-accept-individual-bg';
    const SETTING_BUTTON_ACCEPT_INDIVIDUAL_TEXT_ALIGN = self::SETTING . '-btn-accept-individual-text-align';
    const SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_SIZE = self::SETTING . '-btn-accept-individual-font-size';
    const SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR = self::SETTING . '-btn-accept-individual-font-color';
    const SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_WEIGHT = self::SETTING . '-btn-accept-individual-font-weight';
    const SETTING_BUTTON_ACCEPT_INDIVIDUAL_BORDER_WIDTH = self::SETTING . '-btn-accept-individual-border-width';
    const SETTING_BUTTON_ACCEPT_INDIVIDUAL_BORDER_COLOR = self::SETTING . '-btn-accept-individual-border-color';
    const SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_BG = self::SETTING . '-btn-accept-individual-hover-bg';
    const SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_BORDER_COLOR =
        self::SETTING . '-btn-accept-individual-hover-border-color';
    const SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR = self::SETTING . '-btn-accept-individual-hover-font-color';
    const DEFAULT_PADDING = [15, 20, 10, 20];
    const DEFAULT_DESCRIPTION_INHERIT_FONT_SIZE = \true;
    const DEFAULT_DESCRIPTION_FONT_SIZE = \DevOwl\RealCookieBanner\view\customize\banner\Design::DEFAULT_FONT_SIZE;
    const DEFAULT_DOTTED_GROUPS_INHERIT_FONT_SIZE = \true;
    const DEFAULT_DOTTED_GROUPS_FONT_SIZE = \DevOwl\RealCookieBanner\view\customize\banner\Design::DEFAULT_FONT_SIZE;
    const DEFAULT_DOTTED_GROUPS_BULLET_COLOR = '#15779b';
    const DEFAULT_TEACHINGS_INHERIT_FONT_SIZE = \false;
    const DEFAULT_TEACHINGS_FONT_SIZE = \DevOwl\RealCookieBanner\view\customize\banner\Design::DEFAULT_FONT_SIZE - 1;
    const DEFAULT_TEACHINGS_INHERIT_FONT_COLOR = \false;
    const DEFAULT_TEACHINGS_FONT_COLOR = '#7c7c7c';
    const DEFAULT_TEACHINGS_INHERIT_TEXT_ALIGN = \true;
    const DEFAULT_TEACHINGS_TEXT_ALIGN = \DevOwl\RealCookieBanner\view\customize\banner\Design::DEFAULT_TEXT_ALIGN;
    const DEFAULT_TEACHINGS_SEPARATOR_ACTIVE = \true;
    const DEFAULT_TEACHINGS_SEPARATOR_WIDTH = 50;
    const DEFAULT_TEACHINGS_SEPARATOR_HEIGHT = 1;
    const DEFAULT_TEACHINGS_SEPARATOR_COLOR = self::DEFAULT_DOTTED_GROUPS_BULLET_COLOR;
    const DEFAULT_BUTTON_ACCEPT_ALL_ONE_ROW_LAYOUT = \false;
    const DEFAULT_BUTTON_ACCEPT_ALL_PADDING = [10, 10, 10, 10];
    const DEFAULT_BUTTON_ACCEPT_ALL_BG = self::DEFAULT_DOTTED_GROUPS_BULLET_COLOR;
    const DEFAULT_BUTTON_ACCEPT_ALL_TEXT_ALIGN = 'center';
    const DEFAULT_BUTTON_ACCEPT_ALL_FONT_SIZE = 18;
    const DEFAULT_BUTTON_ACCEPT_ALL_FONT_COLOR = '#ffffff';
    const DEFAULT_BUTTON_ACCEPT_ALL_FONT_WEIGHT = 'normal';
    const DEFAULT_BUTTON_ACCEPT_ALL_BORDER_WIDTH = 0;
    const DEFAULT_BUTTON_ACCEPT_ALL_BORDER_COLOR = '#000000';
    const DEFAULT_BUTTON_ACCEPT_ALL_HOVER_BG = '#11607d';
    const DEFAULT_BUTTON_ACCEPT_ALL_HOVER_BORDER_COLOR = '#000000';
    const DEFAULT_BUTTON_ACCEPT_ALL_HOVER_FONT_COLOR = '#ffffff';
    const DEFAULT_BUTTON_ACCEPT_ESSENTIALS_PADDING = self::DEFAULT_BUTTON_ACCEPT_ALL_PADDING;
    const DEFAULT_BUTTON_ACCEPT_ESSENTIALS_BG = '#efefef';
    const DEFAULT_BUTTON_ACCEPT_ESSENTIALS_TEXT_ALIGN = 'center';
    const DEFAULT_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE = 16;
    const DEFAULT_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR = '#0a0a0a';
    const DEFAULT_BUTTON_ACCEPT_ESSENTIALS_FONT_WEIGHT = self::DEFAULT_BUTTON_ACCEPT_ALL_FONT_WEIGHT;
    const DEFAULT_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH = 0;
    const DEFAULT_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR = '#000000';
    const DEFAULT_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG = '#e8e8e8';
    const DEFAULT_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR = '#000000';
    const DEFAULT_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR = '#000000';
    const DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_PADDING = [0, 5, 0, 5];
    const DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_BG = '#ffffff';
    const DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_TEXT_ALIGN = 'center';
    const DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_FONT_SIZE = 14;
    const DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR = '#7c7c7c';
    const DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_FONT_WEIGHT = self::DEFAULT_BUTTON_ACCEPT_ALL_FONT_WEIGHT;
    const DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_BORDER_WIDTH = 0;
    const DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_BORDER_COLOR = '#000000';
    const DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_HOVER_BG = '#ffffff';
    const DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_HOVER_BORDER_COLOR = '#000000';
    const DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR = '#2b2b2b';
    /**
     * Return arguments for this section.
     */
    public function args() {
        $textButtonAcceptAllOneRowLayoutNotice = \sprintf(
            '<div class="notice notice-info inline below-h2 notice-alt" style="margin: 0"><p>%s</p><p>%s</p></div>',
            __(
                'Please also shorten the texts, e.g. "Reject" and "Accept all", to avoid legal risks with truncated text, or reduce the font size.',
                RCB_TD
            ),
            __(
                'Note that for visitors with an older browser (e.g. Internet Explorer) this option will not work.',
                RCB_TD
            )
        );
        $textButtonAcceptAllSimilarNotice = \sprintf(
            '<div class="notice notice-info inline below-h2 notice-alt" style="margin: 0"><p>%s</p></div>',
            __(
                'The "Accept" and "Reject" buttons should be the same size (button and text size) so that they are considered equal.',
                RCB_TD
            )
        );
        return [
            'name' => 'bodyDesign',
            'title' => __('Body', RCB_TD),
            'controls' => [
                self::SETTING_PADDING => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CssMarginInput::class,
                    'name' => 'padding',
                    'label' => __('Padding', RCB_TD),
                    'description' => __('Define inner distance of the body.', RCB_TD),
                    'dashicon' => 'editor-contract',
                    'setting' => ['default' => self::DEFAULT_PADDING]
                ],
                self::SETTING_DESCRIPTION_INHERIT_FONT_SIZE => [
                    'name' => 'descriptionInheritFontSize',
                    'label' => __('Adopt font size for description block', RCB_TD),
                    'type' => 'checkbox',
                    'setting' => [
                        'default' => self::DEFAULT_DESCRIPTION_INHERIT_FONT_SIZE,
                        'sanitize_callback' => [
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::class,
                            'sanitize_checkbox'
                        ]
                    ]
                ],
                self::SETTING_DESCRIPTION_FONT_SIZE => [
                    'name' => 'descriptionFontSize',
                    'label' => __('Description font size', RCB_TD),
                    'type' => 'range',
                    'input_attrs' => ['min' => 10, 'max' => 30, 'step' => 0],
                    'setting' => ['default' => self::DEFAULT_DESCRIPTION_FONT_SIZE, 'sanitize_callback' => 'absint']
                ],
                self::SETTING_DOTTED_GROUPS_INHERIT_FONT_SIZE => [
                    'name' => 'dottedGroupsInheritFontSize',
                    'label' => __('Adopt font size for service groups', RCB_TD),
                    'type' => 'checkbox',
                    'setting' => [
                        'default' => self::DEFAULT_DOTTED_GROUPS_INHERIT_FONT_SIZE,
                        'sanitize_callback' => [
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::class,
                            'sanitize_checkbox'
                        ]
                    ]
                ],
                self::SETTING_DOTTED_GROUPS_FONT_SIZE => [
                    'name' => 'dottedGroupsFontSize',
                    'label' => __('Service groups font size', RCB_TD),
                    'type' => 'range',
                    'input_attrs' => ['min' => 10, 'max' => 30, 'step' => 0],
                    'setting' => ['default' => self::DEFAULT_DOTTED_GROUPS_FONT_SIZE, 'sanitize_callback' => 'absint']
                ],
                self::SETTING_DOTTED_GROUPS_BULLET_COLOR => [
                    'name' => 'dottedGroupsBulletColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Bullet color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_DOTTED_GROUPS_BULLET_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::HEADLINE_TEACHINGS => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignTeachings',
                    'label' => __('Additional teachings', RCB_TD),
                    'description' => __('Texts for US data processing and age notice.', RCB_TD)
                ],
                self::SETTING_TEACHINGS_INHERIT_TEXT_ALIGN => [
                    'name' => 'teachingsInheritTextAlign',
                    'label' => __('Adopt text align', RCB_TD),
                    'type' => 'checkbox',
                    'setting' => [
                        'default' => self::DEFAULT_TEACHINGS_INHERIT_TEXT_ALIGN,
                        'sanitize_callback' => [
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::class,
                            'sanitize_checkbox'
                        ]
                    ]
                ],
                self::SETTING_TEACHINGS_TEXT_ALIGN => [
                    'name' => 'teachingsTextAlign',
                    'label' => __('Text align', RCB_TD),
                    'type' => 'select',
                    'choices' => [
                        'left' => __('Left', RCB_TD),
                        'right' => __('Right', RCB_TD),
                        'center' => __('Center', RCB_TD),
                        'justify' => __('Justify', RCB_TD)
                    ],
                    'setting' => ['default' => self::DEFAULT_TEACHINGS_TEXT_ALIGN]
                ],
                self::SETTING_TEACHINGS_SEPARATOR_ACTIVE => [
                    'name' => 'teachingsSeparatorActive',
                    'label' => __('Enable visual separator', RCB_TD),
                    'type' => 'checkbox',
                    'setting' => [
                        'default' => self::DEFAULT_TEACHINGS_SEPARATOR_ACTIVE,
                        'sanitize_callback' => [
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::class,
                            'sanitize_checkbox'
                        ]
                    ]
                ],
                self::HEADLINE_TEACHINGS_SEPARATOR => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignTeachingsSeparator',
                    'label' => __('Separator', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true
                ],
                self::SETTING_TEACHINGS_SEPARATOR_WIDTH => [
                    'name' => 'teachingsSeparatorWidth',
                    'label' => __('Width (px)', RCB_TD),
                    'type' => 'number',
                    'input_attrs' => ['min' => 1, 'max' => 1000, 'step' => 5],
                    'setting' => ['default' => self::DEFAULT_TEACHINGS_SEPARATOR_WIDTH, 'sanitize_callback' => 'absint']
                ],
                self::SETTING_TEACHINGS_SEPARATOR_HEIGHT => [
                    'name' => 'teachingsSeparatorHeight',
                    'label' => __('Height (px)', RCB_TD),
                    'type' => 'number',
                    'input_attrs' => ['min' => 1, 'max' => 20, 'step' => 1],
                    'setting' => [
                        'default' => self::DEFAULT_TEACHINGS_SEPARATOR_HEIGHT,
                        'sanitize_callback' => 'absint'
                    ]
                ],
                self::SETTING_TEACHINGS_SEPARATOR_COLOR => [
                    'name' => 'teachingsSeparatorColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_TEACHINGS_SEPARATOR_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::HEADLINE_TEACHINGS_FONT => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignTeachingsFont',
                    'label' => __('Font', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true
                ],
                self::SETTING_TEACHINGS_INHERIT_FONT_SIZE => [
                    'name' => 'teachingsInheritFontSize',
                    'label' => __('Adopt font size', RCB_TD),
                    'type' => 'checkbox',
                    'setting' => [
                        'default' => self::DEFAULT_TEACHINGS_INHERIT_FONT_SIZE,
                        'sanitize_callback' => [
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::class,
                            'sanitize_checkbox'
                        ]
                    ]
                ],
                self::SETTING_TEACHINGS_FONT_SIZE => [
                    'name' => 'teachingsFontSize',
                    'label' => __('Size', RCB_TD),
                    'type' => 'range',
                    'input_attrs' => ['min' => 10, 'max' => 30, 'step' => 0],
                    'setting' => ['default' => self::DEFAULT_TEACHINGS_FONT_SIZE, 'sanitize_callback' => 'absint']
                ],
                self::SETTING_TEACHINGS_INHERIT_FONT_COLOR => [
                    'name' => 'teachingsInheritFontColor',
                    'label' => __('Adopt font color', RCB_TD),
                    'type' => 'checkbox',
                    'setting' => [
                        'default' => self::DEFAULT_TEACHINGS_INHERIT_FONT_COLOR,
                        'sanitize_callback' => [
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::class,
                            'sanitize_checkbox'
                        ]
                    ]
                ],
                self::SETTING_TEACHINGS_FONT_COLOR => [
                    'name' => 'teachingsFontColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_TEACHINGS_FONT_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::HEADLINE_BUTTON_ACCEPT_ALL => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignAcceptAll',
                    'label' => __('Button: Accept all', RCB_TD)
                ],
                self::CUSTOM_HTML_BUTTON_ACCEPT_ALL_SIMILAR_NOTICE => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CustomHTML::class,
                    'name' => 'customHtmlButtonAcceptAllSimilarNotice',
                    'description' => $textButtonAcceptAllSimilarNotice
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_TYPE => [
                    'label' => __('Type', RCB_TD),
                    'type' => 'acceptAllButtonType'
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_ONE_ROW_LAYOUT => [
                    'name' => 'acceptAllOneRowLayout',
                    'label' => __('Align buttons side by side', RCB_TD),
                    'type' => 'checkbox',
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ALL_ONE_ROW_LAYOUT,
                        'sanitize_callback' => [
                            \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\AbstractCustomizePanel::class,
                            'sanitize_checkbox'
                        ]
                    ]
                ],
                self::CUSTOM_HTML_BUTTON_ACCEPT_ALL_ONE_ROW_LAYOUT_NOTICE => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CustomHTML::class,
                    'name' => 'customHtmlButtonAcceptAllOneRowLayoutNotice',
                    'description' => $textButtonAcceptAllOneRowLayoutNotice
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_PADDING => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CssMarginInput::class,
                    'name' => 'acceptAllPadding',
                    'label' => __('Padding', RCB_TD),
                    'description' => __('Define inner distance of the button/link.', RCB_TD),
                    'dashicon' => 'editor-contract',
                    'setting' => ['default' => self::DEFAULT_BUTTON_ACCEPT_ALL_PADDING]
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_BG => [
                    'name' => 'acceptAllBg',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Background color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ALL_BG,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_TEXT_ALIGN => [
                    'name' => 'acceptAllTextAlign',
                    'label' => __('Text align', RCB_TD),
                    'type' => 'select',
                    'choices' => self::getTextAlignChoices(),
                    'setting' => ['default' => self::DEFAULT_BUTTON_ACCEPT_ALL_TEXT_ALIGN]
                ],
                self::HEADLINE_BUTTON_ACCEPT_ALL_FONT => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignAcceptAllFont',
                    'label' => __('Font', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_FONT_SIZE => [
                    'name' => 'acceptAllFontSize',
                    'label' => __('Size', RCB_TD),
                    'type' => 'range',
                    'input_attrs' => ['min' => 10, 'max' => 30, 'step' => 0],
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ALL_FONT_SIZE,
                        'sanitize_callback' => 'absint'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_FONT_COLOR => [
                    'name' => 'acceptAllFontColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ALL_FONT_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_FONT_WEIGHT => [
                    'name' => 'acceptAllFontWeight',
                    'label' => __('Font weight', RCB_TD),
                    'type' => 'select',
                    'choices' => \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::getFontWeightChoices(),
                    'setting' => ['default' => self::DEFAULT_BUTTON_ACCEPT_ALL_FONT_WEIGHT]
                ],
                self::HEADLINE_BUTTON_ACCEPT_ALL_BORDER => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignAcceptAllBorder',
                    'label' => __('Border', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_BORDER_WIDTH => [
                    'name' => 'acceptAllBorderWidth',
                    'type' => 'number',
                    'input_attrs' => ['min' => 0],
                    'label' => __('Border width (px)', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ALL_BORDER_WIDTH,
                        'sanitize_callback' => 'absint'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_BORDER_COLOR => [
                    'name' => 'acceptAllBorderColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ALL_BORDER_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::HEADLINE_BUTTON_ACCEPT_ALL_HOVER => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignAcceptAllHover',
                    'label' => __('Transition on hover', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true,
                    'description' => __(
                        'When the user moves the mouse over the button/link, it changes its color.',
                        RCB_TD
                    )
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG => [
                    'name' => 'acceptAllHoverBg',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Background color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ALL_HOVER_BG,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_HOVER_FONT_COLOR => [
                    'name' => 'acceptAllHoverFontColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Font color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ALL_HOVER_FONT_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_ALL_HOVER_BORDER_COLOR => [
                    'name' => 'acceptAllHoverBorderColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Border color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ALL_HOVER_BORDER_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::HEADLINE_BUTTON_ACCEPT_ESSENTIALS => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignAcceptEssentials',
                    'label' => __('Button: Continue without consent', RCB_TD)
                ],
                self::SETTING_BUTTON_ACCEPT_ESSENTIALS_TYPE => [
                    'label' => __('Type', RCB_TD),
                    'type' => 'acceptEssentialsButtonType'
                ],
                self::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CssMarginInput::class,
                    'name' => 'acceptEssentialsPadding',
                    'label' => __('Padding', RCB_TD),
                    'description' => __('Define inner distance of the button/link.', RCB_TD),
                    'dashicon' => 'editor-contract',
                    'setting' => ['default' => self::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_PADDING]
                ],
                self::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG => [
                    'name' => 'acceptEssentialsBg',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Background color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_BG,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_ESSENTIALS_TEXT_ALIGN => [
                    'name' => 'acceptEssentialsTextAlign',
                    'label' => __('Text align', RCB_TD),
                    'type' => 'select',
                    'choices' => self::getTextAlignChoices(),
                    'setting' => ['default' => self::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_TEXT_ALIGN]
                ],
                self::HEADLINE_BUTTON_ACCEPT_ESSENTIALS_FONT => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignAcceptEssentialsFont',
                    'label' => __('Font', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true
                ],
                self::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE => [
                    'name' => 'acceptEssentialsFontSize',
                    'label' => __('Size', RCB_TD),
                    'type' => 'range',
                    'input_attrs' => ['min' => 10, 'max' => 30, 'step' => 0],
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE,
                        'sanitize_callback' => 'absint'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR => [
                    'name' => 'acceptEssentialsFontColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_WEIGHT => [
                    'name' => 'acceptEssentialsFontWeight',
                    'label' => __('Font weight', RCB_TD),
                    'type' => 'select',
                    'choices' => \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::getFontWeightChoices(),
                    'setting' => ['default' => self::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_FONT_WEIGHT]
                ],
                self::HEADLINE_BUTTON_ACCEPT_ESSENTIALS_BORDER => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignAcceptEssentialsBorder',
                    'label' => __('Border', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true
                ],
                self::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH => [
                    'name' => 'acceptEssentialsBorderWidth',
                    'type' => 'number',
                    'input_attrs' => ['min' => 0],
                    'label' => __('Border width (px)', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH,
                        'sanitize_callback' => 'absint'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR => [
                    'name' => 'acceptEssentialsBorderColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::HEADLINE_BUTTON_ACCEPT_ESSENTIALS_HOVER => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignAcceptEssentialsHover',
                    'label' => __('Transition on hover', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true,
                    'description' => __(
                        'When the user moves the mouse over the button/link, it changes its color.',
                        RCB_TD
                    )
                ],
                self::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG => [
                    'name' => 'acceptEssentialsHoverBg',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Background color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR => [
                    'name' => 'acceptEssentialsHoverFontColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Font color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR => [
                    'name' => 'acceptEssentialsHoverBorderColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Border color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::HEADLINE_BUTTON_ACCEPT_INDIVIDUAL => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignAcceptIndividual',
                    'label' => __('Button: Individual privacy preferences', RCB_TD)
                ],
                self::SETTING_BUTTON_ACCEPT_INDIVIDUAL_TYPE => [
                    'label' => __('Type', RCB_TD),
                    'type' => 'acceptIndividualButtonType'
                ],
                self::SETTING_BUTTON_ACCEPT_INDIVIDUAL_PADDING => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\CssMarginInput::class,
                    'name' => 'acceptIndividualPadding',
                    'label' => __('Padding', RCB_TD),
                    'description' => __('Define inner distance of the button/link.', RCB_TD),
                    'dashicon' => 'editor-contract',
                    'setting' => ['default' => self::DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_PADDING]
                ],
                self::SETTING_BUTTON_ACCEPT_INDIVIDUAL_BG => [
                    'name' => 'acceptIndividualBg',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Background color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_BG,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_INDIVIDUAL_TEXT_ALIGN => [
                    'name' => 'acceptIndividualTextAlign',
                    'label' => __('Text align', RCB_TD),
                    'type' => 'select',
                    'choices' => self::getTextAlignChoices(),
                    'setting' => ['default' => self::DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_TEXT_ALIGN]
                ],
                self::HEADLINE_BUTTON_ACCEPT_INDIVIDUAL_FONT => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignAcceptIndividualFont',
                    'label' => __('Font', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true
                ],
                self::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_SIZE => [
                    'name' => 'acceptIndividualFontSize',
                    'label' => __('Size', RCB_TD),
                    'type' => 'range',
                    'input_attrs' => ['min' => 10, 'max' => 30, 'step' => 0],
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_FONT_SIZE,
                        'sanitize_callback' => 'absint'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR => [
                    'name' => 'acceptIndividualFontColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_WEIGHT => [
                    'name' => 'acceptIndividualFontWeight',
                    'label' => __('Font weight', RCB_TD),
                    'type' => 'select',
                    'choices' => \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::getFontWeightChoices(),
                    'setting' => ['default' => self::DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_FONT_WEIGHT]
                ],
                self::HEADLINE_BUTTON_ACCEPT_INDIVIDUAL_BORDER => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignAcceptIndividualBorder',
                    'label' => __('Border', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true
                ],
                self::SETTING_BUTTON_ACCEPT_INDIVIDUAL_BORDER_WIDTH => [
                    'name' => 'acceptIndividualBorderWidth',
                    'type' => 'number',
                    'input_attrs' => ['min' => 0],
                    'label' => __('Border width (px)', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_BORDER_WIDTH,
                        'sanitize_callback' => 'absint'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_INDIVIDUAL_BORDER_COLOR => [
                    'name' => 'acceptIndividualBorderColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_BORDER_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::HEADLINE_BUTTON_ACCEPT_INDIVIDUAL_HOVER => [
                    'class' => \DevOwl\RealCookieBanner\Vendor\DevOwl\Customize\controls\Headline::class,
                    'name' => 'bodyDesignAcceptIndividualHover',
                    'label' => __('Transition on hover', RCB_TD),
                    'level' => 3,
                    'isSubHeadline' => \true,
                    'description' => __(
                        'When the user moves the mouse over the button/link, it changes its color.',
                        RCB_TD
                    )
                ],
                self::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_BG => [
                    'name' => 'acceptIndividualHoverBg',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Background color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_HOVER_BG,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR => [
                    'name' => 'acceptIndividualHoverFontColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Font color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ],
                self::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_BORDER_COLOR => [
                    'name' => 'acceptIndividualHoverBorderColor',
                    'class' => \WP_Customize_Color_Control::class,
                    'label' => __('Border color', RCB_TD),
                    'setting' => [
                        'default' => self::DEFAULT_BUTTON_ACCEPT_INDIVIDUAL_HOVER_BORDER_COLOR,
                        'sanitize_callback' => 'sanitize_hex_color'
                    ]
                ]
            ]
        ];
    }
    /**
     * Get all available text align choices.
     */
    public static function getTextAlignChoices() {
        return [
            'left' => __('Left', RCB_TD),
            'right' => __('Right', RCB_TD),
            'center' => __('Center', RCB_TD),
            'justify' => __('Justify', RCB_TD)
        ];
    }
    /**
     * Get all available font weight choices.
     */
    public static function getFontWeightChoices() {
        return [
            'lighter' => __('Lighter', RCB_TD),
            'normal' => __('Normal', RCB_TD),
            'bolder' => __('Bolder', RCB_TD),
            'bold' => __('Bold', RCB_TD)
        ];
    }
}
