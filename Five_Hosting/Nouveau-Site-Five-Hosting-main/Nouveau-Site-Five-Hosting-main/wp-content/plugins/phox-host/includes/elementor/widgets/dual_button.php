<?php
namespace Phox_Host\Elementor\Widgets;

use \Elementor\Plugin;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Schemes\Color;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Utils;
use \Elementor\Control_Media;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Background;
use \Phox\helpers as Helper;
use  Phox_Host\Elementor\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Button widget.
 *
 * Button widget that will display in Phox category
 *
 * @package Elementor\Widgets
 * @since 1.4.6
 */
class Dual_Button extends Base_Widget {
	/**
	 * Get Widget name
	 *
	 * Retrieve Dual Button widget name
	 *
	 * @since  1.4.6
	 * @access public
	 *
	 * @return string Widget name
	 */
	public function get_name() {
		return 'wdes_dual_button';
	}

	/**
	 * Get Widget Title
	 *
	 * Retrieve Dual Button widget title
	 *
	 * @since  1.4.6
	 * @access public
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( 'Dual Button', 'phox-host' );
	}

	/**
	 * Get Widget icon
	 *
	 * Retrieve Dual Button widget icon
	 *
	 * @since  1.4.6
	 * @access public
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'wdes-widget-elementor wdes-widget-dual-button';
	}

	/**
	 * Get Widget keywords
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since  1.4.6
	 * @access public
	 *
	 * @return array widget keywords.
	 */
	public function get_keywords() {
		return [ 'button' ];
	}

	/**
	 * Register Widget widget controls
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.4.6
	 * @access protected
	 */
	protected function register_controls() {

		$css_scheme = [
			'container'    => '.wdes-dual-button-container',
			'button'       => '.wdes-dual-button-instance',
			'plane_normal' => '.wdes-dual-button-plane-normal',
			'plane_hover'  => '.wdes-dual-button-plane-hover',
			'state_normal' => '.wdes-dual-button-state-normal',
			'state_hover'  => '.wdes-dual-button-state-hover',
			'icon_normal'  => '.wdes-dual-button-state-normal .wdes-dual-button-icon',
			'label_normal' => '.wdes-dual-button-state-normal .wdes-dual-button-label',
			'icon_hover'   => '.wdes-dual-button-state-hover .wdes-dual-button-icon',
			'label_hover'  => '.wdes-dual-button-state-hover .wdes-dual-button-label',
		];

		$this->start_controls_section(
			'dual_button_section',
			[
				'label'     => esc_html__( 'Dual Button', 'phox-host' ),
			]
		);

		$this->add_control(
			'dual_button_url',
			[
				'label' => esc_html__( 'Link', 'phox-host' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => [
					'url' => '#',
				],
				'separator' => 'before',
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'use_dual_button_icon',
			[
				'label'        => esc_html__( 'Show Icon', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'dual_button_icon_position',
			[
				'label'   => esc_html__( 'Icon Position', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'left'   => esc_html__( 'Left', 'phox-host' ),
					'top'    => esc_html__( 'Top', 'phox-host' ),
					'right'  => esc_html__( 'Right', 'phox-host' ),
					'bottom' => esc_html__( 'Bottom', 'phox-host' ),
				],
				'default'     => 'left',
				'render_type' => 'template',
				'condition' => [
					'use_dual_button_icon' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_dual_button_content' );

		$this->start_controls_tab(
			'tab_dual_button_content_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'dual_button_icon_normal',
			[
				'label'       => esc_html__( 'Button Icon', 'phox-host' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default' => [
					'value' => 'fas fa-check',
					'library' => 'fa-solid',
				],
				'condition' => [
					'use_dual_button_icon' => 'yes',
				]
			]
		);

		$this->add_control(
			'dual_button_label_normal',
			[
				'label'       => esc_html__( 'Label Text', 'phox-host' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Click Me', 'phox-host' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dual_button_content_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'dual_button_icon_hover',
			[
				'label'       => esc_html__( 'Button Icon', 'phox-host' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'default' => [
					'value' => 'fas fa-check',
					'library' => 'fa-solid',
				],
				'condition' => [
					'use_dual_button_icon' => 'yes',
				]
			]
		);

		$this->add_control(
			'dual_button_label_hover',
			[
				'label'       => esc_html__( 'Label Text', 'phox-host' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Go', 'phox-host' ),
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'use_dual_button_effect',
			[
				'label'        => esc_html__( 'Show Hover Effect', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'hover_effect',
			array(
				'label'   => esc_html__( 'Hover Effect', 'phox-host' ),
				'type'    => Controls_Manager::SELECT2,
				'label_block' => true,
				'default' => 'effect-1',
				'options' => [
					'effect-0'  => esc_html__( 'None', 'phox-host' ),
					'effect-1'  => esc_html__( 'Fade In', 'phox-host' ),
					'effect-2'  => esc_html__( 'Slide In Up', 'phox-host' ),
					'effect-3'  => esc_html__( 'Slide In Down', 'phox-host' ),
					'effect-4'  => esc_html__( 'Slide In Right', 'phox-host' ),
					'effect-5'  => esc_html__( 'Slide In Left', 'phox-host' ),
					'effect-6'  => esc_html__( 'Scale Up', 'phox-host' ),
					'effect-7'  => esc_html__( 'Scale Down', 'phox-host' ),
					'effect-8'  => esc_html__( 'Top Diagonal Slide', 'phox-host' ),
					'effect-9'  => esc_html__( 'Bottom Diagonal Slide', 'phox-host' ),
					'effect-10' => esc_html__( 'Bounce In Right', 'phox-host' ),
					'effect-11' => esc_html__( 'Bounce In Left', 'phox-host' ),
				],
				'condition' => [
					'use_dual_button_effect' => 'yes',
				]
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'section_dual_button_general_style',
			[
				'label'      => esc_html__( 'General', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'custom_size',
			[
				'label'        => esc_html__( 'Custom Size', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'false',
			]
		);

		$this->add_responsive_control(
			'dual_button_custom_width',
			[
				'label'      => esc_html__( 'Custom Width', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em', '%',
				],
				'range'      => [
					'px' => [
						'min' => 40,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['button'] => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'custom_size' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'dual_button_custom_height',
			[
				'label'      => esc_html__( 'Custom Height', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em', '%',
				],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['button'] => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'custom_size' => 'yes',
				],
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'dual_button_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'flex-start',
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Start', 'phox-host' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-left' : 'eicon-h-align-right',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'phox-host' ),
						'icon'  => ! is_rtl() ? 'eicon-h-align-right' : 'eicon-h-align-left',
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['container'] => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'dual_button_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_general_styles' );

		$this->start_controls_tab(
			'tab_general_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'normal_dual_button_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'normal_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['button'],
			]
		);

		$this->add_responsive_control(
			'normal_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'normal_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_general_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'hover_dual_button_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'hover_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			]
		);

		$this->add_responsive_control(
			'hover_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dual_button_plane_style',
			[
				'label'      => esc_html__( 'Plane', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'dual_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['state_normal'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['state_hover'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_plane_styles' );

		$this->start_controls_tab(
			'tab_plane_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'normal_plane_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['plane_normal'],
				'fields_options' => [
					'color' => [
						'scheme' => [
							'type'  => Color::get_type(),
							'value' => Color::COLOR_1,
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'normal_plane_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['plane_normal'],
			]
		);

		$this->add_responsive_control(
			'normal_plane_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['plane_normal'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'normal_plane_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['plane_normal'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_plane_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'plane_hover_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['plane_hover'],
				'fields_options' => [
					'color' => [
						'scheme' => [
							'type'  => Color::get_type(),
							'value' => Color::COLOR_2,
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'plane_hover_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['plane_hover'],
			]
		);

		$this->add_responsive_control(
			'plane_hover_border_radius',
			[
				'label'      => __( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['plane_hover'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'hover_plane_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['plane_hover'],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_dual_button_icon_style',
			[
				'label'      => esc_html__( 'Icon', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->start_controls_tabs( 'tabs_icon_styles' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'normal_icon_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['icon_normal'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'normal_icon_font_size',
			[
				'label'      => esc_html__( 'Font Size', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em', 'rem',
				],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon_normal'] => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'normal_icon_box_width',
			[
				'label'      => esc_html__( 'Icon Box Width', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em', '%',
				],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon_normal'] => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'normal_icon_box_height',
			[
				'label'      => esc_html__( 'Icon Box Height', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em', '%',
				],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon_normal'] => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'normal_icon_box_color',
			[
				'label' => esc_html__( 'Icon Box Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['icon_normal'] => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'normal_icon_margin',
			[
				'label'      => __( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon_normal'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'normal_icon_box_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['icon_normal'],
			]
		);

		$this->add_control(
			'normal_icon_box_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon_normal'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'hover_icon_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['icon_hover'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'hover_icon_font_size',
			[
				'label'      => esc_html__( 'Font Size', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em', 'rem',
				],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon_hover'] => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'hover_icon_box_width',
			[
				'label'      => esc_html__( 'Icon Box Width', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em', '%',
				],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon_hover'] => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'hover_icon_box_height',
			[
				'label'      => esc_html__( 'Icon Box Height', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px', 'em', '%',
				],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon_hover'] => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hover_icon_box_color',
			[
				'label' => esc_html__( 'Icon Box Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['icon_hover'] => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'hover_icon_margin',
			[
				'label'      => __( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon_hover'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'hover_icon_box_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['icon_hover'],
			]
		);

		$this->add_control(
			'hover_icon_box_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon_hover'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'section_dual_button_label_style',
			[
				'label'      => esc_html__( 'Label', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'label_text_alignment',
			[
				'label'   => esc_html__( 'Text Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['label_normal'] => 'text-align: {{VALUE}};',
					'{{WRAPPER}} ' . $css_scheme['label_hover'] => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'label_margin',
			[
				'label'      => __( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'before',
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['label_normal'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['label_hover'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_label_styles' );

		$this->start_controls_tab(
			'tab_label_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'normal_label_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['label_normal'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'normal_label_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['label_normal'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_label_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'hover_label_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['label_hover'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'hover_label_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['label_hover'],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.4.6
	 * @access protected
	 */
	protected function render(){

		$settings = $this->get_settings_for_display();

		$position = $settings[ 'dual_button_icon_position' ];
		$show_icon = $settings[ 'use_dual_button_icon' ];
		$show_effect = $settings[ 'use_dual_button_effect' ];
		$hover_effect = $settings[ 'hover_effect' ];

		$this->add_render_attribute( 'wdes-button', 'class', 'wdes-dual-button-instance' );
		$this->add_render_attribute( 'wdes-button', 'class', 'wdes-dual-button-instance--icon-' . $position );
		if( $show_effect === 'yes' ){
			$this->add_render_attribute( 'wdes-button', 'class', $hover_effect );
		}

		$tag = 'div';

		if ( ! empty( $settings['dual_button_url']['url'] ) ) {
			$this->add_render_attribute( 'wdes-button', 'href', $settings['dual_button_url']['url'] );

			if ( $settings['dual_button_url']['is_external'] ) {
				$this->add_render_attribute( 'wdes-button', 'target', '_blank' );
			}

			if ( $settings['dual_button_url']['nofollow'] ) {
				$this->add_render_attribute( 'wdes-button', 'rel', 'nofollow' );
			}

			$tag = 'a';
		}
		printf( '<div class="elementor-%s wdes-elements">', $this->get_name() );
			print ( '<div class="wdes-dual-button-container">' );
				printf( '<%1$s  %2$s >', $tag, $this->get_render_attribute_string( 'wdes-button' ) );
					print ( '<div class="wdes-dual-button-plane wdes-dual-button-plane-normal"></div>' );
					print ( '<div class="wdes-dual-button-plane wdes-dual-button-plane-hover"></div>' );
					print ( '<div class="wdes-dual-button-state wdes-dual-button-state-normal">' );
						if ( Helper::check_var_true( $show_icon ) ) {
							printf( '<span class="wdes-dual-button-icon wdes-elements-icon"><i class="%s"></i></span>', $settings['dual_button_icon_normal']['value'] );
						}
						printf(  '<span class="wdes-dual-button-label">%s</span>', $settings['dual_button_label_normal'] );
					print ( '</div>' );

					print ( '<div class="wdes-dual-button-state wdes-dual-button-state-hover">' );
						if ( Helper::check_var_true( $show_icon ) ) {
							printf( '<span class="wdes-dual-button-icon wdes-elements-icon"><i class="%s"></i></span>', $settings['dual_button_icon_hover']['value'] );
						}
						printf(  '<span class="wdes-dual-button-label">%s</span>', $settings['dual_button_label_hover'] );
					print ( '</div>' );
				printf('</%s>', $tag);
			print ('</div>');
		print ('</div>');

	}



}