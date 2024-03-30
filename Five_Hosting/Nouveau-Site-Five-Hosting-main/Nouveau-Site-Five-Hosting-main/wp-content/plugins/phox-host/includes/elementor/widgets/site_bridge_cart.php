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
 * Site Bridge Cart widget.
 *
 * Site Bridge Cart widget that will display in Phox Builder category
 *
 * @package Elementor\Widgets
 * @since 2.0.0
 */
class Site_Bridge_Cart extends Base_Builder_Widget {
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
        return 'wdes-site-bridge-cart';
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
        return __( 'Site Bridge Cart', 'phox-host' );
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
        return 'wdes-widget-elementor wdes-widget-bridge';
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
        return ['cart', 'bridge'];
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
        ];

        $this->start_controls_section(
            'section_bridge_settings',
            [
                'label' => esc_html__( 'Settings', 'phox-host' ),
            ]
        );

        $this->add_control(
            'cart_bridge_label',
            [
                'label'   => esc_html__( 'Label', 'phox-host' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Cart', 'phox-host' ),
            ]
        );

        $this->add_control(
            'cart_bridge_icon',
            [
                'label'       => esc_html__( 'Icon', 'phox-host' ),
                'type'        => Controls_Manager::ICONS,
                'label_block' => false,
                'file'        => '',
                'skin'        => 'inline',
                'default'     => [
                    'value'   => 'fas fa-shopping-cart',
                    'library' => 'fa-solid'
                ]

            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_general_style',
            [
                'label'      => esc_html__( 'General Styles', 'phox-host' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_responsive_control(
            'cart_bridge_alignment',
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
            'cart_bridge_link_style',
            [
                'label'      => esc_html__( 'Cart Link', 'phox-host' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'cart_bridge_link_typography',
                'selector' => '{{WRAPPER}} ' . $css_scheme['cart_link'],
            ]
        );

        $this->start_controls_tabs( 'tabs_cart_bridge_link_style' );

        $this->start_controls_tab(
            'nav_bridge_items_normal',
            [
                'label' => esc_html__( 'Normal', 'phox-host' ),
            ]
        );

        $this->add_control(
            'cart_bridge_link_bg_color',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_bridge_label_color',
            [
                'label'  => esc_html__( 'Label Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_label'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_bridge_icon_color',
            [
                'label'  => esc_html__( 'Icon Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_icon'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'nav_bridge_items_hover',
            [
                'label' => esc_html__( 'Hover', 'phox-host' ),
            ]
        );

        $this->add_control(
            'cart_bridge_link_bg_color_hover',
            [
                'label'  => esc_html__( 'Background Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] . ':hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_bridge_link_border_color_hover',
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
            'cart_bridge_label_color_hover',
            [
                'label'  => esc_html__( 'Label Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] . ':hover ' . $css_scheme['cart_label'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'cart_bridge_icon_color_hover',
            [
                'label'  => esc_html__( 'Icon Color', 'phox-host' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] . ':hover ' . $css_scheme['cart_icon'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'cart_bridge_link_padding',
            array(
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['cart_link'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'cart_bridge_link_border',
                'label'          => esc_html__( 'Border', 'phox-host' ),
                'placeholder'    => '1px',
                'selector'       => '{{WRAPPER}} ' . $css_scheme['cart_link'],
            ]
        );

        $this->add_responsive_control(
            'cart_bridge_link_border_radius',
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
            'cart_bridge_icon_heading',
            array(
                'label'     => esc_html__( 'Icon', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'cart_bridge_icon_size',
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
            'cart_bridge_items_icon_gap',
            array(
                'label'      => esc_html__( 'Gap After Icon', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 20,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['cart_icon'] => 'margin-right: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'cart_bridge_label_styles',
            array(
                'label'     => esc_html__( 'Label', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'cart_bridge_label_font_size',
            array(
                'label'      => esc_html__( 'Label Font Size', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 8,
                        'max' => 90,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['cart_label'] => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            )
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

        $helper = new \Phox\helpers();

        $link['url'] = get_permalink( $helper->get_bridge_page_id() );
        $link['target'] = 'target="_self"';
        $link['rel'] = 'rel="nofollow"';

        print ( '<div class="elementor-wdes-site-cart">' );

            print( '<div class="wdes-site-cart" >' );

                print ( '<div class="wdes-site-cart-heading">' );

                    printf( '<a href="%1$s" class="%2$s" title="%3$s" %4$s %5$s >',esc_url( $link['url'] ), 'wdes-site-cart-heading-link', esc_attr__( 'View your shopping cart', 'phox-host' ), $link['target'], $link['rel'] );

                print('<span class="wdes-site-cart-icon wdes-icon">');

                    printf('<i class="%s" aria-hidden="true"></i>', $settings['cart_bridge_icon']['library'] .' '. $settings['cart_bridge_icon']['value']);

                print('</span>');

                if( !empty($settings['cart_bridge_label']) ){

                    printf('<span class="wdes-site-cart-label">%s</span>', $settings['cart_bridge_label']);

                }

                print ('</a>');

                print( '<div>' );

            print ( '</div>' );

        print ( '</div>' );
    }
}
