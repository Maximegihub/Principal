<?php

namespace Phox_Host\Elementor\Widgets;

use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Utils;
use Elementor\Repeater;
use Phox\helpers;
use Phox_Host\Elementor\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Tabs widget.
 *
 * Tabs widget that will display in Phox category
 *
 * @package Elementor\Widgets
 * @since 1.4.0
 */
class Tabs extends Base_Widget {

	/**
	 * Get Widget name
	 *
	 * Retrieve Tabs widget name
	 *
	 * @return string Widget name
	 * @since  1.4.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'wdes_tabs';
	}

	/**
	 * Get Widget title
	 *
	 * Retrieve Tabs widget title
	 *
	 * @return string Widget title
	 * @since  1.4.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Tabs', 'phox-host' );
	}

	/**
	 * Get Widget icon
	 *
	 * Retrieve Tabs widget icon
	 *
	 * @return string Widget icon
	 * @since  1.4.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'wdes-widget-elementor wdes-widget-tabs';
	}


	/**
	 * Get Widget keywords
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array widget keywords.
	 * @since  1.4.0
	 * @access public
	 *
	 */
	public function get_keywords() {
		return [ 'tabs', 'accordion', 'toggle' ];
	}

	/**
	 * Register Tabs widget controls
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.4.0
	 * @access protected
	 */
	protected function register_controls() {

		$css_scheme = [
			'instance'        => '.elementor-widget-container > .wdes-tabs',
			'control_wrapper' => '.elementor-widget-container > .wdes-tabs > .nav-tabs',
			'control'         => '.elementor-widget-container > .wdes-tabs > .nav-tabs > .nav-item > .nav-link',
			'content_wrapper' => '.elementor-widget-container > .wdes-tabs > .tabs-area-features > .wdes-wrap-tabs-content > .tab-content',
			'content'         => '.elementor-widget-container > .wdes-tabs > .tabs-area-features > .wdes-wrap-tabs-content > .tab-content > .tab-pane',
			'label'           => '.wdes-tabs-control-text',
			'label_desc'      => '.wdes-tabs-control-description',
			'icon'            => '.wdes-tabs-control-icon',
		];

		$this->start_controls_section(
			'tab_items_section',
			[
				'label' => esc_html__( 'Content', 'phox-host' ),
			]
		);

		$tab_items = new Repeater();

		$tab_items->add_control(
			'tab_label',
			[
				'label'       => esc_html__( 'Title', 'phox-host' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Tab Title', 'phox-host' ),
				'dynamic'     => [
					'active' => true,
				],
				'label_block' => true,
			]
		);

		$tab_items->add_control(
			'tab_description',
			[
				'label'       => esc_html__( 'Description', 'phox-host' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'label_block' => true,
			]
		);

		$tab_items->add_control(
			'text_decoration',
			[
				'label'   => __( 'Text Decoration', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'image' => [
						'title' => esc_html__( 'Image', 'phox-host' ),
						'icon'  => 'eicon-image',
					],
					'icon'  => [
						'title' => esc_html__( 'Icon', 'phox-host' ),
						'icon'  => 'eicon-font-awesome',
					],
				],
				'default' => 'icon',
			]
		);

		$tab_items->add_control(
			'tab_icon',
			[
				'label'       => esc_html__( 'Icon', 'phox-host' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
				'file'        => '',
				'default'     => [
					'value' => 'fas fa-arrows-alt'
				],
				'condition'   => [
					'text_decoration' => 'icon',
				],
			]
		);

		$tab_items->add_control(
			'tab_image',
			[
				'label'     => esc_html__( 'Image', 'phox-host' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'text_decoration' => 'image',
				],
			]
		);

		$tab_items->add_control(
			'content_type',
			[
				'label'       => esc_html__( 'Content Type', 'phox-host' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'editor',
				'options'     => [
					'template' => esc_html__( 'Template', 'phox-host' ),
					'editor'   => esc_html__( 'Editor', 'phox-host' ),
				],
				'label_block' => 'true',
			]
		);

		$tab_items->add_control(
			'tab_editor_content',
			[
				'label'     => esc_html__( 'Content', 'phox-host' ),
				'type'      => Controls_Manager::WYSIWYG,
				'default'   => esc_html__( 'Tab Content', 'phox-host' ),
				'dynamic'   => [
					'active' => true,
				],
				'condition' => [
					'content_type' => 'editor',
				],
			]
		);

		$tab_items->add_control(
			'tab_template_content',
			[
				'label'       => esc_html__( 'Templates', 'phox-host' ),
				'type'        => 'wdes-select-templates',
				'condition'   => [
					'content_type' => 'template',
				],
				'label_block' => 'true',
			]
		);

		$tab_items->add_control(
			'tab_animation',
			[
				'label'     => esc_html__( 'Animation Settings', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$tab_items->add_control(
			'tab_animation_effect',
			[
				'label'       => esc_html__( 'Animation Effect', 'phox-host' ),
				'type'        => 'wdes-animate-effect',
				'label_block' => 'true',

			]
		);

		$tab_items->add_control(
			'tab_animation_delay',
			[
				'label'       => esc_html__( 'Animation Delay', 'phox-host' ),
				'type'        => 'wdes-animate-delay',
				'label_block' => 'true',
			]
		);

		$tab_items->add_control(
			'tab_animation_speed',
			[
				'label'       => esc_html__( 'Animation Speed', 'phox-host' ),
				'type'        => 'wdes-animate-speed',
				'label_block' => 'true',
			]
		);


		$this->add_control(
			'tab_items',
			[
				'label'       => __( 'Tab Items', 'phox-host' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $tab_items->get_controls(),
				'default'     => [
					[
						'tab_label' => esc_html__( ' Tab #1', 'phox-host' ),
					],
					[
						'tab_label' => esc_html__( ' Tab #2', 'phox-host' ),
					],
					[
						'tab_label' => esc_html__( ' Tab #3', 'phox-host' ),
					],
				],
				'title_field' => '{{{tab_label}}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_general_style',
			[
				'label'      => esc_html__( 'General Tab', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'tabs_position',
			[
				'label'   => esc_html__( 'Tabs Position', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'left'   => esc_html__( 'Left', 'phox-host' ),
					'right'  => esc_html__( 'Right', 'phox-host' ),
					'top'    => esc_html__( 'Top', 'phox-host' ),
					'bottom' => esc_html__( 'Bottom', 'phox-host' ),
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_wrapper_width',
			[
				'label'     => esc_html__( 'Tabs Control Width', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'min' => 0,
					'max' => 100,
				],
				'condition' => [
					'tabs_position' => [ 'left', 'right' ],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['control_wrapper'] => 'min-width: {{SIZE}}%',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'tabs_container_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
			]
		);

		$this->add_responsive_control(
			'tabs_container_padding',
			[
				'label'      => __( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_container_margin',
			[
				'label'      => __( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'tabs_container_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['instance'],
			]
		);

		$this->add_responsive_control(
			'tabs_container_border_radius',
			[
				'label'      => __( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tabs_container_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
			]
		);

		$this->end_controls_section();

		/*
		 * Tabs Control Style Section
		 */
		$this->start_controls_section(
			'section_tabs_control_style',
			[
				'label'      => esc_html__( 'Tabs Control', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'tabs_controls_aligment',
			[
				'label'     => esc_html__( 'Tabs Alignment', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'flex-start',
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'condition' => [
					'tabs_position' => [ 'top', 'bottom' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'tabs_content_wrapper_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['control_wrapper'],
			]
		);

		$this->add_responsive_control(
			'tabs_control_wrapper_padding',
			[
				'label'      => __( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control_wrapper'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_wrapper_margin',
			[
				'label'      => __( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control_wrapper'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'tabs_control_wrapper_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['control_wrapper'],
			]
		);

		$this->add_responsive_control(
			'tabs_control_wrapper_border_radius',
			[
				'label'      => __( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control_wrapper'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tabs_control_wrapper_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['control_wrapper'],
			]
		);

		$this->end_controls_section();

		/**
		 * Tabs Control Style Section
		 */
		$this->start_controls_section(
			'section_tabs_control_item_style',
			[
				'label'      => esc_html__( 'Tabs Control Item', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'tabs_controls_item_aligment_top_icon',
			[
				'label'     => esc_html__( 'Alignment', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					],
				],
				'condition' => [
					'tabs_position'              => [ 'left', 'right' ],
					'tabs_control_icon_position' => 'top',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_controls_item_aligment_left_icon',
			[
				'label'     => esc_html__( 'Alignment', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'flex-start',
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					],
				],
				'condition' => [
					'tabs_position'              => [ 'left', 'right' ],
					'tabs_control_icon_position' => 'left',
				],
			]
		);

		$this->add_control(
			'tabs_control_icon_style_heading',
			[
				'label'     => esc_html__( 'Icon Styles', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'tabs_control_icon_margin',
			[
				'label'      => esc_html__( 'Icon Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ' .wdes-tabs-control-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_image_margin',
			[
				'label'      => esc_html__( 'Image Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ' .wdes-tabs-control-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_image_width',
			[
				'label'      => esc_html__( 'Image Width', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'em',
					'%',
				],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ' .wdes-tabs-control-image' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'tabs_control_icon_position',
			[
				'label'   => esc_html__( 'Icon Position', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Left', 'phox-host' ),
					'top'  => esc_html__( 'Top', 'phox-host' ),
				],
			]
		);

		$this->add_control(
			'tabs_control_image_position',
			[
				'label'   => esc_html__( 'Image Position', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Left', 'phox-host' ),
					'top'  => esc_html__( 'Top', 'phox-host' ),
				],
			]
		);

		$this->add_control(
			'tabs_control_state_style_heading',
			[
				'label'     => esc_html__( 'State Styles', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_control_styles' );

		$this->start_controls_tab(
			'tabs_control_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'tabs_control_label_color',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1b3a4e',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['label'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_control_label_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['label'],
			]
		);

		$this->add_control(
			'tabs_control_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1b3a4e',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['icon'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_icon_size',
			[
				'label'      => esc_html__( 'Icon Size', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'em',
					'rem',
				],
				'range'      => [
					'px' => [
						'min' => 18,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['icon'] => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'tabs_control_state_style_description',
			[
				'label'     => esc_html__( 'Description', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_control_label_desc_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['label_desc'],
			]
		);

		$this->add_control(
			'tabs_control_label_desc_color',
			[
				'label'     => esc_html__( 'Description Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['label_desc'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_label_desc_padding',
			[
				'label'      => __( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['label_desc'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_label_desc_margin',
			[
				'label'      => __( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['label_desc'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'tabs_control_background',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['control'],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'tabs_control_padding',
			[
				'label'      => __( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_margin',
			[
				'label'      => __( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'tabs_control_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['control'],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tabs_control_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_control_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'tabs_control_label_color_hover',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ':hover ' . $css_scheme['label'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_control_label_typography_hover',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'] . ':hover ' . $css_scheme['label'],
			]
		);

		$this->add_control(
			'tabs_control_icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ':hover ' . $css_scheme['icon'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_icon_size_hover',
			[
				'label'      => esc_html__( 'Icon Size', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'em',
					'rem',
				],
				'range'      => [
					'px' => [
						'min' => 18,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ':hover ' . $css_scheme['icon'] => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'tabs_control_state_style_hover_description',
			[
				'label'     => esc_html__( 'Description', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_control_label_desc_typography_hover',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['label_desc'] . ':hover',
			]
		);

		$this->add_control(
			'tabs_control_label_desc_color_hover',
			[
				'label'     => esc_html__( 'Description Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['label_desc'] . ':hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_label_desc_padding_hover',
			[
				'label'      => __( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['label_desc'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_label_desc_margin_hover',
			[
				'label'      => __( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ' ' . $css_scheme['label_desc'] . ':hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'tabs_control_background_hover',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['control'] . ':hover',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'tabs_control_padding_hover',
			[
				'label'      => __( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ':hover' . ' .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_margin_hover',
			[
				'label'      => __( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . ':hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'tabs_control_border_hover',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['control'] . ':hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tabs_control_box_shadow_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'] . ':hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_control_active',
			[
				'label' => esc_html__( 'Active', 'phox-host' ),
			]
		);

		$this->add_control(
			'tabs_control_label_color_active',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#c51e3a',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['control'] . '.active ' . $css_scheme['label'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_control_label_typography_active',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'] . '.active ' . $css_scheme['label'],
			]
		);

		$this->add_control(
			'tabs_control_icon_color_active',
			[
				'label'     => esc_html__( 'Icon Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#c51e3a',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['control'] . '.active ' . $css_scheme['icon'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_icon_size_active',
			[
				'label'      => esc_html__( 'Icon Size', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'em',
					'rem',
				],
				'range'      => [
					'px' => [
						'min' => 18,
						'max' => 200,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . '.active ' . $css_scheme['icon'] => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'tabs_control_state_style_active_description',
			[
				'label'     => esc_html__( 'Description', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_control_label_desc_typography_active',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'] . '.active ' . $css_scheme['label_desc'],
			]
		);

		$this->add_control(
			'tabs_control_label_desc_color_active',
			[
				'label'     => esc_html__( 'Description Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['control'] . '.active ' . $css_scheme['label_desc'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_label_desc_padding_active',
			[
				'label'      => __( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . '.active ' . $css_scheme['label_desc'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_label_desc_margin_active',
			[
				'label'      => __( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . '.active ' . $css_scheme['label_desc'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'tabs_control_background_active',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['control'] . '.active',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'tabs_control_padding_active',
			[
				'label'      => __( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . '.active' . ' .nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_margin_active',
			[
				'label'      => __( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . '.active' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_control_border_radius_active',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['control'] . '.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tabs_control_box_shadow_active',
				'selector' => '{{WRAPPER}} ' . $css_scheme['control'] . '.active',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'tabs_control_border_active',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['control'] . '.active',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Tabs Content Style Section
		 */
		$this->start_controls_section(
			'section_tabs_content_style',
			[
				'label'      => esc_html__( 'Tabs Content', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'control_wrapper_width',
			[
				'label'     => esc_html__( 'Control Width', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'min' => 0,
					'max' => 100,
				],
				'condition' => [
					'tabs_position' => [ 'left', 'right' ],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['content_wrapper'] => 'width: {{SIZE}}%',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'tabs_content_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content_wrapper'],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'tabs_content_editor_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['content'],
			]
		);
		$this->add_control(
			'tabs_content_editor_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#708791',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['content'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_content_padding',
			[
				'label'      => __( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [ 'top' => 20, 'right' => 20, 'bottom' => 20, 'left' => 20, 'isLinked' => true ],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['content'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'tabs_content_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => false,
						],
					],
					'color'  => [
						'default' => '#e7e7e7',
					],
				],
				'selector'       => '{{WRAPPER}} ' . $css_scheme['content_wrapper'],
			]
		);

		$this->add_responsive_control(
			'tabs_content_radius',
			[
				'label'      => __( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['content_wrapper'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'tabs_content_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['content_wrapper'],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render
	 */
	protected function render() {

		$tabs               = $this->get_settings_for_display( 'tab_items' );
		$tabs_position      = $this->get_settings( 'tabs_position' );
		$tab_align          = ( $tabs_position === 'top' ) ? 'wdes-align-tabs-' . $this->get_settings( 'tabs_controls_aligment' ) : '';
		$tab_postion_bottom = ( $tabs_position === 'bottom' ) ? 'wdes-flex-tabs-bottom' : '';

		if ( ! $tabs || empty( $tabs ) ) {
			return false;
		}

		$id_prefix = apply_filters( 'phox-host/tabs/id_prefix', 'wdes-' );

		$this->add_render_attribute( 'tab_element_parent', [
			'class' => [
				'wdes-tabs',
				$tab_postion_bottom,
			]
		] );

		$this->add_render_attribute( 'tab_element', [
			'class' => [
				'nav',
				'nav-tabs',
				'wdes-general-tabs-position-' . $tabs_position,
				$tab_align,
			],
			'id'    => [
				'featuresTab',
			],
			'role'  => [
				'tablist',
			],
		] );

		$this->add_render_attribute( 'content_element', [
			'id'    => [
				'featuresTabContent',
			],
			'class' => [
				'tab-content',
				'custom',
			],
		] );

		?>
        <div <?php echo $this->get_render_attribute_string( 'tab_element_parent' ); ?>>
            <ul <?php echo $this->get_render_attribute_string( 'tab_element' ); ?>>
				<?php
				foreach ( $tabs as $index => $item ) {
					$tab_li_attribute    = $this->get_repeater_setting_key( 'wdes_tab_li', 'tabs', $index );
					$tab_title_attribute = $this->get_repeater_setting_key( 'wdes_tab_control', 'tabs', $item['_id'] );
					$id_tab              = $id_prefix . $item['_id'];

					$icon_align         = '';
					$icon_position      = $this->get_settings( 'tabs_control_icon_position' );
					$tabs_position      = $this->get_settings( 'tabs_position' );
					$aligment_top_icon  = $this->get_settings( 'tabs_controls_item_aligment_top_icon' );
					$aligment_left_icon = $this->get_settings( 'tabs_controls_item_aligment_left_icon' );

					if ( 'left' === $tabs_position || 'right' === $tabs_position ) {
						$icon_align = 'wdes-aligment-item-';
						$icon_align .= ( 'left' === $icon_position ) ? $aligment_left_icon : $aligment_top_icon;
					}

					$this->add_render_attribute( $tab_li_attribute, [
						'class' => [
							'nav-item',
							$icon_align,
						],
					] );

					$active_class = 0 === $index ? 'active' : '';

					$this->add_render_attribute( $tab_title_attribute, [
						'class'         => [
							'nav-link',
							$active_class,
						],
						'href'          => '#' . $id_tab,
						'aria-controls' => $id_tab,
						'role'          => 'tab',
						'data-toggle'   => 'tab',
					] );

					$tab_title_icon_html = '';

					if ( ! empty( $item['tab_icon'] ) ) {
						$tab_title_icon_html = sprintf( '<div class="wdes-tabs-control-icon wdes-tabs-control-icon-%2$s"><i class="%1$s"></i></div>', $item['tab_icon']['value'], $this->get_settings( 'tabs_control_icon_position' ) );
					}

					$tab_title_image_html = '';

					if ( ! empty( $item['tab_image']['url'] ) ) {
						$tab_title_image_html = sprintf( '<img class="wdes-tabs-control-image wdes-tabs-control-image-%3$s" src="%1$s" alt="%2$s">', $item['tab_image']['url'], $item['tab_label'], $this->get_settings( 'tabs_control_image_position' ) );

					}

					$tab_title_label_html = '';

					if ( ! empty( $item['tab_label'] ) ) {
						$tab_title_label_html = sprintf( '<div class="wdes-tabs-control-text">%1$s</div>', $item['tab_label'] );
					}

					$tab_description_label_html = '';

					if ( ! empty( $item['tab_description'] ) ) {
						$tab_description_label_html = sprintf( '<p class="wdes-tabs-control-description">%1$s</p>', $item['tab_description'] );
					}

					echo sprintf( '<li %1$s><a  %2$s>%3$s %4$s %5$s</a></li>',
						$this->get_render_attribute_string( $tab_li_attribute ),
						$this->get_render_attribute_string( $tab_title_attribute ),
						( 'image' === $item['text_decoration'] ) ? $tab_title_image_html : $tab_title_icon_html,
						$tab_title_label_html,
						$tab_description_label_html
					);

				}
				?>
            </ul>

            <div class="tabs-area-features">
                <div class="wdes-wrap-tabs-content">
                    <div <?php echo $this->get_render_attribute_string( 'content_element' ); ?>>
						<?php
						foreach ( $tabs as $index => $item ) {
							$tab_content_attribute = $this->get_repeater_setting_key( 'wdes_tab_content', 'tabs', $item['_id'] );
							$id_content            = $id_prefix . $item['_id'];
							$animate_effect        = $item['tab_animation_effect'];
							$animate_delay         = ( 'none' !== $item['tab_animation_delay'] ) ? $item['tab_animation_delay'] : '';
							$animate_speed         = ( 'none' !== $item['tab_animation_speed'] ) ? $item['tab_animation_speed'] : '';

							$this->add_render_attribute( $tab_content_attribute, [
								'class' => [
									'tab-pane',
									$animate_effect,
									$animate_delay,
									$animate_speed,
									'animated',
									0 === $index ? 'show active' : '',
								],
								'id'    => $id_content,
								'role'  => 'tabpanel',
							] );

							$content_html = '';

							if ( 'template' === $item['content_type'] ) {

								$template_id = $item['tab_template_content'];

								if ( get_post_type( $template_id ) === 'elementor_library' ) {

									$shoercode = '[wdes-elementor-template id="' . $template_id . '"]';

									$template_shortcode = $this->elementor()->frontend->get_builder_content_for_display( $template_id, true );

									$content_html .= $template_shortcode;

								} else {

									$content_html .= ' Please Select The Template ';

								}
							} else {

								$content_html .= $this->parse_text_editor( $item['tab_editor_content'] );

							}

							echo sprintf( '<div %1$s> %2$s</div>',
								$this->get_render_attribute_string( $tab_content_attribute ),
								$content_html
							);

						}
						?>
                    </div>
                </div>
            </div>
        </div>
		<?php

	}

}
