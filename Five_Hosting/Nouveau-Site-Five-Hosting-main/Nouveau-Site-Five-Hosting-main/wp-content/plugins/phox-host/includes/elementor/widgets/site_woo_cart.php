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

/**
 * Site Woo Cart widget.
 *
 * Site Woo Cart widget that will display in Phox Builder category
 *
 * @package Elementor\Widgets
 * @since 2.0.0
 */
class Site_Woo_Cart extends Base_Builder_Widget {
    /**
     * Get Widget name
     *
     * Retrieve Bridge Cart widget name
     *
     * @return string Widget name
     * @since  2.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'wdes-site-woo-cart';
    }

    /**
     * Get Widget title
     *
     * Retrieve Bridge Cart widget title
     *
     * @return string Widget title
     * @since  2.0.0
     * @access public
     *
     */
    public function get_title() {
        return __( 'Site Woo Cart', 'phox-host' );
    }

    /**
     * Get Widget icon
     *
     * Retrieve Bridge Cart widget icon
     *
     * @return string Widget icon
     * @since  2.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'wdes-widget-elementor wdes-widget-cart-woo';
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
        return ['cart', 'woo'];
    }

    /**
     * Register Bridge Cart widget controls
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  2.0.0
     * @access protected
     */
    protected function register_controls(){

        $css_scheme = [
            'cart_wrapper'    => '.elementor-wdes-site-cart',
            'cart_link'       => '.wdes-site-cart-heading-link',
            'cart_icon'       => '.wdes-site-cart-icon',
            'cart_label'      => '.wdes-site-cart-label',
            'cart_count'      => '.wdes-site-cart-count',
            'cart_totals'     => '.wdes-site-cart-total',
            'cart_list'       => '.wdes-site-cart-list',
            'cart_list_title' => '.wdes-site-cart-list-title',
            'cart_list_close' => '.wdes-site-cart-close-button',

            'cart_empty_message'    => '.widget_shopping_cart .woocommerce-mini-cart__empty-message',
            'cart_product_list'     => '.widget_shopping_cart .woocommerce-mini-cart',
            'cart_product_item'     => '.widget_shopping_cart .woocommerce-mini-cart-item',
            'cart_product_link'     => '.widget_shopping_cart .woocommerce-mini-cart-item a:not(.remove)',
            'cart_product_img'      => '.widget_shopping_cart .woocommerce-mini-cart-item img',
            'cart_product_quantity' => '.widget_shopping_cart .woocommerce-mini-cart-item .quantity',
            'cart_product_amount'   => '.widget_shopping_cart .woocommerce-mini-cart-item .amount',
            'cart_product_remove'   => '.widget_shopping_cart .woocommerce-mini-cart-item .remove',

            'cart_list_total'        => '.widget_shopping_cart .woocommerce-mini-cart__total',
            'cart_list_total_title'  => '.widget_shopping_cart .woocommerce-mini-cart__total strong',
            'cart_list_total_amount' => '.widget_shopping_cart .woocommerce-mini-cart__total .amount',

            'cart_list_buttons' => '.widget_shopping_cart .woocommerce-mini-cart__buttons.buttons',
            'view_cart_button'  => '.widget_shopping_cart .woocommerce-mini-cart__buttons.buttons .button.wc-forward:not(.checkout)',
            'checkout_button'   => '.widget_shopping_cart .woocommerce-mini-cart__buttons.buttons .button.checkout.wc-forward',
        ];

        $this->start_controls_section(
            'section_woo_settings',
            [
                'label' => esc_html__( 'Settings', 'phox-host' ),
            ]
        );

        $this->add_control(
            'cart_woo_label',
            [
                'label'   => esc_html__( 'Label', 'phox-host' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Cart', 'phox-host' ),
            ]
        );

        $this->add_control(
            'cart_woo_icon',
            [
                'label'       => esc_html__( 'Icon', 'phox-host' ),
                'type'        => Controls_Manager::ICONS,
                'label_block' => false,
                'file'        => '',
                'skin'        => 'inline',
                'default'     => [
                    'value'   => 'fas fa-shopping-cart',
                    'library' => 'fa-solid',
                ]
            ]
        );

        $this->add_control(
            'show_woo_count',
            [
                'label'        => esc_html__( 'Show Products Count', 'phox-host' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'phox-host' ),
                'label_off'    => esc_html__( 'No', 'phox-host' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_woo_total',
            [
                'label'        => esc_html__( 'Show Cart Subtotal', 'phox-host' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'phox-host' ),
                'label_off'    => esc_html__( 'No', 'phox-host' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'show_woo_cart_list_heading',
            [
                'label'   => esc_html__( 'Cart Dropdown', 'phox-host' ),
                'type'    => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'show_woo_cart_list',
            [
                'label'        => esc_html__( 'Show Cart Dropdown', 'phox-host' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'phox-host' ),
                'label_off'    => esc_html__( 'No', 'phox-host' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'cart_woo_list_label',
            [
                'label'   => esc_html__( 'Cart Dropdown Label', 'phox-host' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'My Cart', 'phox-host' ),
                'condition' => [
                    'show_woo_cart_list' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'trigger_type',
            [
                'type'       => 'select',
                'label'      => esc_html__( 'Show Trigger Type', 'phox-host' ),
                'default'    => 'hover',
                'options'    => [
                    'hover' => esc_html__( 'Hover', 'phox-host' ),
                    'click' => esc_html__( 'Click', 'phox-host' ),
                ],
                'condition' => [
                    'show_woo_cart_list' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'type'       => 'select',
                'label'      => esc_html__( 'Layout Type', 'phox-host' ),
                'default'    => 'dropdown',
                'options'    => [
                    'dropdown' => esc_html__( 'Dropdown', 'phox-host' ),
                    'slide-out' => esc_html__( 'Slide Out', 'phox-host' ),
                ],
                'condition' => [
                    'show_woo_cart_list' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'cart_list_close_icon',
            [
                'label'       => esc_html__( 'Close Icon', 'phox-host' ),
                'type'        => Controls_Manager::ICONS,
                'label_block' => false,
                'skin'        => 'inline',
                'file'        => '',
                'default'     => [
                    'value'   => 'fas fa-times',
                    'library' => 'fa-solid'
                ],
                'condition' => [
                    'show_woo_cart_list' => 'yes',
                    'layout_type'    => 'slide-out',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_general_style',
            array(
                'label'      => esc_html__( 'General Styles', 'phox-host' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_responsive_control(
            'cart_alignment',
            [
                'label'   => esc_html__( 'Alignment', 'phox-host' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Start', 'phox-host' ),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'phox-host' ),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'End', 'phox-host' ),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} '  . $css_scheme['cart_wrapper'] => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'cart_link_style',
            array(
                'label'      => esc_html__( 'Cart Link', 'phox-host' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'cart_link_typography',
                'selector' => '{{WRAPPER}} ' . $css_scheme['cart_link'],
            ]
        );

        $this->start_controls_tabs( 'tabs_cart_link_style' );

        $this->start_controls_tab(
            'nav_items_normal',
            [
                'label' => esc_html__( 'Normal', 'phox-host' ),
            ]
        );

        $this->add_control(
            'cart_link_bg_color',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_label_color',
            [
                'label'  => esc_html__( 'Label Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_label'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_color',
            [
                'label'  => esc_html__( 'Icon Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_icon'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_count_color_bg',
            [
                'label'  => esc_html__( 'Count Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_count'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_count_color',
            [
                'label'  => esc_html__( 'Count Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_count'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_totals_color',
            [
                'label'  => esc_html__( 'Totals Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_totals'] => 'color: {{VALUE}}',
                ],
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
            'cart_link_bg_color_hover',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] . ':hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_link_border_color_hover',
            [
                'label' => esc_html__( 'Border Color', 'phox-host' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'cart_link_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] . ':hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cart_label_color_hover',
            [
                'label'  => esc_html__( 'Label Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] . ':hover ' . $css_scheme['cart_label'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_color_hover',
            [
                'label'  => esc_html__( 'Icon Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] . ':hover ' . $css_scheme['cart_icon'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_count_color_bg_hover',
            [
                'label'  => esc_html__( 'Count Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] . ':hover ' . $css_scheme['cart_count'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_count_color_hover',
            [
                'label'  => esc_html__( 'Count Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] . ':hover ' . $css_scheme['cart_count'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_totals_color_hover',
            [
                'label'  => esc_html__( 'Totals Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] . ':hover ' . $css_scheme['cart_totals'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'cart_link_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'cart_link_border',
                'label'          => esc_html__( 'Border', 'phox-host' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['cart_link'],
            ]
        );

        $this->add_responsive_control(
            'cart_link_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cart_icon_heading',
            [
                'label'     => esc_html__( 'Icon', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'cart_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_items_icon_gap',
            [
                'label'      => esc_html__( 'Gap After Icon', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_icon'] => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cart_label_styles',
            [
                'label'     => esc_html__( 'Label', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'cart_label_font_size',
            [
                'label'      => esc_html__( 'Label Font Size', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 8,
                        'max' => 90,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_label'] => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_label_gap',
            [
                'label'      => esc_html__( 'Gap After Label', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_label'] => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cart_count_styles',
            [
                'label'     => esc_html__( 'Count', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'cart_count_font_size',
            [
                'label'      => esc_html__( 'Count Font Size', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 8,
                        'max' => 90,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_count'] => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_count_box_size',
            array(
                'label'      => esc_html__( 'Count Box Size', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 16,
                        'max' => 90,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['cart_count'] => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->add_responsive_control(
            'cart_count_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_count'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_count_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_count'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cart_totals_styles',
            [
                'label'     => esc_html__( 'Totals', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'cart_totals_font_size',
            [
                'label'      => esc_html__( 'Totals Font Size', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 8,
                        'max' => 90,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_totals'] => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'cart_list_style',
            [
                'label' => esc_html__( 'Cart Dropdown', 'phox-host' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_woo_cart_list' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'cart_list_container_style_heading',
            [
                'label' => esc_html__( 'Container Styles', 'phox-host' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'cart_list_width',
            [
                'label'  => esc_html__( 'Width (px)', 'phox-host' ),
                'type'   => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 150,
                        'max' => 500,
                    ],
                ],
                'step'      => 1,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list'] => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cart_list_bg_color',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_list_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'cart_list_container_border',
                'label'          => esc_html__( 'Border', 'phox-host' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['cart_list'],
            ]
        );

        $this->add_responsive_control(
            'cart_list_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'cart_list_container_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['cart_list'],
            ]
        );

        $this->add_control(
            'close_button_style_heading',
            [
                'label'     => esc_html__( 'Close Button', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'layout_type' => 'slide-out',
                ],
            ]
        );

        $this->add_responsive_control(
            'close_button_size',
            [
                'label'      => esc_html__( 'Icon Size', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list_close'] => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['cart_list_close'] . ' svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'layout_type' => 'slide-out',
                ],
            ]
        );

        $this->add_control(
            'close_button_color',
            [
                'label'     => esc_html__( 'Icon Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list_close'] => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'layout_type' => 'slide-out',
                ],
            ]
        );

        $this->add_control(
            'cart_list_hor_position',
            [
                'label'   => esc_html__( 'Horizontal Position by', 'phox-host' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left'  => esc_html__( 'Left', 'phox-host' ),
                    'right' => esc_html__( 'Right', 'phox-host' ),
                ],
                'separator' => 'before',
                'condition' => [
                    'layout_type' => 'dropdown',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_list_left_position',
            [
                'label'      => esc_html__( 'Left Indent', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    'px' => [
                        'min' => -400,
                        'max' => 400,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => -50,
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'cart_list_hor_position' => 'left',
                    'layout_type' => 'dropdown',
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list'] => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_list_right_position',
            [
                'label'      => esc_html__( 'Right Indent', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range'      => [
                    'px' => [
                        'min' => -400,
                        'max' => 400,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => -50,
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'cart_list_hor_position' => 'right',
                    'layout_type' => 'dropdown',
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list'] => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                ],
            ]
        );

        $this->add_control(
            'cart_list_title_style_heading',
            [
                'label'     => esc_html__( 'Dropdown Label Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'cart_woo_list_label!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cart_list_title_typography',
                'selector'  => '{{WRAPPER}} ' . $css_scheme['cart_list_title'],
                'condition' => [
                    'cart_woo_list_label!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_list_title_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'condition'  => [
                    'cart_woo_list_label!' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list_title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_list_title_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'condition'  => [
                    'cart_woo_list_label!' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list_title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'cart_list_title_border',
                'label'       => esc_html__( 'Border', 'phox-host' ),
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['cart_list_title'],
                'condition'   => [
                    'cart_woo_list_label!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_list_title_alignment',
            [
                'label'   => esc_html__( 'Alignment', 'phox-host' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'phox-host' ),
                        'icon'  => 'eicon-arrow-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'phox-host' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'phox-host' ),
                        'icon'  => 'eicon-arrow-right',
                    ],
                ],
                'condition' => [
                    'cart_woo_list_label!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list_title'] => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cart_list_empty_message_heading',
            [
                'label'     => esc_html__( 'Dropdown Empty Message Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'cart_list_empty_message_typography',
                'selector' => '{{WRAPPER}} ' . $css_scheme['cart_empty_message'],
            ]
        );

        $this->add_responsive_control(
            'cart_list_empty_message_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_empty_message'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_list_empty_message_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_empty_message'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_list_empty_message_alignment',
            [
                'label'   => esc_html__( 'Alignment', 'phox-host' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'phox-host' ),
                        'icon'  => 'eicon-arrow-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'phox-host' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'phox-host' ),
                        'icon'  => 'eicon-arrow-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_empty_message'] => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'cart_list_items_style',
            [
                'label' => esc_html__( 'Cart Items Style', 'phox-host' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_woo_cart_list' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'cart_product_list_style_heading',
            [
                'label' => esc_html__( 'Product List Style', 'phox-host' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'cart_product_list_height',
            [
                'label' => esc_html__( 'Max Height', 'phox-host' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                ],
                'step'      => 1,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_list'] => 'max-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_product_list_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_list'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_product_list_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_list'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'cart_product_list_border',
                'label'       => esc_html__( 'Border', 'phox-host' ),
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['cart_product_list'],
            ]
        );

        $this->add_control(
            'cart_product_item_style_heading',
            [
                'label'     => esc_html__( 'Product Item Style', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'cart_product_item_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_item'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_product_item_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_item'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cart_product_item_divider',
            [
                'label'        => esc_html__( 'Divider', 'phox-host' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'cart_product_item_divider_style',
            [
                'label' => esc_html__( 'Style', 'phox-host' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'solid'  => esc_html__( 'Solid', 'phox-host' ),
                    'double' => esc_html__( 'Double', 'phox-host' ),
                    'dotted' => esc_html__( 'Dotted', 'phox-host' ),
                    'dashed' => esc_html__( 'Dashed', 'phox-host' ),
                ],
                'default' => 'solid',
                'condition' => [
                    'cart_product_item_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_item'] . ':not(:first-child)' => 'border-top-style: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_product_item_divider_weight',
            [
                'label'   => esc_html__( 'Weight', 'phox-host' ),
                'type'    => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 1,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'condition' => [
                    'cart_product_item_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_item'] . ':not(:first-child)' => 'border-top-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'cart_product_item_divider_color',
            [
                'label'     => esc_html__( 'Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'cart_product_item_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_item'] . ':not(:first-child)' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_product_image_style_heading',
            [
                'label'     => esc_html__( 'Product Image Style', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'cart_product_img_size',
            [
                'label' => esc_html__( 'Width', 'phox-host' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 150,
                    ],
                ],
                'step' => 1,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_img'] => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_product_img_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_img'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cart_product_title_style_heading',
            [
                'label'     => esc_html__( 'Product Title Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cart_product_title_typography',
                'selector'  => '{{WRAPPER}} ' . $css_scheme['cart_product_link'],
            ]
        );

        $this->add_control(
            'cart_product_title_color',
            [
                'label' => esc_html__( 'Color', 'phox-host' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_link'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_product_title_hover_color',
            [
                'label' => esc_html__( 'Hover Color', 'phox-host' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_link'] . ':hover' => 'color: {{VALUE}}',
                ],
            ]
        );


        $this->add_control(
            'cart_product_remove_style_heading',
            [
                'label'     => esc_html__( 'Product Remove Button Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'cart_product_remove_bnt_color',
            [
                'label' => esc_html__( 'Color', 'phox-host' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_remove'] => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'cart_product_remove_bnt_hover_color',
            [
                'label' => esc_html__( 'Hover Color', 'phox-host' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_remove'] . ':hover' => 'color: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'cart_product_quantity_style_heading',
            [
                'label'     => esc_html__( 'Product Quantity Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cart_product_quantity_typography',
                'selector'  => '{{WRAPPER}} ' . $css_scheme['cart_product_quantity'],
            ]
        );

        $this->add_control(
            'cart_cart_product_quantity_color',
            [
                'label' => esc_html__( 'Color', 'phox-host' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_quantity'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_product_amount_style_heading',
            [
                'label'     => esc_html__( 'Product Amount Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cart_product_amount_typography',
                'selector'  => '{{WRAPPER}} ' . $css_scheme['cart_product_amount'],
            ]
        );

        $this->add_control(
            'cart_product_amount_color',
            [
                'label' => esc_html__( 'Color', 'phox-host' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_product_amount'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_list_total_style_heading',
            [
                'label'     => esc_html__( 'Total Container Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'cart_list_total_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list_total'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_list_total_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list_total'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'cart_list_total_border',
                'label'       => esc_html__( 'Border', 'phox-host' ),
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['cart_list_total'],
            ]
        );

        $this->add_responsive_control(
            'cart_list_total_alignment',
            [
                'label'   => esc_html__( 'Alignment', 'phox-host' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'phox-host' ),
                        'icon'  => 'eicon-arrow-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'phox-host' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'phox-host' ),
                        'icon'  => 'eicon-arrow-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} '  . $css_scheme['cart_list_total'] => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cart_list_total_title_style_heading',
            [
                'label'     => esc_html__( 'Total Title Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'cart_list_total_title_typography',
                'selector' => '{{WRAPPER}} ' . $css_scheme['cart_list_total_title'],
            ]
        );

        $this->add_control(
            'cart_list_total_title_color',
            [
                'label' => esc_html__( 'Color', 'phox-host' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list_total_title'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_list_total_amount_style_heading',
            [
                'label'     => esc_html__( 'Total Amount Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'cart_list_total_amount_typography',
                'selector'  => '{{WRAPPER}} ' . $css_scheme['cart_list_total_amount'],
            ]
        );

        $this->add_control(
            'cart_list_total_amount_color',
            [
                'label' => esc_html__( 'Color', 'phox-host' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list_total_amount'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'cart_buttons_style',
            [
                'label' => esc_html__( 'Cart Buttons Style', 'phox-host' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_woo_cart_list' => 'yes',
                ],
            ]
        );


        $this->add_control(
            'cart_list_buttons_style_heading',
            [
                'label' => esc_html__( 'Buttons Container Styles', 'phox-host' ),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'cart_list_buttons_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list_buttons'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'cart_list_buttons_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['cart_list_buttons'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'cart_list_buttons_border',
                'label'       => esc_html__( 'Border', 'phox-host' ),
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['cart_list_buttons'],
            ]
        );

        $this->add_control(
            'view_cart_button_style_heading',
            [
                'label'     => esc_html__( 'View Cart Button Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'view_cart_btn_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['view_cart_button'],
            ]
        );

        $this->start_controls_tabs( 'tabs_view_cart_btn_style' );

        $this->start_controls_tab(
            'tab_view_cart_btn_normal',
            [
                'label' => esc_html__( 'Normal', 'phox-host' ),
            ]
        );

        $this->add_control(
            'view_cart_btn_background',
            [
                'label'     => esc_html__( 'Background Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['view_cart_button'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'view_cart_btn_color',
            [
                'label'     => esc_html__( 'Text Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['view_cart_button'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'view_cart_btn_border',
                'label'       => esc_html__( 'Border', 'phox-host' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['view_cart_button'],
            ]
        );

        $this->add_responsive_control(
            'view_cart_btn_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['view_cart_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'view_cart_btn_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['view_cart_button'],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_view_cart_btn_hover',
            [
                'label' => esc_html__( 'Hover', 'phox-host' ),
            ]
        );

        $this->add_control(
            'view_cart_btn_hover_background',
            [
                'label'     => esc_html__( 'Background Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['view_cart_button'] . ':hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'view_cart_btn_hover_color',
            [
                'label'     => esc_html__( 'Text Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['view_cart_button'] . ':hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'view_cart_btn_hover_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'view_cart_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['view_cart_button'] . ':hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'view_cart_btn_hover_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['view_cart_button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'view_cart_btn_hover_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['view_cart_button'] . ':hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'view_cart_btn_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['view_cart_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'view_cart_btn_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['view_cart_button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'checkout_button_style_heading',
            [
                'label'     => esc_html__( 'Checkout Button Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'checkout_btn_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['checkout_button'],
            ]
        );

        $this->start_controls_tabs( 'tabs_checkout_btn_style' );

        $this->start_controls_tab(
            'tab_checkout_btn_normal',
            [
                'label' => esc_html__( 'Normal', 'phox-host' ),
            ]
        );

        $this->add_control(
            'checkout_btn_background',
            [
                'label'     => esc_html__( 'Background Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['checkout_button'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'checkout_btn_color',
            [
                'label'     => esc_html__( 'Text Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['checkout_button'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'checkout_btn_border',
                'label'       => esc_html__( 'Border', 'phox-host' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['checkout_button'],
            ]
        );

        $this->add_responsive_control(
            'checkout_btn_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['checkout_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'checkout_btn_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['checkout_button'],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_checkout_btn_hover',
            [
                'label' => esc_html__( 'Hover', 'phox-host' ),
            ]
        );

        $this->add_control(
            'checkout_btn_hover_background',
            [
                'label'     => esc_html__( 'Background Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['checkout_button'] . ':hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'checkout_btn_hover_color',
            [
                'label'     => esc_html__( 'Text Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['checkout_button'] . ':hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'checkout_btn_hover_border_color',
            [
                'label'     => esc_html__( 'Border Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'checkout_btn_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['checkout_button'] . ':hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'checkout_btn_hover_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['checkout_button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'checkout_btn_hover_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['checkout_button'] . ':hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'checkout_btn_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['checkout_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'checkout_btn_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['checkout_button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        $widget_settings = [
            'triggerType'  => $settings['trigger_type'],
        ];

        $classes = [
            'wdes-site-cart',
            'wdes-site-cart-' . $settings['layout_type'] . '-layout',
        ];

        $class_string = implode( ' ', $classes );

        $elementor    = \Elementor\Plugin::instance();
        $is_edit_mode = $elementor->editor->is_edit_mode();

        if ( ( $is_edit_mode && ! wp_doing_ajax() ) || null === \WC()->cart ) {
            $count = '';
            $totals = '';
        } else {
            $count = \WC()->cart->get_cart_contents_count();
            $totals = wp_kses_data( WC()->cart->get_cart_subtotal() );
        }

        print ( '<div class="elementor-wdes-site-cart">' );

            printf( '<div class="%1$s" data-settings="%2$s">', esc_attr($class_string), esc_html(json_encode( $widget_settings ) ) );

            print ( '<div class="wdes-site-cart-heading">' );

                printf( '<a href="%1$s" class="%2$s" title="%3$s" >',esc_url( wc_get_cart_url() ), 'wdes-site-cart-heading-link', esc_attr__( 'View your shopping cart', 'phox-host' ) );

                    print('<span class="wdes-site-cart-icon wdes-icon">');

                        printf('<i class="%s" aria-hidden="true"></i>', $settings['cart_woo_icon']['library'] .' '. $settings['cart_woo_icon']['value']);

                    print('</span>');

                    if( !empty($settings['cart_woo_label']) ){
                        printf('<span class="wdes-site-cart-label">%s</span>', $settings['cart_woo_label']);
                    }

                    if ( 'yes' === $settings['show_woo_count'] ) {

                        print ('<span class="wdes-site-cart-count">');

                        printf( '<span class="wdes-site-cart-count-val">%s</span>', $count );

                        print ('</span>');
                    }

                    if ( 'yes' === $settings['show_woo_total'] ) {

                        print ('<span class="wdes-site-cart-total">');

                        printf( '<span class="wdes-site-cart-total-val">%s</span>', $totals );

                        print ('</span>');

                    }

                print ('</a>');

            print( '<div>' );

            if ( 'yes' === $settings['show_woo_cart_list'] ) {

                print ( '<div class="wdes-site-cart-list">' );

					if( $settings['layout_type'] === 'slide-out' ){
						print( '<div class="wdes-site-cart-close-button wdes-icon">' );

							printf('<i class="%s" aria-hidden="true"></i>', $settings['cart_list_close_icon']['library'] .' '. $settings['cart_list_close_icon']['value']);

						print ('</div>');
					}

                    if( ! empty( $settings['cart_woo_list_label'] ) ){
                        printf( '<h4 class="wdes-site-cart-list-title">%s</h4>', $settings['cart_woo_list_label'] );
                    }

                    the_widget( 'WC_Widget_Cart', 'title=' );

                print( '<div>' );

            }

            print ('</div>');

        print ( '</div>' );

    }
}
