<?php

namespace DevOwl\RealCookieBanner\presets;

use DevOwl\RealCookieBanner\base\UtilsProvider;
use DevOwl\RealCookieBanner\Core;
use DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign;
use DevOwl\RealCookieBanner\view\customize\banner\BasicLayout;
use DevOwl\RealCookieBanner\view\customize\banner\individual\Group;
use DevOwl\RealCookieBanner\view\customize\banner\individual\Texts as IndividualTexts;
use DevOwl\RealCookieBanner\view\customize\banner\Legal;
use DevOwl\RealCookieBanner\view\customize\banner\Texts;
use ReflectionClass;
use DevOwl\RealCookieBanner\view\customize\banner\Design;
use DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign;
use DevOwl\RealCookieBanner\view\customize\banner\BodyDesign;
use DevOwl\RealCookieBanner\view\customize\banner\FooterDesign;
use DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton;
use DevOwl\RealCookieBanner\view\customize\banner\individual\Layout;
use DevOwl\RealCookieBanner\view\customize\banner\Decision;
// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No script kiddies please!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Predefined presets for cookie banner.
 */
class BannerPresets {
    use UtilsProvider;
    /**
     * Get all available presets.
     */
    public function get() {
        /**
         * Filters available presets for cookie banner customize.
         *
         * @hook RCB/Presets/Banner
         * @param {array} $presets All available presets
         * @returns {array}
         */
        return apply_filters('RCB/Presets/Banner', [
            'light' => [
                'name' => __('Light Dialog', RCB_TD),
                'description' => __('Standard design for the cookie consent as a dialog.', RCB_TD),
                'settings' => []
            ],
            'light-banner' => [
                'name' => __('Light Banner', RCB_TD),
                'description' => __('Standard design for the cookie consent as a banner.', RCB_TD),
                'settings' => [
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE => 'banner',
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_ANIMATION_OUT => 'fadeOut',
                    \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY => \false,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => 0,
                    \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 17,
                    \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_INHERIT_BANNER_MAX_WIDTH => \false
                ]
            ],
            'dark' => [
                'name' => __('Dark Dialog', RCB_TD),
                'description' => __('Standard design for the cookie consent as a dialog in dark mode.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_COLOR_BG => '#222222',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#f9f9f9',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_COLOR => '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                            '#191919',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                            '#2d2d2d',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                            '#067070',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                            '#333333',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                            '#067d7d',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#969696',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#d3d3d3',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#141414',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#969696',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#d3d3d3',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_COLOR =>
                            '#0f0f0f',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BG =>
                            '#2d2d2d',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                            '#333333',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                            '#424242',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_COLOR =>
                            '#969696',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_HOVER_COLOR =>
                            '#d3d3d3',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#2d2d2d',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                            '#067d7d',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG =>
                            '#333333',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                            '#067070'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_BG =>
                                '#222222',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ACTIVE_BG =>
                                '#2d2d2d',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_HOVER_BG =>
                                '#2d2d2d',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_BORDER_COLOR =>
                                '#2d2d2d',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_TITLE_FONT_COLOR =>
                                '#f9f9f9'
                        ]
                        : []
                )
            ],
            'dark-banner' => [
                'name' => __('Dark Banner', RCB_TD),
                'description' => __('Standard design for the cookie consent as a banner in dark mode.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE => 'banner',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_ANIMATION_OUT => 'fadeOut',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_COLOR_BG => '#222222',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#f9f9f9',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 17,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_COLOR => '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                            '#191919',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                            '#2d2d2d',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                            '#067070',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                            '#333333',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                            '#067d7d',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#969696',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#d3d3d3',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#141414',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#969696',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#d3d3d3',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_COLOR =>
                            '#0f0f0f',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_INHERIT_BANNER_MAX_WIDTH => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BG =>
                            '#2d2d2d',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                            '#333333',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                            '#424242',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_COLOR =>
                            '#969696',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_HOVER_COLOR =>
                            '#d3d3d3',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#2d2d2d',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                            '#067d7d',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG =>
                            '#333333',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                            '#067070'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_BG =>
                                '#222222',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ACTIVE_BG =>
                                '#2d2d2d',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_HOVER_BG =>
                                '#2d2d2d',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_BORDER_COLOR =>
                                '#2d2d2d',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_TITLE_FONT_COLOR =>
                                '#f9f9f9'
                        ]
                        : []
                )
            ],
            'divi-dialog' => [
                'name' => __('Divi Dialog', RCB_TD),
                'description' => __('Optimized design for the standard Divi theme as a consent dialog.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#666666',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [
                            19,
                            20,
                            17,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 26,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                            '#e2e2e2',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#2ea3f2',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#2ea3f2',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#2ea3f2',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#2993d9',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_INHERIT_BG => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_COLOR =>
                            '#e2e2e2',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#2b2b2b',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_DIALOG_MAX_WIDTH => 825,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#2ea3f2',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#2993d9'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#2ea3f2'
                        ]
                        : []
                )
            ],
            'divi-banner' => [
                'name' => __('Divi Banner', RCB_TD),
                'description' => __('Optimized design for the standard Divi theme as a consent banner.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE => 'banner',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_ANIMATION_OUT => 'fadeOut',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_INHERIT_FAMILY => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => -3,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#666666',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [
                            21,
                            20,
                            19,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 26,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                            '#e2e2e2',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#2ea3f2',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#2ea3f2',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#2ea3f2',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#2993d9',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_INHERIT_BG => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [
                            17,
                            20,
                            21,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_COLOR =>
                            '#e2e2e2',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#2b2b2b',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_DIALOG_MAX_WIDTH => 825,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#2ea3f2',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#2993d9'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#2ea3f2'
                        ]
                        : []
                )
            ],
            'astra-dialog' => [
                'name' => __('Astra Dialog', RCB_TD),
                'description' => __('Optimized design for the standard Astra theme as a consent dialog.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#3a3a3a',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 81,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [
                            19,
                            30,
                            17,
                            30
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 21,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                            '#f5f5f5',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [20, 30, 20, 30],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#0274be',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#0274be',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#0274be',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#0264a6',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#3a3a3a',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#141414',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#f5f5f5',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [
                            19,
                            30,
                            21,
                            30
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#3a3a3a',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#141414',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                            '#c6c6c6',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#0274be',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#0264a6',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_PADDING => [
                            20,
                            20,
                            20,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                            '#c6c6c6'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#0274be'
                        ]
                        : []
                )
            ],
            'astra-banner' => [
                'name' => __('Astra Banner', RCB_TD),
                'description' => __('Optimized design for the standard Astra theme as a consent banner.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_INHERIT_BANNER_MAX_WIDTH => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_ANIMATION_OUT => 'fadeOut',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE => 'banner',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#3a3a3a',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 81,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [
                            19,
                            30,
                            17,
                            30
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 21,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                            '#f5f5f5',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [20, 30, 20, 30],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#0274be',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#0274be',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#0274be',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#0264a6',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#3a3a3a',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#141414',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#f5f5f5',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [
                            19,
                            30,
                            21,
                            30
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#3a3a3a',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#141414',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_BANNER_MAX_WIDTH => 950,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                            '#c6c6c6',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#0274be',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#0264a6',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_PADDING => [
                            20,
                            20,
                            20,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                            '#c6c6c6'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#0274be'
                        ]
                        : []
                )
            ],
            'avada-dialog' => [
                'name' => __('Avada Dialog', RCB_TD),
                'description' => __('Optimized design for the standard Avada theme as a consent dialog.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#212934',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 57,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 16,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#4a4e57',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_INHERIT_FAMILY => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#6d6d6d',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [
                            17,
                            30,
                            15,
                            30
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 26,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [20, 30, 20, 30],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#65bc7b',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#65bc7b',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_PADDING => [
                            12,
                            10,
                            12,
                            10
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#65bc7b',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#58a36b',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                            10,
                            5,
                            10,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_PADDING => [
                            10,
                            5,
                            0,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#212934',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#080a0d',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#1d242d',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [
                            25,
                            30,
                            25,
                            30
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#d2d3d5',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_DIALOG_MAX_WIDTH => 885,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BG =>
                            '#efefef',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                            '#e5e5e5',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#65bc7b',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#65bc7b',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                            '#e5e5e5',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_PADDING => [
                            10,
                            10,
                            10,
                            10
                        ]
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#65bc7b'
                        ]
                        : []
                )
            ],
            'avada-banner' => [
                'name' => __('Avada Banner', RCB_TD),
                'description' => __('Optimized design for the standard Avada theme as a consent banner.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE => 'banner',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_ANIMATION_OUT => 'fadeOut',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#212934',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 57,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 16,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#4a4e57',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_INHERIT_FAMILY => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#6d6d6d',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [
                            17,
                            30,
                            15,
                            30
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 26,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [20, 30, 20, 30],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#65bc7b',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#65bc7b',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_PADDING => [
                            12,
                            10,
                            12,
                            10
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#65bc7b',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#58a36b',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                            10,
                            5,
                            10,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_PADDING => [
                            10,
                            5,
                            0,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_SIZE => 16,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#212934',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#080a0d',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#1d242d',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [
                            25,
                            30,
                            25,
                            30
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#d2d3d5',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_DIALOG_MAX_WIDTH => 885,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BG =>
                            '#efefef',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                            '#e5e5e5',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#65bc7b',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#65bc7b',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                            '#e5e5e5',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_PADDING => [
                            10,
                            10,
                            10,
                            10
                        ]
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#65bc7b'
                        ]
                        : []
                )
            ],
            'clean' => [
                'name' => __('Clean Dialog', RCB_TD),
                'description' => __('Clean design which suits perfect to themes without many colors.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 9,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 50,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BLUR => 4,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_LINK_TEXT_DECORATION => 'none',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => 4,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 27,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#6b6b6b',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [
                            20,
                            20,
                            10,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_WEIGHT => 'bold',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#262626',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_INHERIT_BG => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [7, 20, 11, 20],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_PADDING => [
                            0,
                            0,
                            10,
                            0
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_WIDTH => 0
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#000000'
                        ]
                        : []
                )
            ],
            'clean-green' => [
                'name' => __('Clean Green', RCB_TD),
                'description' => __('Professional request to agree to the cookies.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BLUR => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_ENABLED => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_INHERIT_BG => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BG => '#f4f7f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_LOGO_MAX_HEIGHT => 53,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_LOGO_MARGIN => [
                            5,
                            20,
                            5,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 18,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_COLOR => '#576a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_WEIGHT => 'bold',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [20, 20, 20, 20],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DESCRIPTION_INHERIT_FONT_SIZE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_INHERIT_FONT_SIZE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#566a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_ACTIVE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#566a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_INHERIT_FONT_SIZE => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_FONT_SIZE => 13,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_INHERIT_FONT_COLOR => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_FONT_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#007f50',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#576a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                            10,
                            10,
                            10,
                            10
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_PADDING => [
                            5,
                            5,
                            0,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#54595f',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#f4f7f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_SIZE => 12,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#54595f',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BG =>
                            '#f4f7f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_WIDTH => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                            '#576a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#37a97e',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#37a97e',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_PADDING => [
                            20,
                            20,
                            20,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_WIDTH => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_FONT_WEIGHT =>
                            'bold',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_COLOR =>
                            '#576a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_FONT_SIZE => 13,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_COLOR =>
                            '#54595f',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_HOVER_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_PADDING => [
                            10,
                            10,
                            10,
                            10
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_SIZE => 15
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#007f50'
                        ]
                        : []
                )
            ],
            'clean-red' => [
                'name' => __('Clean Red', RCB_TD),
                'description' => __('Professional request to agree to the cookies.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#0a0a0a',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BLUR => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BORDER_COLOR => '#ff0000',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_ENABLED => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => -2,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 9,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#2b2b2b',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_INHERIT_BG => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BG => '#f5f5f5',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_LOGO_MAX_HEIGHT => 85,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_LOGO_MARGIN => [
                            5,
                            20,
                            5,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 18,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_COLOR => '#576a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [20, 20, 20, 20],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DESCRIPTION_INHERIT_FONT_SIZE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DESCRIPTION_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_INHERIT_FONT_SIZE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#54595f',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_ACTIVE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_HEIGHT => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#566a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_INHERIT_FONT_SIZE => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_FONT_SIZE => 13,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_FONT_COLOR =>
                            '#54595f',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#ae1424',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#686868',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                            '#f4f7f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                            '#686868',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                            '#60b239',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                            '#686868',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                            '#59a535',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_PADDING => [
                            5,
                            5,
                            0,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#686868',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#f5f5f5',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [
                            15,
                            20,
                            17,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_SIZE => 12,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#54595f',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_WIDTH => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#ae1424',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#ae1424',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_PADDING => [
                            20,
                            20,
                            20,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_WIDTH => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_FONT_WEIGHT =>
                            'bold',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_COLOR =>
                            '#54595f',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_FONT_SIZE => 13,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_COLOR =>
                            '#54595f',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_HOVER_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#f4f7f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                            '#54595f',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_WIDTH => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                            '#54595f',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG =>
                            '#686868',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                            '#686868'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#ae1424'
                        ]
                        : []
                )
            ],
            'red-contrast' => [
                'name' => __('Red Contrast', RCB_TD),
                'description' => __('Emotionally colorful play of red-black-white.', RCB_TD),
                //'needsPro' => true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#212934',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 57,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BLUR => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\Decision::SETTING_GROUPS_FIRST_VIEW => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\Decision::SETTING_SAVE_BUTTON =>
                            'afterChangeAll',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#4a4e57',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => -1,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 62,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#6d6d6d',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [
                            17,
                            30,
                            15,
                            30
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 26,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [20, 30, 20, 30],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DESCRIPTION_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#9b0103',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_ACTIVE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_HEIGHT => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#65bc7b',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_PADDING => [
                            12,
                            10,
                            12,
                            10
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#9b0103',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#9b0103',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                            10,
                            5,
                            10,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                            '#9b0103',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                            '#9b0103',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                            '#9b0103',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                            '#9b0103',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_PADDING => [
                            10,
                            5,
                            0,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_SIZE => 16,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#212934',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#080a0d',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#1d242d',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [
                            25,
                            30,
                            25,
                            30
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#d2d3d5',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BG =>
                            '#efefef',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                            '#e5e5e5',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#9b0103',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#9b0103',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                            '#9b0103',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_WIDTH => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                            '#9b0103',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                            '#9b0103',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                            '#9b0103'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#9b0103'
                        ]
                        : []
                )
            ],
            'gold-in-the-dark' => [
                'name' => __('Gold in the Dark', RCB_TD),
                'description' => __('Dark mode design with a clear accent.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE => 'banner',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_ANIMATION_OUT => 'fadeOut',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#0a0a0a',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 59,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_COLOR_BG => '#222222',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#f9f9f9',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => -1,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 17,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#0a0a0a',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [
                            17,
                            10,
                            15,
                            10
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 17,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_COLOR => '#f9f9f9',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_WEIGHT => 'lighter',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                            '#424242',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [15, 10, 10, 10],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DESCRIPTION_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_INHERIT_FONT_SIZE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#b58d00',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_ACTIVE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_HEIGHT => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#056363',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#b58d00',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_FONT_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#936900',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                            5,
                            5,
                            5,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                            '#222222',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE => 13,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                            '#b58d00',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                            '#b58d00',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                            '#222222',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                            '#b58d00',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_SIZE => 13,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#969696',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#d3d3d3',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_POWERED_BY_LINK => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#141414',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [
                            15,
                            10,
                            17,
                            10
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_SIZE => 13,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#969696',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#d3d3d3',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_COLOR =>
                            '#424242',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_COLOR =>
                            '#f9f9f9',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#b58d00',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#b58d00',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                            '#424242',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_FONT_WEIGHT =>
                            'bolder',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_FONT_SIZE => 13,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_COLOR =>
                            '#969696',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_HOVER_COLOR =>
                            '#d3d3d3',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_PADDING => [
                            5,
                            5,
                            5,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#222222',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                            '#b58d00',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_WIDTH => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                            '#b58d00',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG =>
                            '#222222',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                            '#b58d00'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_PADDING => [
                                5,
                                5,
                                5,
                                5
                            ],
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#b58d00',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_BG =>
                                '#222222',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ACTIVE_BG =>
                                '#2b2b2b',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_HOVER_BG =>
                                '#2b2b2b',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_BORDER_WIDTH => 0,
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_BORDER_COLOR =>
                                '#1c1c1c',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_TITLE_FONT_COLOR =>
                                '#ffffff'
                        ]
                        : []
                )
            ],
            'gold-zen' => [
                'name' => __('Gold Zen', RCB_TD),
                'description' => __('Bright appearance with gold-green accent.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_TYPE => 'banner',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_MAX_WIDTH => 400,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BANNER_MAX_WIDTH => 750,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_ANIMATION_IN => 'fadeInUp',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#0a0a0a',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BLUR => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_TEXT_ALIGN => 'left',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_LINK_TEXT_DECORATION => 'none',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 16,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#000302',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => -1,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#416a59',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [
                            20,
                            20,
                            15,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_LOGO_MAX_HEIGHT => 70,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_LOGO_POSITION => 'above',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 23,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_COLOR => '#000302',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DESCRIPTION_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#000302',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_WIDTH => 150,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#000302',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_FONT_COLOR =>
                            '#718093',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#916704',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_FONT_SIZE => 17,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BORDER_COLOR =>
                            '#ba910b',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#e5b720',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BORDER_COLOR =>
                            '#e5b720',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                            5,
                            5,
                            5,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE => 13,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                            '#416a59',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                            '#416a59',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                            '#5b8172',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                            '#5b8172',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_SIZE => 13,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#718093',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#718093',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#416a59',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [
                            15,
                            20,
                            17,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#cccccc',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_DIALOG_MAX_WIDTH => 750,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_INHERIT_BANNER_MAX_WIDTH => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_BANNER_MAX_WIDTH => 975,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Layout::SETTING_DESCRIPTION_TEXT_ALIGN =>
                            'justify',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                            '#416a59',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#416a59',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#416a59',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_COLOR =>
                            '#000302',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_HOVER_COLOR =>
                            '#000302',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_PADDING => [
                            2,
                            2,
                            2,
                            2
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                            '#000302',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_WEIGHT =>
                            'bold',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                            '#273c75',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                            '#000302',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                            '#5b8172'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#ba910b'
                        ]
                        : []
                )
            ],
            'business-green' => [
                'name' => __('Business Green', RCB_TD),
                'description' => __('Professional request to agree to the cookies.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#0a0a0a',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BLUR => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_ENABLED => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => -1,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 9,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#2b2b2b',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_INHERIT_BG => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BG => '#f4f7f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_LOGO_MAX_HEIGHT => 53,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_LOGO_MARGIN => [
                            5,
                            20,
                            5,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 18,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_COLOR => '#576a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_WEIGHT => 'bold',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [20, 20, 20, 20],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DESCRIPTION_INHERIT_FONT_SIZE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DESCRIPTION_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_INHERIT_FONT_SIZE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#566a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_ACTIVE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_HEIGHT => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#566a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_INHERIT_FONT_SIZE => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_FONT_SIZE => 13,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_INHERIT_FONT_COLOR => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_FONT_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#007c63',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#576a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                            '#f4f7f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                            '#007767',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                            '#60b239',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                            '#d7e4ed',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                            '#007c63',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                            '#59a535',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_PADDING => [
                            5,
                            5,
                            0,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#1d8bc6',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_POWERED_BY_LINK => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#f4f7f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [
                            15,
                            20,
                            17,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_SIZE => 12,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#1d8bc6',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BG =>
                            '#f4f7f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_WIDTH => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                            '#576a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#007767',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#007767',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_PADDING => [
                            20,
                            20,
                            20,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_WIDTH => 2,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_FONT_WEIGHT =>
                            'bold',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_COLOR =>
                            '#576a76',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_FONT_SIZE => 13,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_COLOR =>
                            '#1d8bc6',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_HOVER_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#f4f7f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                            '#007767',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_WIDTH => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                            '#007767',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG =>
                            '#d8e4ed',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                            '#007767',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                            '#007767'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#007c63'
                        ]
                        : []
                )
            ],
            'business-as-usual' => [
                'name' => __('Business as usual', RCB_TD),
                'description' => __('Unobtrusive, clear and directly visible to everyone.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_ANIMATION_IN => 'fadeIn',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_ANIMATION_OUT => 'fadeOut',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#0a0a0a',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 72,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BLUR => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#939598',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_ENABLED => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => -1,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 9,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#2b2b2b',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_LOGO_POSITION => 'above',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_COLOR => '#13293e',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_WEIGHT => 'bolder',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                            '#ebebeb',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DESCRIPTION_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#f5a418',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_HEIGHT => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#f5a418',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_INHERIT_FONT_COLOR => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#13293e',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#17324f',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                            5,
                            5,
                            5,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                            '#13293e',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                            '#13293e',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                            '#17324f',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                            '#17324f',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_SIZE => 12,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#9c9e9f',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#f4f4f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [
                            15,
                            20,
                            17,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_SIZE => 12,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#9c9e9f',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BG =>
                            '#ebebeb',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#13293e',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#13293e',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_COLOR =>
                            '#ebebeb',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_COLOR =>
                            '#939598',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_FONT_SIZE => 12,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_COLOR =>
                            '#939598',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_COLOR =>
                            '#939598',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_PADDING => [
                            5,
                            5,
                            5,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                            '#13293e',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_WIDTH => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                            '#f5a418',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                            '#ffb433',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                            '#ffb433'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#13293e'
                        ]
                        : []
                )
            ],
            'creative-minimal' => [
                'name' => __('Creative Minimal', RCB_TD),
                'description' => __('Design as clear and minimalist as possible.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG_ALPHA => 28,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BLUR => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\Decision::SETTING_GROUPS_FIRST_VIEW => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\Decision::SETTING_SAVE_BUTTON =>
                            'afterChangeAll',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_COLOR_BG => '#000a1e',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_COLOR => '#f9f9fa',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_ENABLED => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => -1,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 9,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#2b2b2b',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [0, 10, 0, 10],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 10,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_COLOR => '#000a1e',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_BOTTOM_BORDER_COLOR =>
                            '#000a1e',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [30, 15, 0, 15],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#f9f9fa',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_ACTIVE => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_WIDTH => 36,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_HEIGHT => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#67bf3d',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_INHERIT_FONT_COLOR => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#f9f9fa',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_FONT_COLOR =>
                            '#000a1e',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_FONT_WEIGHT =>
                            'bolder',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BORDER_COLOR =>
                            '#000a1e',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#707780',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BORDER_COLOR =>
                            '#000a1e',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                            10,
                            5,
                            10,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                            '#020b1d',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                            '#020b1d',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BORDER_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_FONT_COLOR =>
                            '#707780',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_INDIVIDUAL_HOVER_FONT_COLOR =>
                            '#7c7c7c',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_INHERIT_BG => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#f4f4f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [
                            20,
                            20,
                            40,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_FONT_COLOR => '#707780',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_HOVER_FONT_COLOR =>
                            '#7c7c7c',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_TOP_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_COLOR =>
                            '#7c7c7c',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#000a1e',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_PADDING => [
                            20,
                            15,
                            20,
                            15
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_FONT_WEIGHT =>
                            'bolder',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_HEADLINE_COLOR =>
                            '#f9f9fa',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_DESCRIPTION_COLOR =>
                            '#f9f9fa',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_COLOR =>
                            '#f9f9fa',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_LINK_HOVER_COLOR =>
                            '#7c7c7c',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_TYPE => 'link',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_PADDING => [
                            5,
                            5,
                            5,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_WIDTH => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_COLOR =>
                            '#60b239',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                            '#7c7c7c',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BORDER_COLOR =>
                            '#59a535'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#ffffff',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_BG =>
                                '#000a1e',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ACTIVE_BG =>
                                '#000a1e',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_HOVER_BG =>
                                '#000719',
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_BORDER_WIDTH => 0,
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_TITLE_FONT_COLOR =>
                                '#ffffff'
                        ]
                        : []
                )
            ],
            'simple-black-white' => [
                'name' => __('Simple Black-White', RCB_TD),
                'description' => __('Make it easy with just two colors.', RCB_TD),
                'needsPro' => \true,
                'settings' => \array_merge(
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_DIALOG_BORDER_RADIUS => 10,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_BORDER_RADIUS => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BG => '#0a0a0a',
                        \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::SETTING_OVERLAY_BLUR => 5,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_LINK_TEXT_DECORATION => 'none',
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_OFFSET_Y => 4,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_BLUR_RADIUS => 27,
                        \DevOwl\RealCookieBanner\view\customize\banner\Design::SETTING_BOX_SHADOW_COLOR => '#6b6b6b',
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_PADDING => [
                            15,
                            20,
                            15,
                            20
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_LOGO_MAX_HEIGHT => 47,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_LOGO_MARGIN => [
                            5,
                            5,
                            5,
                            0
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_SIZE => 15,
                        \DevOwl\RealCookieBanner\view\customize\banner\HeaderDesign::SETTING_FONT_WEIGHT => 'bold',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_PADDING => [10, 20, 0, 20],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DESCRIPTION_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_DOTTED_GROUPS_BULLET_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_HEIGHT => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_TEACHINGS_SEPARATOR_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_BG =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ALL_HOVER_BG =>
                            '#282828',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_PADDING => [
                            5,
                            5,
                            5,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BG =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_FONT_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_BORDER_WIDTH => 1,
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_BG =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\BodyDesign::SETTING_BUTTON_ACCEPT_ESSENTIALS_HOVER_FONT_COLOR =>
                            '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_POWERED_BY_LINK => \false,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_INHERIT_BG => \true,
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_BG => '#f4f4f4',
                        \DevOwl\RealCookieBanner\view\customize\banner\FooterDesign::SETTING_PADDING => [7, 20, 11, 20],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_BORDER_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BG =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_CHECKBOX_ACTIVE_BORDER_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_PADDING => [
                            0,
                            0,
                            10,
                            0
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_RADIUS => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::SETTING_GROUP_BORDER_WIDTH => 0,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_PADDING => [
                            5,
                            5,
                            5,
                            5
                        ],
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BG => '#ffffff',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_SIZE => 14,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_FONT_COLOR =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_BORDER_WIDTH => 3,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_BG =>
                            '#000000',
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\SaveButton::SETTING_HOVER_FONT_COLOR =>
                            '#ffffff'
                    ],
                    $this->isPro()
                        ? [
                            \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::SETTING_STACKS_ARROW_COLOR =>
                                '#000000'
                        ]
                        : []
                )
            ]
        ]);
    }
    /**
     * Default values so the presets only override a set of settings.
     */
    public function defaults() {
        $sectionArgs = \DevOwl\RealCookieBanner\Core::getInstance()
            ->getBanner()
            ->getCustomize()
            ->getSections();
        $defaults = [];
        foreach ($sectionArgs as $sectionId => $section) {
            // Legal and texts should be ignored as they are not really "styles" and preset-relevant
            if (
                \in_array(
                    $sectionId,
                    [
                        \DevOwl\RealCookieBanner\view\customize\banner\Legal::SECTION,
                        \DevOwl\RealCookieBanner\view\customize\banner\Texts::SECTION,
                        \DevOwl\RealCookieBanner\view\customize\banner\individual\Texts::SECTION
                    ],
                    \true
                )
            ) {
                continue;
            }
            foreach ($section['controls'] as $controlId => $control) {
                $setting = isset($control['setting']) ? $control['setting'] : null;
                if (isset($setting)) {
                    $defaults[$controlId] = isset($setting['default']) ? $setting['default'] : \false;
                }
            }
        }
        return $defaults;
    }
    /**
     * Return PHP constant names. This is meant to be so on frontend a PHP code can be
     * generated for a preset easily.
     */
    public function constants() {
        return \array_merge(
            $this->constantsFromFolder(
                RCB_INC . 'view/customize/banner/*.php',
                \DevOwl\RealCookieBanner\view\customize\banner\BasicLayout::class
            ),
            $this->constantsFromFolder(
                RCB_INC . 'view/customize/banner/individual/*.php',
                \DevOwl\RealCookieBanner\view\customize\banner\individual\Group::class
            ),
            $this->isPro()
                ? $this->constantsFromFolder(
                    RCB_INC . 'overrides/pro/view/customize/banner/*.php',
                    \DevOwl\RealCookieBanner\lite\view\customize\banner\TcfBodyDesign::class
                )
                : []
        );
    }
    /**
     * Does not support recursive folders.
     *
     * @param string $glob
     * @param string $baseClass
     */
    protected function constantsFromFolder($glob, $baseClass) {
        $result = [];
        $classFiles = \glob($glob);
        foreach ($classFiles as $classPath) {
            // Get full qualified name for the class
            $className = \explode('.', \basename($classPath))[0];
            if ($className === 'index') {
                continue;
            }
            $fq = \explode('\\', $baseClass);
            \array_pop($fq);
            \array_push($fq, $className);
            $fq = \join('\\', $fq);
            // Iterate all SETTING_ constants
            $reflection = new \ReflectionClass($fq);
            foreach ($reflection->getConstants() as $constant => $value) {
                if (\substr($constant, 0, 8) === 'SETTING_') {
                    $result[$value] = '\\' . $fq . '::' . $constant;
                }
            }
        }
        return $result;
    }
}
