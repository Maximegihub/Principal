<?php
namespace Phox_Host\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Repeater;
use Phox\helpers;
use  Phox_Host\Elementor\Base\Base_Widget;


if ( ! defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Price Table widget.
 *
 * Price Table widget that will display in Phox category
 *
 * @package Elementor\Widgets
 * @since 1.4.1
 */
class Price_Table extends Base_Widget {

	/**
	 * Get Widget name
	 *
	 * Retrieve Tabs widget name
	 *
	 * @since  1.4.1
	 * @access public
	 *
	 * @return string Widget name
	 */
	public function get_name() {
		return 'wdes_price_table';
	}

	/**
	 * Get Widget title
	 *
	 * Retrieve Tabs widget title
	 *
	 * @since  1.4.1
	 * @access public
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( 'Price Table', 'phox-host' );
	}

	/**
	 * Get Widget icon
	 *
	 * Retrieve Tabs widget icon
	 *
	 * @since  1.4.1
	 * @access public
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'wdes-widget-elementor wdes-widget-pricing';
	}


	/**
	 * Get Widget keywords
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since  1.4.1
	 * @access public
	 *
	 * @return array widget keywords.
	 */
	public function get_keywords() {
		return [ 'price', 'table', 'product', 'image', 'plan', 'button' ];
	}

	/**
	 * Register Tabs widget controls
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.4.1
	 * @access protected
	 */
	protected function register_controls() {

		$css_scheme = [
			'table'              => '.wdes-pricing-table',
			'header'             => '.wdes-pricing-table-heading',
			'icon_wrap'          => '.wdes-pricing-table-icon',
			'icon_box'           => '.wdes-pricing-table-icon-box',
			'icon'               => '.wdes-pricing-table-icon-box > *',
			'image'              => '.wdes-pricing-table-img',
			'title'              => '.wdes-pricing-table-title',
			'subtitle'           => '.wdes-pricing-table-subtitle',
			'price'              => '.wdes-pricing-table-price',
			'price_prefix'       => '.wdes-pricing-table-price-perfix',
			'price_discount'     => '.wdes-pricing-table-price-original',
			'price_value'        => '.wdes-pricing-table-price-num',
			'price_suffix'       => '.wdes-pricing-table-price-suffix',
			'price_desc'         => '.wdes-pricing-table-price-desc',
			'features'           => '.wdes-pricing-table-features',
            'features_wrap'      => '.wdes-pricing-table-features-wrap',
			'features_header'    => '.wdes-pricing-table-features-header',
			'features_item'      => '.wdes-pricing-feature',
			'feature_item'       => '.wdes-pricing-feature-inner',
			'feature_item_text'  => '.wdes-pricing-table-features-text',
			'footer'             => '.wdes-pricing-feature-footer',
			'button'             => '.wdes-pricing-feature-footer .pricing-table-button',
			'button_icon'        => '.wdes-pricing-feature-footer .pricing-table-button-icon',
			'strip_default'      => '.wdes-pricing-table-strip-default-inner',
			'strip_custom'       => '.wdes-pricing-table-strip-custom-image',
		];

		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Header', 'phox-host' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label'     => esc_html__( 'Title', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Title', 'phox-host' ),
				'dynamic'   => [ 'active' => true ],
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'     => esc_html__( 'Subtitle', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Subtitle', 'phox-host' ),
				'dynamic'   => [ 'active' => true ],
			]
		);

		$this->add_control(
			'above_title',
			[
				'label'     => __( 'Above Title', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'image' => [
						'title' => esc_html__( 'Image', 'phox-host' ),
						'icon'  => 'eicon-image',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'phox-host' ),
						'icon'  => 'eicon-font-awesome',
					],
				],
				'default'   => 'icon',
			]
		);

		$this->add_control(
			'icon',
			[
				'label'       => esc_html__( 'Icon', 'phox-host' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default' => [
					'value' => 'far fa-hdd',
					'library' => 'fa-regular',
				],
				'condition'     => [
					'above_title'   => 'icon',
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'phox-host' ),
				'type'  => Controls_Manager::MEDIA,
				'condition'     => [
					'above_title'   => 'image',
				],
			]
		);

		$this->add_control(
			'strip',
			[
				'label'        => esc_html__( 'Strip', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'price_strip_type',
			[
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'strip_default' => [
						'title' => esc_html__( 'Default', 'phox-host' ),
						'icon'  => 'eicon-frame-minimize',
					],
					'strip_custom' => [
						'title' => esc_html__( 'Custom', 'phox-host' ),
						'icon'  => 'eicon-image',
					],
				],
				'default'   => 'strip_default',
				'condition'     => [
					'strip'   => 'yes',
				],
			]
		);

		$this->add_control(
			'strip_default_title',
			[
				'label'     => esc_html__( 'Title', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Popular', 'phox-host' ),
				'condition'     => [
					'strip'   => 'yes',
					'price_strip_type'  => 'strip_default',
				],
			]
		);

		$this->add_control(
			'strip_default_position',
			[
				'label'         => esc_html__( 'Position', 'phox-host' ),
				'type'          => Controls_Manager::CHOOSE,
				'label_block'   => false,
				'default'       => 'right',
				'options'   => [
					'left' => [
						'title' => __( 'Left', 'phox-host' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'phox-host' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'condition'     => [
					'strip'   => 'yes',
					'price_strip_type'  => 'strip_default',
				],
			]
		);

		$this->add_control(
			'strip_custom_image',
			[
				'label' => esc_html__( 'Image', 'phox-host' ),
				'type'  => Controls_Manager::MEDIA,
				'condition'     => [
					'strip'   => 'yes',
					'price_strip_type'  => 'strip_custom',
				],
			]
		);

		$this->add_control(
			'strip_custom_position',
			[
				'label'         => esc_html__( 'Position', 'phox-host' ),
				'type'          => Controls_Manager::CHOOSE,
				'label_block'   => false,
				'default'       => 'right',
				'options'   => [
					'left' => [
						'title' => __( 'Left', 'phox-host' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'phox-host' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'condition'     => [
					'strip'   => 'yes',
					'price_strip_type'  => 'strip_custom',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_price',
			[
				'label' => esc_html__( 'Price', 'phox-host' ),
			]
		);

		$this->add_control(
			'price',
			[
				'label'     => esc_html__( 'Price', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '39.99', 'phox-host' ),
			]
		);

		$this->add_control(
			'discount',
			[
				'label'     => esc_html__( 'Discount', 'phox-host' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'On', 'phox-host' ),
				'label_off'  => __( 'OFF', 'phox-host' ),
			]
		);

		$this->add_control(
			'original_price',
			[
				'label'     => esc_html__( 'Original Price', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '39.99', 'phox-host' ),
				'condition'     => [
					'discount'   => 'yes',
				],

			]
		);

		$this->add_control(
			'perfix',
			[
				'label'     => esc_html__( 'Prefix', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '$', 'phox-host' ),
			]
		);

		$this->add_control(
			'suffix',
			[
				'label'     => esc_html__( 'Suffix', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( '/per month', 'phox-host' ),
				'dynamic'   => [ 'active' => true ],
			]
		);

		$this->add_control(
			'desc',
			[
				'label'     => esc_html__( 'Description', 'phox-host' ),
				'type'      => Controls_Manager::TEXTAREA,
				'dynamic'   => [ 'active' => true ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_feature',
			[
				'label' => esc_html__( 'Features', 'phox-host' ),
			]
		);

		$this->add_control(
			'feature_header',
			[
				'label'     => esc_html__( 'Feature Header', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( ' Head Title ', 'phox-host' ),
				'label_block'   => true,
			]
		);

		$feature_items = new Repeater();

		$feature_items->add_control(
			'item_title',
			[
				'label'     => esc_html__( 'Title', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'List Item', 'phox-host' ),
				'label_block'   => true,
			]
		);

		$feature_items->add_control(
			'item_decoration',
			[
				'label'     => __( 'Text Decoration', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'image' => [
						'title' => esc_html__( 'Image', 'phox-host' ),
						'icon'  => 'eicon-image',
					],
					'icon' => [
						'title' => esc_html__( 'Icon', 'phox-host' ),
						'icon'  => 'eicon-font-awesome',
					],
				],
				'default'   => 'icon',
			]
		);

		$feature_items->add_control(
			'item_icon',
			[
				'label'         => esc_html__( 'Icon', 'phox-host' ),
				'type'          => Controls_Manager::ICONS,
				'label_block'   => true,
				'default' => [
					'value' => 'fas fa-flag',
					'library' => 'fa-solid',
				],
				'condition'     => [
					'item_decoration'   => 'icon',
				],
			]
		);

		$feature_items->add_control(
			'item_image',
			[
				'name'  => 'item_image',
				'label' => esc_html__( 'Image', 'phox-host' ),
				'type'  => Controls_Manager::MEDIA,
				'condition'     => [
					'item_decoration'   => 'image',
				],
			]
		);

		$this->add_control(
			'feature_items',
			[
				'label' => __( 'Tab Items', 'phox-host' ),
				'type'  => Controls_Manager::REPEATER,
				'fields' => $feature_items->get_controls(),
				'default'  => [
					[
						'item_title' => esc_html__( ' List Item #1', 'phox-host' ),
					],
					[
						'item_title' => esc_html__( ' List Item #2', 'phox-host' ),
					],
					[
						'item_title' => esc_html__( ' List Item #3', 'phox-host' ),
					],
				],
				'title_field' => '{{{item_title}}}',

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_footer',
			[
				'label' => esc_html__( 'Footer', 'phox-host' ),
			]
		);

		$this->add_control(
			'button_before',
			[
				'label'     => esc_html__( 'Text Before Button', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'     => esc_html__( 'Button Text', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Buy', 'phox-host' ),
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'         => esc_html__( 'Link', 'phox-host' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'https://example.com', 'phox-host' ),
				'default'       => [
					'url'   => '#',
				],
				'dynamic'       => [
					'active'    => true,
				],
			]
		);

		$this->add_control(
			'button_after',
			[
				'label'     => esc_html__( 'Text After Button', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_table_style',
			array(
				'label'      => esc_html__( 'Table', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'table_bg_border' );

		$this->start_controls_tab(
			'table_bg_border_normal',
			array(
				'label' => esc_html__( 'Normal', 'phox-host' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'table_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['table'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'table_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['table'],
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width' => array(
						'default' => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
					),
					'color' => array(
						'scheme' => array(
							'type'  => Color::get_type(),
							'value' => Color::COLOR_3,
						),
						'default' => '#e7e7e7',
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'table_bg_border_hover',
			array(
				'label' => esc_html__( 'Hover', 'phox-host' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'table_bg_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['table'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'table_border_hover',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['table'] . ':hover',
				'fields_options' => array(
					'border' => array(
						'default' => 'solid',
					),
					'width' => array(
						'default' => array(
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						),
					),
					'color' => array(
						'scheme' => array(
							'type'  => Color::get_type(),
							'value' => Color::COLOR_3,
						),
						'default' => '#e7e7e7',
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'table_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'table_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['table'],
			)
		);

		$this->add_responsive_control(
			'table_padding',
			array(
				'label'      => esc_html__( 'Table Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['table'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'order_heading',
			[
				'label'     => esc_html__( 'Order', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'header_order',
			[
				'label'     => esc_html__( 'Header Order', 'phox-host' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 4,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['header'] => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_order',
			[
				'label'     => esc_html__( 'Price Order', 'phox-host' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 2,
				'min'       => 1,
				'max'       => 4,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['price'] => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'features_order',
			[
				'label'     => esc_html__( 'Features Order', 'phox-host' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3,
				'min'       => 1,
				'max'       => 4,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['features'] => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'footer_order',
			[
				'label'     => esc_html__( 'Footer Order', 'phox-host' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4,
				'min'       => 1,
				'max'       => 4,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['footer'] => 'order: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_header_style',
			array(
				'label'      => esc_html__( 'Header', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'header_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'header_title_style',
			array(
				'label'     => esc_html__( 'Title', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'  => esc_html__( 'Title Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}}',
				),
				'default' => '#1b3a4e',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['title'],
			)
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			]
		);

		$this->add_control(
			'header_subtitle_style',
			array(
				'label'     => esc_html__( 'Subtitle', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'subtitle_color',
			array(
				'label'  => esc_html__( 'Subtitle Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['subtitle'] => 'color: {{VALUE}}',
				),
				'default' => '#708791',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'subtitle_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['subtitle'],
			)
		);

		$this->add_responsive_control(
			'header_padding',
			array(
				'label'      => esc_html__( 'Header Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'header_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'header_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['header'],
			)
		);

		$this->add_responsive_control(
			'header_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_above_title_style',
			[
				'label'      => esc_html__( 'Above Title', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'icon_box_border',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['icon'],
				'condition'  => [
					'above_title' => 'icon',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'icon_box_background',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['icon'],
				'condition'  => [
					'above_title' => 'icon',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'icon_box_shadow',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['icon'],
				'condition'  => [
					'above_title' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_box_color', [
				'label'  => esc_html__( 'Icon Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_2,
				],
				'condition'  => [
					'above_title' => 'icon',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'color: {{VALUE}}',
				],
				'default' => '#1b3a4e',
			]
		);

		$this->add_responsive_control(
			'icon_box_font-size',
			[
				'label'   => esc_html__( 'Font Size', 'phox-host' ),
				'type'    => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 5,
					],
					'em' => [
						'min'  => 0,
						'max'  => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'above_title' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'icon_box_width',
			[
				'label'   => esc_html__( 'Box Size', 'phox-host' ),
				'type'    => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 500,
						'step' => 5,
					],
					'%' => [
						'min'  => 0,
						'max'  => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'above_title' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'icon_wrap_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon_wrap'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
				'condition'  => [
					'above_title' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'icon_box_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon_wrap'] => 'text-align: {{VALUE}};',
				),
				'condition'  => [
					'above_title' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'image_above_title_width',
			[
				'label'   => esc_html__( 'Width', 'phox-host' ),
				'type'    => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
					],
					'%' => [
						'min'  => 0,
						'max'  => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['image'] => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'image_above_title_space',
			[
				'label'   => esc_html__( 'Max Width', 'phox-host' ),
				'type'    => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'   => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
					],
					'%' => [
						'min'  => 0,
						'max'  => 100,
					],
				],
				'default' => [
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['image'] => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->add_control(
			'image_above_title_separator',
			[
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->start_controls_tabs( 'image_effects' );
		$this->start_controls_tab(
			'normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->add_control(
			'image_above_title_opacity',
			[
				'label' => __( 'Opacity', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['image'] => 'opacity: {{SIZE}};',
				],
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_above_title_css_filters',
				'selector' => '{{WRAPPER}} ' . $css_scheme['image'],
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => __( 'Hover', 'elementor' ),
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->add_control(
			'image_above_title_opacity_hover',
			[
				'label' => __( 'Opacity', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['image'] . ':hover' => 'opacity: {{SIZE}};',

				],
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_above_title_css_filters_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['image'] . ':hover',
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->add_control(
			'image_above_title_background_hover_transition',
			[
				'label' => __( 'Transition Duration', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['image'] => 'transition-duration: {{SIZE}}s',
				],
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->add_control(
			'image_above_title_hover_animation',
			[
				'label' => __( 'Hover Animation', 'elementor' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_above_title_border',
				'selector' => '{{WRAPPER}} ' . $css_scheme['image'],
				'separator' => 'before',
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->add_responsive_control(
			'image_above_title_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['image'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_above_title_box_shadow',
				'exclude' => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} ' . $css_scheme['image'],
				'condition'  => [
					'above_title' => 'image',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pricing_style',
			array(
				'label'      => esc_html__( 'Pricing', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'price_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'price_prefix_style',
			array(
				'label'     => esc_html__( 'Prefix', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_prefix_color',
			array(
				'label' => esc_html__( 'Price Prefix Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_prefix'] => 'color: {{VALUE}}',
				),
				'default' => '#1b3a4e',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_prefix_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['price_prefix'],
			)
		);

		$this->add_control(
			'price_prefix_display',
			array(
				'label'   => esc_html__( 'Prefix Display', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inline-block' => esc_html__( 'Inline', 'phox-host' ),
					'block'        => esc_html__( 'Block', 'phox-host' ),
				),
				'default' => 'inline-block',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_prefix'] => 'display: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'price_prefix_currency_position',
			array(
				'label'   => esc_html__( 'Vertical Currency Position', 'phox-host' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '-8',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_prefix'] => 'top: {{VALUE}}px;',
				),
			)
		);

		$this->add_control(
			'price_discount_style',
			array(
				'label'     => esc_html__( 'Discount', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'discount' => 'yes',
				],
			)
		);
		$this->add_control(
			'discount_color',
			[
				'label' => esc_html__( 'Discount Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['price_discount'] => 'color: {{VALUE}}',
				],
				'condition' => [
					'discount' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'price_discount',
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}}  ' . $css_scheme['price_discount'],
				'condition' => [
					'discount' => 'yes',
				],
			]
		);

		$this->add_control(
			'price_val_style',
			array(
				'label'     => esc_html__( 'Price Value', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label' => esc_html__( 'Price Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#c51e3a',
				'scheme' => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_value'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'price_typography',
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}}  ' . $css_scheme['price_value'],
			)
		);

		$this->add_control(
			'price_suffix_style',
			array(
				'label'     => esc_html__( 'Suffix', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_suffix_color',
			array(
				'label' => esc_html__( 'Price Suffix Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#c51e3a',
				'scheme' => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_suffix'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_suffix_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['price_suffix'],
			)
		);

		$this->add_control(
			'price_suffix_dispaly',
			array(
				'label'   => esc_html__( 'Suffix Display', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inline-block' => esc_html__( 'Inline', 'phox-host' ),
					'block'        => esc_html__( 'Block', 'phox-host' ),
				),
				'default'   => 'inline-block',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_suffix'] => 'display: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'price_desc_style',
			array(
				'label'     => esc_html__( 'Description', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_desc_color',
			array(
				'label' => esc_html__( 'Price Description Color', 'phox-host' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_desc'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_desc_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['price_desc'],
			)
		);

		$this->add_control(
			'price_desc_gap',
			array(
				'label' => esc_html__( 'Gap', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 30,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['price_desc'] => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'price_padding',
			array(
				'label'      => esc_html__( 'Pricing Block Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'price_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['price'],
			)
		);

		$this->add_responsive_control(
			'price_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'price_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['price'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_features_style',
			array(
				'label'      => esc_html__( 'Features', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'features_header_style',
			array(
				'label'     => esc_html__( 'Features Header', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'features_header_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['features_header'],
			)
		);

		$this->add_control(
			'features_header_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features_header'] => 'color: {{VALUE}}',
				),
			]
		);

		$this->add_responsive_control(
			'features_header_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['features_header'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'features_header_padding',
			array(
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['features_header'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'feature_item_style',
			[
				'label'     => esc_html__( 'Feature Item', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'features_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features_wrap'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'features_padding',
			array(
				'label'      => esc_html__( 'Features Block Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['features_wrap'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'features_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['features_wrap'],
			)
		);

		$this->add_responsive_control(
			'features_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['features_wrap'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'features_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['features_wrap'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'feature_item_effects' );
		$this->start_controls_tab(
			'feature_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'features_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['features_item'],
			)
		);

		$this->add_control(
			'feature_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['feature_item'] => 'color: {{VALUE}}',
				),
				'default' => '#708791',
			]
		);

		$this->add_control(
			'feature_icon_size_text_indent',
			[
				'label'   => esc_html__( 'Text Indent', 'phox-host' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['feature_item_text']  => 'padding-left: {{SIZE}}{{UNIT}};',
				),
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'feature_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'features_typography_hover',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['features_item'] . ':hover',
			)
		);

		$this->add_control(
			'feature_color_hover',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_2,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['feature_item'] . ':hover' => 'color: {{VALUE}}',
				),
				'default' => '#708791',
			]
		);

		$this->add_control(
			'feature_icon_size_text_indent_hover',
			[
				'label'   => esc_html__( 'Text Indent', 'phox-host' ),
				'type'    => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['feature_item_text'] . ':hover'  => 'padding-left: {{SIZE}}{{UNIT}};',
				),
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'feature_icon_style',
			[
				'label'     => esc_html__( 'Feature Icon', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'feature_icon_size',
			[
				'label'   => esc_html__( 'Icon Size', 'phox-host' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 14,
					'unit' => 'px',
				),
				'range' => array(
					'px' => array(
						'min' => 6,
						'max' => 90,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['feature_item'] . ' .feature-icon:before' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['feature_item'] . ' .feature-icon' => 'width: {{SIZE}}{{UNIT}};',
				),
			]
		);

		$this->add_control(
			'feature_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_4,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['feature_item'] . ' .feature-icon:before' => 'color: {{VALUE}}',
				),
				'default' => '#c51e3a',
			]
		);

		$this->add_control(
			'feature_image_style',
			array(
				'label'     => esc_html__( 'Feature Image', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'feature_image_size',
			array(
				'label'   => esc_html__( 'Image Size', 'phox-host' ),
				'type'    => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default' => array(
					'size' => 14,
					'unit' => 'px',
				),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 90,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['feature_item'] . ' .feature-image' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'features_divider_style',
			array(
				'label'     => esc_html__( 'Features Divider', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'features_divider',
			array(
				'label'        => esc_html__( 'Divider', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'features_divider_line',
			array(
				'label' => esc_html__( 'Style', 'phox-host' ),
				'type' => Controls_Manager::SELECT,
				'options' => array(
					'solid' => esc_html__( 'Solid', 'phox-host' ),
					'double' => esc_html__( 'Double', 'phox-host' ),
					'dotted' => esc_html__( 'Dotted', 'phox-host' ),
					'dashed' => esc_html__( 'Dashed', 'phox-host' ),
				),
				'default' => 'solid',
				'condition' => array(
					'features_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'border-top-style: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'features_divider_color',
			array(
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type' => Color::get_type(),
					'value' => Color::COLOR_3,
				),
				'condition' => array(
					'features_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'border-top-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'features_divider_weight',
			array(
				'label'   => esc_html__( 'Weight', 'phox-host' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 1,
					'unit' => 'px',
				),
				'range' => array(
					'px' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'condition' => array(
					'features_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'border-top-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'features_divider_width',
			array(
				'label' => esc_html__( 'Width', 'phox-host' ),
				'type' => Controls_Manager::SLIDER,
				'condition' => array(
					'features_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'width: {{SIZE}}%',
				),
			)
		);

		$this->add_control(
			'features_divider_gap',
			array(
				'label' => esc_html__( 'Gap', 'phox-host' ),
				'type' => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 15,
					'unit' => 'px',
				),
				'range' => array(
					'px' => array(
						'min' => 1,
						'max' => 50,
					),
				),
				'condition' => array(
					'features_divider' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['features_item'] . ':before' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_footer_style',
			[
				'label'      => esc_html__( 'Footer', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'action_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['footer'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'action_color',
			array(
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['footer'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'action_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['footer'],
			)
		);

		$this->add_responsive_control(
			'action_padding',
			array(
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['footer'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'action_margin',
			array(
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['footer'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'action_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['footer'],
			)
		);

		$this->add_responsive_control(
			'action_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['footer'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'action_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['footer'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'footer_button',
			array(
				'label'     => esc_html__( 'Button', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'button_size',
			array(
				'label'   => esc_html__( 'Size', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'auto',
				'options' => array(
					'auto' => esc_html__( 'auto', 'phox-host' ),
					'full'  => esc_html__( 'full', 'phox-host' ),
				),
			)
		);

		$this->add_control(
			'add_button_icon',
			array(
				'label'        => esc_html__( 'Add Icon', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'button_icon',
			array(
				'label'       => esc_html__( 'Icon', 'phox-host' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'file'        => '',
				'default'     => [
				        'value' =>'fas fa-shopping-cart'
                ],
				'condition' => array(
					'add_button_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'button_icon_position',
			array(
				'label'   => esc_html__( 'Icon Position', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'left'  => esc_html__( 'Before Text', 'phox-host' ),
					'right' => esc_html__( 'After Text', 'phox-host' ),
				),
				'default'     => 'left',
				'render_type' => 'template',
				'selectors'   => array(
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'float: {{VALUE}}',
				),
				'condition' => array(
					'add_button_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'button_icon_size',
			array(
				'label' => esc_html__( 'Icon Size', 'phox-host' ),
				'type' => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 7,
						'max' => 90,
					),
				),
				'condition' => array(
					'add_button_icon' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'button_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'add_button_icon' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'button_icon_margin',
			array(
				'label'      => esc_html__( 'Icon Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'condition' => array(
					'add_button_icon' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'phox-host' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
				'types'    => [ 'classic', 'gradient' ],
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'scheme'   => Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'],
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'phox-host' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_hover_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color' => array(
						'label' => _x( 'Background Color', 'Background Control', 'phox-host' ),
					),
					'color_b' => array(
						'label' => _x( 'Second Background Color', 'Background Control', 'phox-host' ),
					),
				),
				'exclude' => array(
					'image',
					'position',
					'attachment',
					'attachment_alert',
					'repeat',
					'size',
				),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_hover_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'button_hover_padding',
			array(
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_hover_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_strip_style',
			array(
				'label'      => esc_html__( 'Strip', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition' => array(
					'strip' => 'yes',
				),
			)
		);

		$this->add_control(
			'strip_default_style',
			[
				'label'     => esc_html__( 'Default', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'price_strip_type' => 'strip_default',
				),
			]
		);

		$this->add_control(
			'strip_default_bg',
			[
				'label'     => esc_html__( 'Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['strip_default'] => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'price_strip_type' => 'strip_default',
				),
			]
		);

		$this->add_control(
			'strip_default_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#c51e3a',
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['strip_default'] => 'color: {{VALUE}}',
				),
				'condition' => array(
					'price_strip_type' => 'strip_default',
				),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'  => 'strip_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['strip_default'],
				'scheme'   => Typography::TYPOGRAPHY_4,
				'condition' => array(
					'price_strip_type' => 'strip_default',
				),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'  => 'box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['strip_default'],
				'condition' => array(
					'price_strip_type' => 'strip_default',
				),
			]
		);

		$this->add_control(
			'strip_custom_style',
			[
				'label'     => esc_html__( 'Custom', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'price_strip_type' => 'strip_custom',
				),
			]
		);

		$this->add_responsive_control(
			'stripe_custom_left',
			[
				'label'      => esc_html__( 'Left Indent', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -200,
						'max' => 200,
					),
					'%' => array(
						'min' => -50,
						'max' => 50,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'strip_custom_position' => 'left',
					'price_strip_type' => 'strip_custom',
				),
				'selectors'  => array(
					'{{WRAPPER}}' . $css_scheme['strip_custom'] => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			]
		);

		$this->add_responsive_control(
			'stripe_custom_right',
			[
				'label'      => esc_html__( 'Right Indent', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -200,
						'max' => 200,
					),
					'%' => array(
						'min' => -50,
						'max' => 50,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'strip_custom_position' => 'right',
					'price_strip_type' => 'strip_custom',
				),
				'selectors'  => array(
					'{{WRAPPER}}' . $css_scheme['strip_custom'] => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			]
		);

		$this->add_responsive_control(
			'stripe_custom_top',
			[
				'label'      => esc_html__( 'Top Indent', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -200,
						'max' => 200,
					),
					'%' => array(
						'min' => -50,
						'max' => 50,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['strip_custom'] => 'top: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'price_strip_type' => 'strip_custom',
				),
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render section header widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
        $settings = $this->get_settings_for_display();
		?>

		<div class="wdes-pricing-table">
			<div class = "wdes-pricing-table-heading">
				<?php
				if ( $settings['above_title'] === 'image' ) {

					$this->render_html_block( $settings['image']['url'], '<img class="wdes-pricing-table-img" src="%s" />' );

				} else {

                    if( ! empty( $settings['icon']['value'] ) ){
	                    $this->render_html_block( $settings['icon']['value'], '<div class="wdes-pricing-table-icon" ><div class="wdes-pricing-table-icon-box" ><i class="%s" ></i></div></div>' );
                    }

				}
				?>
				<?php $this->render_html_block( $settings['title'], '<h2 class="wdes-pricing-table-title" >%s</h2>' ); ?>
				<?php $this->render_html_block( $settings['subtitle'], '<h4 class="wdes-pricing-table-subtitle" >%s</h4>' ); ?>
			</div>

			<div class="wdes-pricing-table-price" >
				<?php $this->render_html_block( $settings['perfix'], '<span class="wdes-pricing-table-price-perfix" >%s</span>' ); ?>
				<?php $this->render_html_block( $settings['price'], '<span class="wdes-pricing-table-price-num" >%s</span>' ); ?>
				<?php
				if ( helpers::check_var_true( $settings['discount'] ) ) {
					$this->render_html_block( $settings['original_price'], '<span class="wdes-pricing-table-price-original" >%s</span>' );
				}
				?>
				<?php $this->render_html_block( $settings['suffix'], '<span class="wdes-pricing-table-price-suffix" >%s</span>' ); ?>
				<?php $this->render_html_block( $settings['desc'], '<p class="wdes-pricing-table-price-desc" >%s</p>' ); ?>
			</div>

			<div class="wdes-pricing-table-features">
				<?php $this->render_html_block( $settings['feature_header'], '<span class="wdes-pricing-table-features-header" >%s</span>' ); ?>
				<div class="wdes-pricing-table-features-wrap">
					<?php
					if ( is_array( $settings['feature_items'] ) ) {

						$items = $settings['feature_items'];

						foreach ( $items as $item ) {
							$class = 'pricing-feature-' . $item['_id']
							?>

								<div class="wdes-pricing-feature <?php echo $class; ?>">
									<div class="wdes-pricing-feature-inner" >
									<?php
									if ( $item['item_decoration'] === 'image' ) {
										printf( '<img src="%s" class="feature-image" >', $item['item_image']['url'] );
									} else {
										printf( '<i class="feature-icon %s" ></i>', $item['item_icon']['value'] );
									}

										$this->render_html_block( $item['item_title'], '<span class="wdes-pricing-table-features-text" >%s</span>' );
									?>
									</div>
								</div>

								<?php
						}
					}
					?>
				</div>
			</div>
			<div class="wdes-pricing-feature-footer">
				<?php $this->render_html_block( $settings['button_before'], '<span class="wdes-pricing-table-footer-before" >%s</span>' ); ?>
				<?php
				if ( ! empty( $settings['button_link']['url'] ) ) {

					$this->add_render_attribute(
						'footer-button', [
							'class' => [
								'pricing-table-button',
								'button-' . $settings['button_size'] . '-size',
							],
							'href' => $settings['button_link'],
						]
					);

					if ( $settings['button_link']['nofollow'] ) {
						$this->add_render_attribute( 'footer-button', 'rel', 'nofollow' );
					}

					if ( ! empty( $settings['button_link']['is_external'] ) ) {
						$this->add_render_attribute( 'footer-button', 'target', '_blank' );
					}

					$button_text = $settings['button_text'];

					if ( helpers::check_var_true( $settings['add_button_icon'] ) ) {

						switch ( $settings['button_icon_position'] ) {
							case 'left':
								$button_text = '<i class="pricing-table-button-icon ' . $settings['button_icon'] . '" ></i>' . $settings['button_text'];
								break;

							case 'right':
								$button_text = $settings['button_text'] . ' <i class="pricing-table-button-icon ' . $settings['button_icon'] . '" ></i> ';
								break;
						}
					}

					printf( '<a %1$s >%2$s</a>',
						$this->get_render_attribute_string( 'footer-button' ),
						$button_text
					);
				}
				?>
				<?php $this->render_html_block( $settings['button_after'], '<span class="wdes-pricing-table-footer-after" >%s</span>' ); ?>

			</div>
		</div>

		<?php
		if ( helpers::check_var_true( $settings['strip'] ) ) {

			switch ( $settings['price_strip_type'] ) {

				case 'strip_default':
					if ( ! empty( $settings['strip_default_title'] ) ) {

						$this->add_render_attribute(
							'strip_default',
							'class',
							[ 'wdes-pricing-table-strip-default', 'wdes-strip-default-' . $settings['strip_default_position'] ]
						);

						$this->add_render_attribute(
							'strip_default_title',
							'class',
							'wdes-pricing-table-strip-default-inner'
						);

						echo sprintf('<div %1$s><div %2$s>%3$s</div></div>',
							$this->get_render_attribute_string( 'strip_default' ),
							$this->get_render_attribute_string( 'strip_default_title' ),
							$settings['strip_default_title']
						);
					}

					break;

				case 'strip_custom':
					$this->add_render_attribute(
						'strip_custom_image',
						'class',
						[ 'wdes-pricing-table-strip-custom-image', 'wdes-strip-custom-' . $settings['strip_custom_position'] ]
					);

					echo sprintf('<img src="%2$s" %1$s >',
						$this->get_render_attribute_string( 'strip_custom_image' ),
						$settings['strip_custom_image']['url']
					);
					break;
			}
		}
		?>
		<?php

	}


}
