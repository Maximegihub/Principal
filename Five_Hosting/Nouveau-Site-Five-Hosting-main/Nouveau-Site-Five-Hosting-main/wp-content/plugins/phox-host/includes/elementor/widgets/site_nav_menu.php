<?php

namespace Phox_Host\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
    exit; //Exit if assessed directly
}

use Phox_Host\Elementor\Base\Base_Builder_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Widget_Base;
use Elementor\Utils;
use Phox_Host\Elementor\Functions\Nav_walker_class;

/**
 * Site Nav Menu widget.
 *
 * Site Nav Menu widget that will display in Phox Builder category
 *
 * @package Elementor\Widgets
 * @since 2.0.0
 */
class Site_Nav_Menu extends Base_Builder_Widget {
    /**
     * Get Widget name
     *
     * Retrieve Nav Menu widget name
     *
     * @return string Widget name
     * @since  2.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'wdes-nav-menu';
    }

    /**
     * Get Widget title
     *
     * Retrieve Nav Menu widget title
     *
     * @return string Widget title
     * @since  2.0.0
     * @access public
     *
     */
    public function get_title() {
        return __( 'Site Nav Menu', 'phox-host' );
    }

    /**
     * Get Widget icon
     *
     * Retrieve Nav Menu widget icon
     *
     * @return string Widget icon
     * @since  2.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'wdes-widget-elementor wdes-widget-menu';
    }

    /**
     * Get Widget keywords
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array widget keywords.
     * @since  2.0.0
     * @access public
     *
     */
    public function get_keywords() {
        return [ 'nav', 'menu' ];
    }

	/**
	 * Get script dependencies.
	 *
	 * Retrieve the list of script dependencies the element requires.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Element scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'hoverIntent' ];
	}

    /**
     * Register Tabs widget controls
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  2.0.0
     * @access protected
     */
    protected function register_controls() {

        $css_scheme = [
            'nav' => '.wdes-nav',
            'horizontal' => '.wdes-nav-horizontal',
            'vertical' => '.wdes-nav-vertical',
            'mobile-menu' =>'.wdes-mobile-menu',
            'nav-wrap' => '.wdes-nav-wrap',
            'link-top' => '.menu-item-link-top',
            'link-text' => '.wdes-nav-link-text',
            'menu-item-hover' => '.menu-item:hover > .menu-item-link-top',
            'menu-item-hover-text' => '.menu-item:hover > .menu-item-link-top .wdes-nav-link-text',
            'menu-item-hover-arrow' => '.menu-item:hover > .menu-item-link-top .wdes-nav-arrow',
            'menu-item-current' => '.menu-item.current-menu-item .menu-item-link-top',
            'menu-item-current-text' => '.menu-item.current-menu-item .menu-item-link-top .wdes-nav-link-text',
            'menu-item-current-arrow' => '.menu-item.current-menu-item .menu-item-link-top .wdes-nav-arrow',
            'link-sub' => '.menu-item-link-sub' ,
            'link-sub-hover' => '.menu-item:hover > .menu-item-link-sub' ,
            'link-sub-current' => '.menu-item.current-menu-item > .menu-item-link-sub' ,
            'link-sub-arrow' => '.menu-item-link-sub .wdes-nav-arrow' ,
            'link-top-nav-arrow' => '.menu-item-link-top .wdes-nav-arrow',
            'nav-sub' => '.wdes-nav-sub',
            'mob-trig' => '.wdes-nav-mobile-trigger',
            'mob-trig-hover' => '.wdes-nav-mobile-trigger:hover',
            'close' => '.wdes-nav-mobile-close-btn'
        ];

        $this->start_controls_section(
            'section_general',
            [
                'label' => esc_html__( 'General Settings', 'phox-host' ),
            ]
        );

        $menus   = $this->get_available_menus();

        $this->add_control(
            'nav_menu',
            [
                'label'   => esc_html__( 'Select Menu', 'phox-host' ),
                'type'    => Controls_Manager::SELECT,
                'default' => $menus['default'],
                'options' => $menus['list'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_desktop_settings',
            [
                'label' => esc_html__( 'Desktop Settings', 'phox-host' ),
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'   => esc_html__( 'Layout', 'phox-host' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal' => esc_html__( 'Horizontal', 'phox-host' ),
                    'vertical'   => esc_html__( 'Vertical', 'phox-host' ),
                ],
            ]
        );

        $this->add_control(
            'dropdown_position',
            [
                'label'   => esc_html__( 'Dropdown Placement', 'phox-host' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right-side',
                'options' => [
                    'left-side'  => esc_html__( 'Left Side', 'phox-host' ),
                    'right-side' => esc_html__( 'Right Side', 'phox-host' ),
                    'bottom'     => esc_html__( 'At the bottom', 'phox-host' ),
                ],
                'description' => esc_html__( 'This option will not work with mega menu', 'phox-host' ),
                'condition' => [
                    'layout' => 'vertical',
                ]
            ]
        );

        $this->add_control(
            'dropdown_icon',
            [
                'label'       => esc_html__( 'Top Dropdown Icon', 'phox-host' ),
                'type'        => Controls_Manager::ICONS,
                'label_block' => false,
                'skin'        => 'inline',
                'file'        => '',
                'default' => [
                    'value'   => 'fa fa-angle-down',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'dropdown_icon_sub',
            [
                'label'       => esc_html__( 'Sub Dropdown Icon', 'phox-host' ),
                'type'        => Controls_Manager::ICONS,
                'label_block' => false,
                'skin'        => 'inline',
                'file'        => '',
                'default' => [
                    'value'   => 'fa fa-angle-right',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_alignment',
            [
                'label'   => esc_html__( 'Menu Alignment', 'phox-host' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'flex-start',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'phox-host' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'phox-host' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'phox-host' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__( 'Justified', 'phox-host' ),
                        'icon'  => 'eicon-h-align-stretch',
                    ],
                ],
                'selectors_dictionary' => [
                    'flex-start'    => 'justify-content: flex-start; text-align: left;',
                    'center'        => 'justify-content: center; text-align: center;',
                    'flex-end'      => 'justify-content: flex-end; text-align: right;',
                    'space-between' => 'justify-content: space-between; text-align: left;',
                ],
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['horizontal'] => '{{VALUE}}',
                    '{{WRAPPER}} '.$css_scheme['vertical'].' .menu-item-link-top' => '{{VALUE}}',
                    '{{WRAPPER}} .wdes-nav-vertical-sub-bottom .menu-item-link-sub' => '{{VALUE}}',

                    '(mobile){{WRAPPER}} '.$css_scheme['mobile-menu'].' .menu-item-link' => '{{VALUE}}',
                ],
                'prefix_class' => 'wdes-nav%s-align-',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_mobile_settings',
            [
                'label' => esc_html__( 'Mobile Settings', 'phox-host' ),
            ]
        );

        $this->add_control(
            'mobile_trigger_visible',
            [
                'label'     => esc_html__( 'Enable Mobile Trigger', 'phox-host' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mobile_menu_layout',
            [
                'label' => esc_html__( 'Layout', 'phox-host' ),
                'type'  => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default'    => esc_html__( 'Default', 'phox-host' ),
                    'full-width' => esc_html__( 'Full Width', 'phox-host' ),
                    'left-side'  => esc_html__( 'Slide From The Left Side ', 'phox-host' ),
                    'right-side' => esc_html__( 'Slide From The Right Side ', 'phox-host' ),
                ],
                'condition' => [
                    'mobile_trigger_visible' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mobile_trigger_alignment',
            [
                'label'   => esc_html__( 'Alignment', 'phox-host' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'phox-host' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'phox-host' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'phox-host' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'condition' => [
                    'mobile_trigger_visible' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mobile_trigger_icon',
            [
                'label'       => esc_html__( 'Icon', 'phox-host' ),
                'label_block' => false,
                'type'        => Controls_Manager::ICONS,
                'skin'        => 'inline',
                'default' => [
                    'value'   => 'fas fa-bars',
                    'library' => 'fa-solid',
                ],
                'condition'   => [
                    'mobile_trigger_visible' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'mobile_trigger_close_icon',
            [
                'label'       => esc_html__( 'Close Icon', 'phox-host' ),
                'label_block' => false,
                'type'        => Controls_Manager::ICONS,
                'skin'        => 'inline',
                'default' => [
                    'value'   => 'fas fa-times',
                    'library' => 'fa-solid',
                ],
                'condition'   => [
                    'mobile_trigger_visible' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'nav_items_style',
            [
                'label'      => esc_html__( 'Top Level Items', 'phox-host' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_responsive_control(
            'nav_vertical_menu_width',
            [
                'label' => esc_html__( 'Vertical Menu Width', 'phox-host' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['nav-wrap'] => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'layout' => 'vertical',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_vertical_menu_align',
            [
                'label'       => esc_html__( 'Vertical Menu Alignment', 'phox-host' ),
                'label_block' => true,
                'type'        => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'phox-host' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'phox-host' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'phox-host' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors_dictionary' => [
                    'left'   => 'margin-left: 0; margin-right: auto;',
                    'center' => 'margin-left: auto; margin-right: auto;',
                    'right'  => 'margin-left: auto; margin-right: 0;',
                ],
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['nav-wrap'] => '{{VALUE}}',
                ],
                'condition'  => [
                    'layout' => 'vertical',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_nav_items_style' );

        $this->start_controls_tab(
            'nav_items_normal',
            [
                'label' => esc_html__( 'Normal', 'phox-host' ),
            ]
        );

        $this->add_control(
            'nav_items_bg_color',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['link-top'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'nav_items_color',
            [
                'label'  => esc_html__( 'Text Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['link-top'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'nav_items_text_bg_color',
            [
                'label'  => esc_html__( 'Text Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-item-link-top .wdes-nav-link-text' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'nav_items_text_icon_color',
            [
                'label'  => esc_html__( 'Dropdown Icon Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-item-link-top .wdes-nav-arrow' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'nav_items_typography',
                'selector' => '{{WRAPPER}} '.$css_scheme['link-top'].' '.$css_scheme['link-text'],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'nav_items_hover',
            [
                'label' => esc_html__( 'Hover', 'phox-host' ),
            ]
        );

        $this->add_control(
            'nav_items_bg_color_hover',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['menu-item-hover'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'nav_items_color_hover',
            [
                'label'  => esc_html__( 'Text Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['menu-item-hover'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'nav_items_text_bg_color_hover',
            [
                'label'  => esc_html__( 'Text Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['menu-item-hover-text'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'nav_items_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'phox-host' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'nav_items_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['menu-item-hover'] => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_items_text_icon_color_hover',
            [
                'label'  => esc_html__( 'Dropdown Icon Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '. $css_scheme['menu-item-hover-arrow'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'nav_items_typography_hover',
                'selector' => '{{WRAPPER}} '. $css_scheme['menu-item-hover-text'],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'nav_items_active',
            [
                'label' => esc_html__( 'Active', 'phox-host' ),
            ]
        );

        $this->add_control(
            'nav_items_bg_color_active',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['menu-item-current'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'nav_items_color_active',
            [
                'label'  => esc_html__( 'Text Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['menu-item-current'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'nav_items_text_bg_color_active',
            [
                'label'  => esc_html__( 'Text Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['menu-item-current-text'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'nav_items_active_border_color',
            [
                'label' => esc_html__( 'Border Color', 'phox-host' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'nav_items_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['menu-item-current'] => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_items_text_icon_color_active',
            [
                'label'  => esc_html__( 'Dropdown Icon Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['menu-item-current-arrow'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'nav_items_typography_active',
                'selector' => '{{WRAPPER}} '.$css_scheme['menu-item-current-text'],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'nav_items_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} '.$css_scheme['link-top'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'nav_items_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wdes-nav > .wdes-nav-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'nav_items_border',
                'label'       => esc_html__( 'Border', 'phox-host' ),
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} '.$css_scheme['link-top'],
            ]
        );

        $this->add_responsive_control(
            'nav_items_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} '.$css_scheme['link-top'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_items_icon_size',
            [
                'label'      => esc_html__( 'Dropdown Icon Size', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['link-top-nav-arrow'] => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} '.$css_scheme['link-top-nav-arrow'].' svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_items_icon_gap',
            [
                'label'      => esc_html__( 'Gap Before Dropdown Icon', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} '.$css_scheme['link-top-nav-arrow'] => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wdes-nav-vertical-sub-left-side '.$css_scheme['link-top-nav-arrow'] => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',

                    '(mobile){{WRAPPER}} .wdes-mobile-menu .wdes-nav-vertical-sub-left-side '.$css_scheme['link-top-nav-arrow'] => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sub_items_style',
            [
                'label'      => esc_html__( 'Dropdown', 'phox-host' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'sub_items_container_style_heading',
            [
                'label' => esc_html__( 'Container Styles', 'phox-host' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'sub_items_container_width',
            [
                'label'      => esc_html__( 'Container Width', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['nav-sub'] => 'width: {{SIZE}}{{UNIT}} !important;',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'     => 'layout',
                            'operator' => '===',
                            'value'    => 'horizontal',
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name'     => 'layout',
                                    'operator' => '===',
                                    'value'    => 'vertical',
                                ],
                                [
                                    'name'     => 'dropdown_position',
                                    'operator' => '!==',
                                    'value'    => 'bottom',
                                ]
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'sub_items_container_bg_color',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['nav-sub'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'sub_items_container_border',
                'label'       => esc_html__( 'Border', 'phox-host' ),
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} '.$css_scheme['nav-sub'],
            ]
        );

        $this->add_responsive_control(
            'sub_items_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} '.$css_scheme['nav-sub'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} '.$css_scheme['nav-sub'].' > .menu-item:first-child > .menu-item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
                    '{{WRAPPER}} '.$css_scheme['nav-sub'].' > .menu-item:last-child > .menu-item-link' => 'border-radius: 0 0 {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'sub_items_container_box_shadow',
                'selector' => '{{WRAPPER}} '.$css_scheme['nav-sub'],
            ]
        );


        $this->add_responsive_control(
            'sub_items_container_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} '.$css_scheme['nav-sub'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_items_container_top_gap',
            [
                'label'      => esc_html__( 'Gap Before 1st Level Sub', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} '.$css_scheme['nav-sub'].' .wdes-nav-depth-0' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wdes-nav-vertical-sub-left-side .wdes-nav-depth-0' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wdes-nav-vertical-sub-right-side .wdes-nav-depth-0' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'     => 'layout',
                            'operator' => '===',
                            'value'    => 'horizontal',
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name'     => 'layout',
                                    'operator' => '===',
                                    'value'    => 'vertical',
                                ],
                                [
                                    'name'     => 'dropdown_position',
                                    'operator' => '!==',
                                    'value'    => 'bottom',
                                ]
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_items_container_left_gap',
            [
                'label'      => esc_html__( 'Gap Before 2nd Level Sub', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .wdes-nav-depth-0 .wdes-nav-sub' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wdes-nav-vertical-sub-left-side .wdes-nav-depth-0 .wdes-nav-sub' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name'     => 'layout',
                            'operator' => '===',
                            'value'    => 'horizontal',
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name'     => 'layout',
                                    'operator' => '===',
                                    'value'    => 'vertical',
                                ],
                                [
                                    'name'     => 'dropdown_position',
                                    'operator' => '!==',
                                    'value'    => 'bottom',
                                ]
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'sub_items_style_heading',
            [
                'label'     => esc_html__( 'Items Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'sub_items_typography',
                'selector' => '{{WRAPPER}} '.$css_scheme['link-sub'].' .wdes-nav-link-text',
            )
        );

        $this->start_controls_tabs( 'tabs_sub_items_style' );

        $this->start_controls_tab(
            'sub_items_normal',
            [
                'label' => esc_html__( 'Normal', 'phox-host' ),
            ]
        );

        $this->add_control(
            'sub_items_bg_color',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['link-sub'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sub_items_color',
            [
                'label'  => esc_html__( 'Text Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['link-sub'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sub_items_hover',
            [
                'label' => esc_html__( 'Hover', 'phox-host' ),
            ]
        );

        $this->add_control(
            'sub_items_bg_color_hover',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['link-sub-hover'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sub_items_color_hover',
            [
                'label'  => esc_html__( 'Text Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['link-sub-hover'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sub_items_active',
            [
                'label' => esc_html__( 'Active', 'phox-host' ),
            ]
        );

        $this->add_control(
            'sub_items_bg_color_active',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['link-sub-current'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sub_items_color_active',
            [
                'label'  => esc_html__( 'Text Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['link-sub-current'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'sub_items_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} '.$css_scheme['link-sub'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'sub_items_icon_size',
            [
                'label'      => esc_html__( 'Dropdown Icon Size', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['link-sub'] => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} '.$css_scheme['link-sub'].' svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_items_icon_gap',
            [
                'label'      => esc_html__( 'Gap Before Dropdown Icon', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} '.$css_scheme['link-sub'] => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wdes-nav-vertical-sub-left-side .menu-item-link-sub .wdes-nav-arrow' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',

                    '(mobile){{WRAPPER}} .wdes-mobile-menu .wdes-nav-vertical-sub-left-side .menu-item-link-sub .wdes-nav-arrow' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
                ],
            ]
        );

        $this->add_control(
            'sub_items_divider_heading',
            [
                'label'     => esc_html__( 'Divider', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'sub_items_divider',
                'selector' => '{{WRAPPER}} '.$css_scheme['nav-sub'].' > .wdes-nav-item-sub:not(:last-child)',
                'exclude'  => ['width'],
            ]
        );

        $this->add_control(
            'sub_items_divider_width',
            [
                'label' => esc_html__( 'Border Width', 'phox-host' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['nav-sub'].' > .wdes-nav-item-sub:not(:last-child)' => 'border-width: 0; border-bottom-width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'sub_items_divider_border!' => '',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mobile_trigger_styles',
            [
                'label'      => esc_html__( 'Mobile Trigger', 'phox-host' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->start_controls_tabs( 'tabs_mobile_trigger_style' );

        $this->start_controls_tab(
            'mobile_trigger_normal',
            [
                'label' => esc_html__( 'Normal', 'phox-host' ),
            ]
        );

        $this->add_control(
            'mobile_trigger_bg_color',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['mob-trig'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'mobile_trigger_color',
            [
                'label'  => esc_html__( 'Text Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['mob-trig'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'mobile_trigger_hover',
            [
                'label' => esc_html__( 'Hover', 'phox-host' ),
            ]
        );

        $this->add_control(
            'mobile_trigger_bg_color_hover',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['mob-trig-hover'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'mobile_trigger_color_hover',
            [
                'label'  => esc_html__( 'Text Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['mob-trig-hover'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'mobile_trigger_hover_border_color',
            [
                'label' => esc_html__( 'Border Color', 'phox-host' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'mobile_trigger_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['mob-trig-hover'] => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'mobile_trigger_border',
                'label'       => esc_html__( 'Border', 'phox-host' ),
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} '.$css_scheme['mob-trig'],
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'mobile_trigger_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} '.$css_scheme['mob-trig'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mobile_trigger_width',
            [
                'label'      => esc_html__( 'Width', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} '.$css_scheme['mob-trig'] => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mobile_trigger_height',
            [
                'label'      => esc_html__( 'Height', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} '.$css_scheme['mob-trig'] => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'mobile_trigger_icon_size',
            array(
                'label'      => esc_html__( 'Icon Size', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} '.$css_scheme['mob-trig'] => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mobile_menu_styles',
            [
                'label' => esc_html__( 'Mobile Menu', 'phox-host' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mobile_menu_width',
            [
                'label' => esc_html__( 'Width', 'phox-host' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 150,
                        'max' => 400,
                    ],
                    '%' => [
                        'min' => 30,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '(mobile){{WRAPPER}} '.$css_scheme['nav'] => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'mobile_menu_layout' => [
                        'left-side',
                        'right-side',
                    ],
                ],
            ]
        );

        $this->add_control(
            'mobile_menu_max_height',
            [
                'label' => esc_html__( 'Max Height', 'phox-host' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '(mobile){{WRAPPER}} '.$css_scheme['nav'] => 'max-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'mobile_menu_layout' => 'full-width',
                ],
            ]
        );

        $this->add_control(
            'mobile_menu_bg_color',
            [
                'label' => esc_html__( 'Background color', 'phox-host' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '(mobile){{WRAPPER}} '.$css_scheme['nav'] => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mobile_menu_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '(mobile){{WRAPPER}} '.$css_scheme['nav'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'mobile_menu_box_shadow',
                'selector' => '(mobile){{WRAPPER}} .wdes-mobile-menu-active .wdes-nav',
            ]
        );

        $this->add_control(
            'mobile_close_icon_heading',
            [
                'label' => esc_html__( 'Close icon', 'phox-host' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'mobile_menu_layout' => [
                        'left-side',
                        'right-side',
                    ],
                ],
            ]
        );

        $this->add_control(
            'mobile_close_icon_color',
            [
                'label' => esc_html__( 'Color', 'phox-host' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['close'] => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'mobile_menu_layout' => [
                        'left-side',
                        'right-side',
                    ],
                ],
            ]
        );

        $this->add_control(
            'mobile_close_icon_font_size',
            [
                'label' => esc_html__( 'Font size', 'phox-host' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} '.$css_scheme['close'] => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'mobile_menu_layout' => [
                        'left-side',
                        'right-side',
                    ],
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render
     *
     * @since  2.0.0
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings();

        if ( ! $settings['nav_menu'] ) {
            return;
        }

        $trigger_visible = filter_var( $settings['mobile_trigger_visible'], FILTER_VALIDATE_BOOLEAN );
        $trigger_align   = $settings['mobile_trigger_alignment'];

        require_once  Phox_HOST_PATH . 'includes/elementor/functions/nav_menu/nav_walker_class.php';

        $nav_wrapper ['class'] = 'wdes-nav-wrap';

        if ( $trigger_visible ) {

            $nav_wrapper ['class'] .= ' wdes-mobile-menu';

            if ( isset( $settings['mobile_menu_layout'] ) ) {

                $nav_wrapper ['class'] .= sprintf( ' wdes-mobile-menu-%s', esc_attr( $settings['mobile_menu_layout'] ) );

                $nav_wrapper ['data-mobile-layout'] = 'data-mobile-layout="' . esc_attr( $settings['mobile_menu_layout'] ).'"';

            }
        }

        $nav_menu ['class'] = 'wdes-nav';

        if ( isset( $settings['layout'] ) ) {

            $nav_menu ['class'] .= ' wdes-nav-'. esc_attr( $settings['layout'] );

            if ( 'vertical' === $settings['layout'] && isset( $settings['dropdown_position'] ) ) {

                $nav_menu ['class'] .= ' wdes-nav-vertical-sub-' . esc_attr( $settings['dropdown_position'] );

            }
        }

        $menu_html = '<div class="' . $nav_menu ['class'] . '">%3$s</div>';

        if ( $trigger_visible && in_array( $settings['mobile_menu_layout'], ['left-side', 'right-side']) ) {
            $close_btn = sprintf('<div class="wdes-nav-mobile-close-btn wdes-blocks-icon"><i class="%s" aria-hidden="true"></i></div>', $settings['mobile_trigger_close_icon']['library'] .' '. $settings['mobile_trigger_close_icon']['value']);

            $menu_html = '<div class="' . $nav_menu ['class'] . '">%3$s' . $close_btn . '</div>';

        }

        $top_dropdown_icon_html = sprintf('<i class="%s" aria-hidden="true"></i>', $settings['dropdown_icon']['library'] .' '. $settings['dropdown_icon']['value']);
        $sub_dropdown_icon_html = sprintf('<i class="%s" aria-hidden="true"></i>', $settings['dropdown_icon_sub']['library'] .' '. $settings['dropdown_icon_sub']['value']);

        $args = array(
            'menu'            => $settings['nav_menu'],
            'fallback_cb'     => '',
            'items_wrap'      => $menu_html,
            'walker'          => new Nav_walker_class,
            'widget_settings' => [
                'dropdown_icon'     => $top_dropdown_icon_html,
                'dropdown_icon_sub' => $sub_dropdown_icon_html
            ],
        );

        printf ('<div class="%1$s" %2$s>', $nav_wrapper ['class'], $nav_wrapper ['data-mobile-layout']);
            if ( $trigger_visible ) {
                printf('<div class="wdes-nav-mobile-trigger wdes-nav-mobile-trigger-align-%s">', esc_attr($trigger_align) );
                    printf('<span class="wdes-nav-mobile-trigger-open wdes-blocks-icon"><i class="%s" aria-hidden="true"></i></span>', $settings['mobile_trigger_icon']['library'] .' '. $settings['mobile_trigger_icon']['value']);
                    printf('<span class="wdes-nav-mobile-trigger-close wdes-blocks-icon"><i class="%s" aria-hidden="true"></i></span>', $settings['mobile_trigger_close_icon']['library'] .' '. $settings['mobile_trigger_close_icon']['value']);
                print ('</div>');
            }
            wp_nav_menu( $args );
        print ('</div>');

    }

    /**
     * Get available menus list
     *
     * @since  2.0.0
     * @access protected
     * @return array
     */
    private function get_available_menus() {

        $raw_menus          = wp_get_nav_menus();
        $menus ['list']     = wp_list_pluck( $raw_menus, 'name', 'term_id' );
        $menus ['default']   = '';

        if ( ! empty( $menus['list'] ) ) {
            $ids     = array_keys( $menus['list'] );
            $menus     ['default'] = $ids[0];
        }

        return $menus;
    }

    private function get_defualt_menu($menu){

        $default = '';

        if ( ! empty( $menus ) ) {
            $ids     = array_keys( $menus );
            $default = $ids[0];
        }

    }
}