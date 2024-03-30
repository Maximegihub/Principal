<?php
namespace Phox_Host\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;
use Phox_Host\Elementor\Base\Base_Widget;
use Phox\helpers as Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Section Header widget.
 *
 * Section Header widget that will display in Phox category
 *
 * @package Elementor\Widgets
 * @since 1.4.6
 */
class Section_Header extends Base_Widget {
	/**
	 * Get widget name.
	 *
	 * Retrieve section header widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name(){
		return 'wdes-section-header-widget';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve section header widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title(){
		return esc_html__('Heading', 'phox-host');
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve section header widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon(){
		return 'wdes-widget-elementor wdes-widget-heading';
	}


	/**
	 * Register section header widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected  function register_controls(){

		$this->start_controls_section(
			'heading_general',
			[
				'label' => esc_html__( 'General', 'phox-host' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);

		$this->add_control(
			'show_heading',
			[
				'label'         =>  __('Show Heading', 'phox-host'),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __('On', 'phox-host'),
				'label_off'     => __('Off', 'phox-host'),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->add_control(
			'show_secondary',
			[
				'label'         =>  __('Show SubHeading', 'phox-host'),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __('On', 'phox-host'),
				'label_off'     => __('Off', 'phox-host'),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		$this->add_control(
			'show_description',
			[
				'label'         =>  __('Show Description', 'phox-host'),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __('On', 'phox-host'),
				'label_off'     => __('Off', 'phox-host'),
				'return_value'  => 'yes',
				'default'       => 'yes',
			]
		);

		/*-- Divider --*/

		$this->add_control(
			'divider',
			[
				'label'         =>  __('Display Divider', 'phox-host'),
				'type'          => Controls_Manager::SWITCHER,
				'label_on'      => __('On', 'phox-host'),
				'label_off'     => __('Off', 'phox-host'),
				'return_value'  => 'yes',
				'default'       => 'yes',
				'separator'     => 'before'
			]
		);

		$this->add_control(
			'divider_position',
			[
				'label'     =>  __('Divider Position', 'phox-host'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'before'        =>  __('Before Heading', 'phox-host'),
					'between'       =>  __('Between Heading', 'phox-host'),
					'after'         =>  __('After Heading', 'phox-host'),
					'after_desc'    =>  __('After Description', 'phox-host')
				],
				'default'   =>  'after',
				'condition' => [
					'divider'   =>  'yes'
				]
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'the_header_plans_one_controls',
			[
				'label' => esc_html__('Heading', 'phox-host'),
				'condition' => [
					'show_heading' => 'yes'
				]
			]
		);

		$this->add_control(
			'the_title',
			[
				'label' => esc_html__('Title', 'phox-host'),
				'type'  => Controls_Manager::HIDDEN,
				'default'   => esc_html__('Title', 'phox-host')
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__('Title', 'phox-host'),
				'type'  => Controls_Manager::TEXTAREA,
				'default'   => esc_html__('Title', 'phox-host')
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__('Link', 'phox-host'),
				'type'  => Controls_Manager::URL,
				'placeholder'   => 'http://example.com',
				'show_external' => true,
				'label_block'   => true
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'     => esc_html__('HTML Tag', 'phox-host'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1'        =>'H1',
					'h2'        =>'H2',
					'h3'        =>'H3',
					'h4'        =>'H4',
					'h5'        =>'H5',
					'h6'        =>'H6',
				],
				'default'   => 'h1'
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label'     => __('Alignment', 'phox-host'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => '',
				'options'   => [
					'left'    => [
						'title' =>  __('Left', 'phox-host'),
						'icon'  =>  'eicon-arrow-left'
					],
					'center'    => [
						'title' =>  __('Center', 'phox-host'),
						'icon'  =>  'eicon-text-align-justify'
					],
					'right'    => [
						'title' =>  __('Right', 'phox-host'),
						'icon'  =>  'eicon-arrow-right'
					],
				],
				'selectors'     => [
					'{{WRAPPER}} .wdes-widget-inner'    =>  'text-align: {{VALUE}};'
				]

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'secondary_header_section',
			[
				'label'     =>  __('SubHeading', 'phox-host'),
				'condition' => [
					'show_secondary' => 'yes'
				]
			]
		);

		$this->add_control(
			'title_secondary_before',
			[
				'label'         => esc_html__('Before Text', 'phox-host'),
				'type'          => Controls_Manager::TEXT,
				'default'       => '',
				'label_block'   =>  true,
			]
		);

		$this->add_control(
			'title_secondary_highlight',
			[
				'label'         => esc_html__('Highlight Text', 'phox-host'),
				'type'          => Controls_Manager::TEXT,
				'default'       => '',
				'label_block'   =>  true,
			]
		);

		$this->add_control(
			'title_secondary_after',
			[
				'label'         => esc_html__('After Text', 'phox-host'),
				'type'          => Controls_Manager::TEXT,
				'default'       => '',
				'label_block'   =>  true,
			]
		);

		$this->add_control(
			'link_secondary',
			[
				'label' => esc_html__('Link', 'phox-host'),
				'type'  => Controls_Manager::URL,
				'placeholder'   => 'http://example.com',
				'show_external' => true,
				'label_block'   => true
			]
		);

		$this->add_control(
			'title_tag_secondary',
			[
				'label'     => esc_html__('HTML Tag', 'phox-host'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'h1'        =>'H1',
					'h2'        =>'H2',
					'h3'        =>'H3',
					'h4'        =>'H4',
					'h5'        =>'H5',
					'h6'        =>'H6',
				],
				'default'   => 'h2'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'description_main_section',
			[
				'label'     =>  esc_html('Description', 'phox-host'),
				'condition' => [
					'show_description' => 'yes'
				]
			]
		);

		$this->add_control(
			'the_description',
			[
				'label'         => esc_html__('Description', 'phox-host'),
				'type'          => Controls_Manager::HIDDEN,
				'label_block'   =>  true,
			]
		);

		$this->add_control(
			'description',
			[
				'label'         => esc_html__('Description', 'phox-host'),
				'type'          => Controls_Manager::WYSIWYG,
				'label_block'   =>  true,
				'default'       =>  'Description',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style_section',
			[
				'label' => esc_html__( 'Heading', 'phox-host' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_heading' => 'yes'
				]
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1b3a4e',
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .wdes-section-header-primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1b3a4e',
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .wdes-section-header-primary:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wdes-section-header-primary',
			]
		);

		$this->add_control(
			'title_text_image',
			[
				'label'         => esc_html('Active Text Image', 'phox-host'),
				'type'          => Controls_Manager::SWITCHER,
				'return_value'  =>'yes',
				'default'       =>'no',
				'separator'     =>'before'
			]
		);

		$this->add_control(
			'title_text_image_choose_styling',
			[
				'type'          => Controls_Manager::CHOOSE,
				'default'       => 'image',
				'toggle'        => false,
				'options'        =>[
					'image' =>  [
						'title' =>  esc_html__('Image', 'phox-host'),
						'icon'  =>  'eicon-image'
					],
					'gradient' =>  [
						'title' =>  esc_html__('Gradient', 'phox-host'),
						'icon'  =>  'eicon-barcode'
					],
				],
				'condition' =>  [
					'title_text_image'  =>  'yes'
				]
			]
		);

		$this->add_control(
			'title_text_image_bg_color',
			[
				'label'         => esc_html('Color', 'phox-host'),
				'type'          => Controls_Manager::COLOR,
				'default'       => '',
				'render_type'   => 'ui',
				'condition'     => [
					'title_text_image_choose_styling'   =>  'gradient',
					'title_text_image'  =>  'yes'
				],
				'of_type'   =>  'gradient'
			]
		);

		$this->add_control(
			'title_text_image_bg_color_stop',
			[
				'label'         => esc_html('Location', 'phox-host'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['%'],
				'default'       => [
					'unit'  =>  '%',
					'size'  =>  0
				],
				'render_type'   => 'ui',
				'condition'     => [
					'title_text_image_choose_styling'   =>  'gradient',
					'title_text_image'  =>  'yes'
				],
				'of_type'   =>  'gradient'
			]
		);

		$this->add_control(
			'title_text_image_bg_color_two',
			[
				'label'         => esc_html('Second Color', 'phox-host'),
				'type'          => Controls_Manager::COLOR,
				'default'       => '#e3e3e3',
				'render_type'   => 'ui',
				'condition'     => [
					'title_text_image_choose_styling'   =>  'gradient',
					'title_text_image'  =>  'yes'
				],
				'of_type'   =>  'gradient'
			]
		);

		$this->add_control(
			'title_text_image_bg_color_two_stop',
			[
				'label'         => esc_html('Location', 'phox-host'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['%'],
				'default'       => [
					'unit'  =>  '%',
					'size'  =>  0
				],
				'render_type'   => 'ui',
				'condition'     => [
					'title_text_image_choose_styling'   =>  'gradient',
					'title_text_image'  =>  'yes'
				],
				'of_type'   =>  'gradient'
			]
		);

		$this->add_control(
			'title_text_image_bg_gradient_type',
			[
				'label'     => esc_html('Type', 'phox-host'),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'linear'    => esc_html('Linear', 'phox-host'),
					'radial'    => esc_html('Radial', 'phox-host'),
				],
				'default'       => 'linear',
				'render_type'   => 'ui',
				'condition'     => [
					'title_text_image_choose_styling'   =>  'gradient',
					'title_text_image'  =>  'yes'
				],
				'of_type'   =>  'gradient'
			]
		);

		$this->add_control(
			'title_text_image_bg_gradient_angle',
			[
				'label'         => esc_html('Angle', 'phox-host'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['deg'],
				'default'       => [
					'unit'  =>  'deg',
					'size'  =>  180
				],
				'range' => [
					'step'  =>  'deg'
				],
				'selectors' =>  [
					'{{WRAPPER}} .wdes-section-header-primary' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{title_text_image_bg_color.VALUE}} {{title_text_image_bg_color_stop.SIZE}}{{title_text_image_bg_color_stop.UNIT}}, {{title_text_image_bg_color_two.VALUE}} {{title_text_image_bg_color_two_stop.SIZE}}{{title_text_image_bg_color_two_stop.UNIT}})',
				],
				'condition'     => [
					'title_text_image_choose_styling'   =>  'gradient',
					'title_text_image_bg_gradient_type' => 'linear',
					'title_text_image'  =>  'yes'
				],
				'of_type'   =>  'gradient'
			]
		);

		$this->add_control(
			'title_text_image_bg_gradient_position',
			[
				'label'         => esc_html('Position', 'phox-host'),
				'type'          => Controls_Manager::SELECT,
				'options'   => [
					'center center'    => esc_html('Center Center', 'phox-host'),
					'center left'      => esc_html('Center Left', 'phox-host'),
					'center right'     => esc_html('Center Right', 'phox-host'),
					'top center'       => esc_html('Top Center', 'phox-host'),
					'top left'         => esc_html('Top Left', 'phox-host'),
					'top right'        => esc_html('Top Right', 'phox-host'),
					'bottom center'    => esc_html('Bottom Center', 'phox-host'),
					'bottom left'      => esc_html('Bottom Left', 'phox-host'),
					'bottom right'     => esc_html('Bottom Right', 'phox-host')
				],
				'default'       => 'center center',
				'selectors'     =>  [
					'{{WRAPPER}} .wdes-section-header-primary' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{title_text_image_bg_color.VALUE}} {{title_text_image_bg_color_stop.SIZE}}{{title_text_image_bg_color_stop.UNIT}}, {{title_text_image_bg_color_two.VALUE}} {{title_text_image_bg_color_two_stop.SIZE}}{{title_text_image_bg_color_two_stop.UNIT}})',
				],
				'condition'     => [
					'title_text_image_choose_styling'   =>  'gradient',
					'title_text_image_bg_gradient_type' => 'radial',
					'title_text_image'  =>  'yes'
				],
				'of_type'   =>  'gradient'
			]
		);

		$this->add_control(
			'title_text_image_bg',
			[
				'label'     => esc_html('Text Image', 'phox-host'),
				'type'      => Controls_Manager::MEDIA,
				'condition'     => [
					'title_text_image_choose_styling'   =>  'image',
					'title_text_image'  =>  'yes'
				],
				'selectors'     =>  [
					'{{WRAPPER}} .wdes-section-header-primary-label' => 'background-image:url({{URL}})',
				]
			]
		);

		$this->add_control(
			'title_text_image_bg_position',
			[
				'label'         => esc_html('Background Position', 'phox-host'),
				'type'          => Controls_Manager::SELECT,
				'options'   => [
					'center center'    => esc_html('Center Center', 'phox-host'),
					'center left'      => esc_html('Center Left', 'phox-host'),
					'center right'     => esc_html('Center Right', 'phox-host'),
					'top center'       => esc_html('Top Center', 'phox-host'),
					'top left'         => esc_html('Top Left', 'phox-host'),
					'top right'        => esc_html('Top Right', 'phox-host'),
					'bottom center'    => esc_html('Bottom Center', 'phox-host'),
					'bottom left'      => esc_html('Bottom Left', 'phox-host'),
					'bottom right'     => esc_html('Bottom Right', 'phox-host')
				],
				'default'       => 'center center',
				'selectors'     =>  [
					'{{WRAPPER}} .wdes-section-header-primary-label' => 'background-position: {{VALUE}}',
				],
				'condition'     => [
					'title_text_image_choose_styling'   =>  'image',
					'title_text_image'  =>  'yes'
				]
			]
		);

		$this->add_control(
			'title_text_image_bg_repeat',
			[
				'label'         => esc_html('Background Repeat', 'phox-host'),
				'type'          => Controls_Manager::SELECT,
				'options'   => [
					''                  => esc_html('Default', 'phox-host'),
					'no-repeat'         => esc_html('No Repeat', 'phox-host'),
					'repeat'            => esc_html('Repeat', 'phox-host'),
					'repeat-x'          => esc_html('Repeat-X', 'phox-host'),
					'repeat-y'          => esc_html('Repeat-Y', 'phox-host'),
				],
				'default'       => '',
				'selectors'     =>  [
					'{{WRAPPER}} .wdes-section-header-primary-label' => 'background-repeat: {{VALUE}}',
				],
				'condition'     => [
					'title_text_image_choose_styling'   =>  'image',
					'title_text_image'  =>  'yes'
				]
			]
		);

		$this->add_control(
			'title_text_image_bg_size',
			[
				'label'         => esc_html('Background Size', 'phox-host'),
				'type'          => Controls_Manager::SELECT,
				'options'   => [
					''            => esc_html('Default', 'phox-host'),
					'auto'        => esc_html('Auto', 'phox-host'),
					'cover'       => esc_html('Cover', 'phox-host'),
					'contain'     => esc_html('Contain', 'phox-host'),
				],
				'default'       => '',
				'selectors'     =>  [
					'{{WRAPPER}} .wdes-section-header-primary-label' => 'background-size: {{VALUE}}',
				],
				'condition'     => [
					'title_text_image_choose_styling'   =>  'image',
					'title_text_image'  =>  'yes'
				]
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label'                 => esc_html__( 'Margin', 'phox-host' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', 'em'],
				'allowed_dimensions'    => 'all',
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-primary' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_text_shadow',
				'label'  => esc_html__( 'Text Shadow', 'phox-host' ),
				'selector' => '{{WRAPPER}} .wdes-section-header-primary',
			]
		);

		$this->add_responsive_control(
			'title_width',
			[
				'label'       => esc_html__('Max Width', 'phox-host'),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px', 'em', '%'],
				'range'       => [
					'%' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1
					],
					'em' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1
					],
					'px' => [
						'min'  => 1,
						'max'  => 1600,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-primary' => 'max-width:{{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->add_responsive_control(
			'title_alignment',
			[
				'label'     => __('Alignment', 'phox-host'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => '',
				'options'   => [
					'left'    => [
						'title' =>  __('Left', 'phox-host'),
						'icon'  =>  'eicon-arrow-left'
					],
					'center'    => [
						'title' =>  __('Center', 'phox-host'),
						'icon'  =>  'eicon-text-align-justify'
					],
					'right'    => [
						'title' =>  __('Right', 'phox-host'),
						'icon'  =>  'eicon-arrow-right'
					],
				],
				'selectors'     => [
					'{{WRAPPER}} .wdes-section-header-primary'    =>  'text-align: {{VALUE}};'
				]

			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_two_style_section',
			[
				'label' => esc_html__( 'SubHeading', 'phox-host' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_secondary' => 'yes'
				]
			]
		);

		$this->add_control(
			'title_two_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1b3a4e',
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .wdes-section-header-secondary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_two_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1b3a4e',
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .wdes-section-header-secondary:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_two_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wdes-section-header-secondary',
			]
		);

		$this->add_responsive_control(
			'title_two_margin',
			[
				'label'                 => esc_html__( 'Margin', 'phox-host' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', 'em'],
				'allowed_dimensions'    => 'all',
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-secondary' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_two_text_shadow',
				'label'  => esc_html__( 'Text Shadow', 'phox-host' ),
				'selector' => '{{WRAPPER}} .wdes-section-header-secondary',
			]
		);

		$this->add_responsive_control(
			'title_two_width',
			[
				'label'       => esc_html__('Max Width', 'phox-host'),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px', 'em', '%'],
				'range'       => [
					'%' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1
					],
					'em' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1
					],
					'px' => [
						'min'  => 1,
						'max'  => 1600,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-secondary' => 'max-width:{{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->add_control(
			'title_two_highlighted_style_heading',
			[
				'label'     => esc_html__( 'Highlighted Text', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'title_two_highlighted_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-secondary .wdes-head-highlight' => 'color: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'title_two_highlighted_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-secondary .wdes-head-highlight:hover' => 'color: {{VALUE}}'
				],
				'condition' =>  [
					'link_secondary'    =>  ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_two_highlighted_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wdes-section-header-secondary .wdes-head-highlight',
			]
		);

		$this->add_responsive_control(
			'title_two_highlighted_margin',
			[
				'label'                 => esc_html__( 'Margin', 'phox-host' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', 'em'],
				'allowed_dimensions'    => 'all',
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-secondary .wdes-head-highlight' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_two_highlighted_text_shadow',
				'label'  => esc_html__( 'Text Shadow', 'phox-host' ),
				'selector' => '{{WRAPPER}} .wdes-section-header-secondary .wdes-head-highlight',
			]
		);

		$this->add_responsive_control(
			'title_two_alignment',
			[
				'label'     => __('Alignment', 'phox-host'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => '',
				'options'   => [
					'left'    => [
						'title' =>  __('Left', 'phox-host'),
						'icon'  =>  'eicon-arrow-left'
					],
					'center'    => [
						'title' =>  __('Center', 'phox-host'),
						'icon'  =>  'eicon-text-align-justify'
					],
					'right'    => [
						'title' =>  __('Right', 'phox-host'),
						'icon'  =>  'eicon-arrow-right'
					],
				],
				'selectors'     => [
					'{{WRAPPER}} .wdes-section-header-secondary'    =>  'text-align: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'divider_style_section',
			[
				'label'     => esc_html__( 'Divider', 'phox-host' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' =>  [
					'divider'   =>  'yes'
				]
			]
		);

		$this->add_responsive_control(
			'divider_weight',
			[
				'label' => esc_html__( 'Weight', 'phox-host' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'max'   => 10
					]
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .wdes-section-header-divider' => 'height: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'divider_width',
			[
				'label' => esc_html__( 'Width', 'phox-host' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min'   => 1,
						'max'   => 1200
					],
					'%' => [
						'min'   => 1,
						'max'   => 100
					]
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-divider' => 'width: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'divider_margin',
			[
				'label'                 => esc_html__( 'Margin', 'phox-host' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', 'em'],
				'allowed_dimensions'    => 'all',
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-divider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-divider ' => 'background-color: {{VALUE}}'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'divider_shadow',
				'selector' => '{{WRAPPER}} .wdes-section-header-divider',
				'separator' =>  'before'
			]
		);

		$this->add_responsive_control(
			'divider_alignment',
			[
				'label'     => __('Alignment', 'phox-host'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => '',
				'options'   => [
					'left'    => [
						'title' =>  __('Left', 'phox-host'),
						'icon'  =>  'eicon-arrow-left'
					],
					'center'    => [
						'title' =>  __('Center', 'phox-host'),
						'icon'  =>  'eicon-text-align-justify'
					],
					'right'    => [
						'title' =>  __('Right', 'phox-host'),
						'icon'  =>  'eicon-arrow-right'
					],
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'description_style_section',
			[
				'label' => esc_html__( 'Description', 'phox-host' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_description' => 'yes'
				]
			]
		);
		$this->add_control(
			'Description_color',
			[
				'label' => esc_html__( 'Description Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#708791',
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wdes-section-header-description',
			]
		);

		$this->add_responsive_control(
			'description_margin',
			[
				'label'                 => esc_html__( 'Margin', 'phox-host' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', 'em'],
				'allowed_dimensions'    => 'all',
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'description_width',
			[
				'label' => esc_html__( 'Max Width', 'phox-host' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em' ,'%'],
				'range' => [
					'%' => [
						'min'   => 1,
						'max'   => 100
					],
					'em' => [
						'min'   => 1,
						'max'   => 100
					],
					'px' => [
						'min'   => 1,
						'max'   => 1600
					]
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-section-header-description' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'condition' =>  [
					'divider'   =>  'yes'
				]
			]
		);

		$this->add_responsive_control(
			'description_alignment',
			[
				'label'     => __('Alignment', 'phox-host'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => '',
				'options'   => [
					'left'    => [
						'title' =>  __('Left', 'phox-host'),
						'icon'  =>  'eicon-arrow-left'
					],
					'center'    => [
						'title' =>  __('Center', 'phox-host'),
						'icon'  =>  'eicon-text-align-justify'
					],
					'right'    => [
						'title' =>  __('Right', 'phox-host'),
						'icon'  =>  'eicon-arrow-right'
					],
				],
				'selectors'     => [
					'{{WRAPPER}} .wdes-section-header-description'    =>  'text-align: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'wrapper_style_section',
			[
				'label' => esc_html__( 'Wrapper', 'phox-host' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label'       => esc_html__('Width', 'phox-host'),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px', 'em', '%'],
				'range'       => [
					'%' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1
					],
					'em' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1
					],
					'px' => [
						'min'  => 1,
						'max'  => 1600,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-widget-section-header .wdes-widget-inner' => 'width:{{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'       => esc_html__('Height', 'phox-host'),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => ['px', 'em', '%'],
				'range'       => [
					'%' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1
					],
					'em' => [
						'min'  => 1,
						'max'  => 100,
						'step' => 1
					],
					'px' => [
						'min'  => 1,
						'max'  => 1600,
						'step' => 1
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-widget-section-header .wdes-widget-inner' => 'height:{{SIZE}}{{UNIT}}'
				]
			]
		);

		$this->add_responsive_control(
			'wrapper_margin',
			[
				'label'                 => esc_html__( 'Margin', 'phox-host' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', 'em'],
				'allowed_dimensions'    => 'all',
				'selectors' => [
					'{{WRAPPER}} .wdes-widget-section-header .wdes-widget-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'wrapper_padding',
			[
				'label'                 => esc_html__( 'Padding', 'phox-host' ),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', 'em'],
				'allowed_dimensions'    => 'all',
				'selectors' => [
					'{{WRAPPER}} .wdes-widget-section-header .wdes-widget-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
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
	protected function render (){
		$settings = $this->get_settings();

		$alignment_class = ! empty ( $settings['alignment'] ) ? 'wdes-text-align-' . $settings['alignment'] : '' ;
		$alignment_class_divider = ! empty ( $settings['divider_alignment'] ) ? 'align-' . $settings['divider_alignment'] : '' ;
		$divider_html = Helper::check_var_true( $settings['divider']) ? '<div class="wdes-section-header-divider '.$alignment_class_divider.'" ></div>' : '';
		$primary_class = Helper::check_var_true( $settings['title_text_image']) ? 'wdes-section-header-primary wdes-section-header-primary-label' : 'wdes-section-header-primary' ;

		//check sections if active
		$heading_active   = Helper::check_var_true( $settings['show_heading'] );
		$secondary_active = Helper::check_var_true( $settings['show_secondary'] );
		$description_active = Helper::check_var_true( $settings['show_description'] );

		//check the deprecated title field that will remove soon.
		if( empty( $settings['the_title'] ) ){
			$title = $settings['title'];
		}else{
			$title = ($settings['title'] === 'Title') ? $settings['the_title'] : $settings['title'];
		}
		if( empty( $settings['the_description'] ) ){
			$description = $settings['description'];
		}else{
			$description = ( $settings['description'] === 'Description' ) ? $settings['the_description'] : $settings['description'];
		}

		print ('<section class="widget-content wdes-widget-section-header">');
		printf ('<div class="wdes-widget-inner %s ">', esc_attr($alignment_class) );
		//divider before
		if( empty( $settings['divider_position'] ) || 'before' === $settings['divider_position'] ){
			echo $divider_html  ;
		}

		//Primary Heading
		if( $heading_active ) {

			if(! empty( $settings['link']['url'] )){

				$this->add_render_attribute('link-primary', 'href', $settings['link']['url']);
				$this->add_render_attribute('link-primary', 'class', 'wdes-section-header-primary-link');
				if( $settings['link']['is_external'] ) {
					$this->add_render_attribute('link-primary', 'target', '_blank');
				}
				if( $settings['link']['nofollow'] ) {
					$this->add_render_attribute('link-primary', 'rel', 'nofollow');
				}

				echo sprintf('<a %1$s><%2$s class="%4$s">%3$s</%2$s></a>',
					$this->get_render_attribute_string('link-primary'),
					esc_attr($settings['title_tag']),
					$title,
					$primary_class
				);


			}else{

				echo sprintf('<%1$s class="%3$s">%2$s</%1$s>',
					esc_attr($settings['title_tag']),
					$title,
					$primary_class
				);
			}
		}

		//divider between
		if( 'between' === $settings['divider_position'] ){
			echo  $divider_html ;
		}

		//secondary header
		if( $secondary_active ) {

			$before_heading         = $settings['title_secondary_before']       ? ''.'<span class="wdes-head-before">' . $settings['title_secondary_before'] .'</span> ' : '' ;
			$highlight_heading      = $settings['title_secondary_highlight']    ? ''.'<span class="wdes-head-highlight">' . $settings['title_secondary_highlight'] .'</span> ' : '' ;
			$after_heading          = $settings['title_secondary_after']        ? ''.'<span class="wdes-head-after">' . $settings['title_secondary_after'] .'</span>' : '' ;

			if($before_heading || $highlight_heading || $after_heading ){

				if( ! empty( $settings['link_secondary']['url'] ) ){

					$this->add_render_attribute( 'link-secondary', 'href', $settings['link_secondary']['url'] );
					$this->add_render_attribute( 'link-secondary', 'class', 'wdes-section-header-secondary-link' );

					if( $settings['link_secondary']['is_external'] ) {
						$this->add_render_attribute( 'link-secondary', 'target', '_blank' );
					}
					if($settings['link_secondary']['nofollow']){
						$this->add_render_attribute( 'link-secondary', 'rel', 'nofollow' );
					}

					echo sprintf('<a %1$s><%2$s class="wdes-section-header-secondary">%3$s%4$s%5$s</%2$s></a>',
						$this->get_render_attribute_string('link-secondary'),
						esc_attr($settings['title_tag_secondary']),
						$before_heading,
						$highlight_heading,
						$after_heading

					);


				}else{
					echo sprintf('<%1$s class="wdes-section-header-secondary">%2$s%3$s%4$s</%1$s>',
						esc_attr($settings['title_tag_secondary']),
						$before_heading,
						$highlight_heading,
						$after_heading
					);
				}

			}
		}

		//divider after
		if( 'after' === $settings['divider_position'] ){
			echo $divider_html ;
		}

		//description
		if( ! empty( $description ) && $description_active ){
			echo sprintf('<div class="wdes-section-header-description">%s</div>', $description ) ;
		}

		//divider after description
		if( empty( $settings['divider_position'] ) || 'after_desc' === $settings['divider_position'] ){
			echo $divider_html ;
		}

		if( ! $description_active && ! $secondary_active && ! $heading_active && empty( $divider_html ) ){
			echo sprintf('<h1>%s</h1>','Add Some Content' ) ;
		}
		print ('</div>');
		print ('</section>');

	}


}
