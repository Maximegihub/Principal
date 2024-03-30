<?php
namespace Phox_Host\Elementor\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Background;
use \Elementor\Core\Schemes\Color;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Control_Media;
use \Phox\helpers;
use  Phox_Host\Elementor\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; //Exit if accessed directly
}

/**
 * Testimonials widget.
 *
 * Testimonials widget that will display in Phox category
 *
 * @package Elementor\Widgets
 * @since 1.4.3
 */
class Testimonials extends Base_Widget {

	/**
	 * Get Widget name
	 *
	 * Retrieve Testimonials widget name
	 *
	 * @since  1.4.3
	 * @access public
	 *
	 * @return string Widget name
	 */
	public function get_name() {
		return 'wdes_testimonials';
	}

	/**
	 * Get Widget title
	 *
	 * Retrieve Testimonials widget title
	 *
	 * @since  1.4.3
	 * @access public
	 *
	 * @return string Widget title
	 */
	public function get_title() {
		return __( 'Testimonial', 'phox-host' );
	}

	/**
	 * Get Widget icon
	 *
	 * Retrieve Testimonials widget icon
	 *
	 * @since  1.4.3
	 * @access public
	 *
	 * @return string Widget icon
	 */
	public function get_icon() {
		return 'wdes-widget-elementor wdes-widget-testimonials';
	}

	/**
	 * Get Widget keywords
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since  1.4.3
	 * @access public
	 *
	 * @return array widget keywords.
	 */
	public function get_keywords() {
		return [ 'blockquote', 'testimonial', 'review' ];
	}

	/**
	 * Get script dependencies.
	 *
	 * Retrieve the list of script dependencies the element requires.
	 *
	 * @since 1.4.3
	 * @access public
	 *
	 * @return array Element scripts dependencies.
	 */

	public function get_script_depends() {
		return [ 'wdes-host-owl' ];
	}

	/**
	 * Get style dependencies.
	 *
	 * Retrieve the list of style dependencies the element requires.
	 *
	 * @since 1.4.3
	 * @access public
	 *
	 * @return array Element styles dependencies.
	 */
	public function get_style_depends() {
		return [ 'wdes-host-owl', 'wdes-host-owl-theme' ];
	}


	/**
	 * Register Testimonial widget controls
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.4.3
	 * @access protected
	 */
	protected function register_controls() {

		$css_scheme = [
			'instance'     => '.wdes-testimonials-instance',
			'item_inner'   => '.wdes-testimonials-item-inner',
			'image'        => '.wdes-testimonials-image',
			'image_tag'    => '.wdes-testimonials-image-tag',
			'icon'         => '.wdes-testimonials-icon',
			'icon_inner'   => '.wdes-testimonials-icon-inner',
			'title'        => '.wdes-testimonials-title',
			'comment'      => '.wdes-testimonials-comment',
			'position'     => '.wdes-testimonials-position',
			'rating'       => '.wdes-testimonials-rating',
			'content'      => '.wdes-testimonials-content',
			'name'         => '.wdes-testimonials-name',
			'date'         => '.wdes-testimonials-date',
			'arrow'        => '.owl-nav',
			'dots'         => '.owl-dots',
			'dot'          => '.owl-dot span',
			'dot_active'   => '.owl-dot.active span',
		];

		$this->start_controls_section(
			'layout_section_settings',
			[
				'label' => esc_html__( 'Settings', 'phox-host' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);
		$this->add_responsive_control(
			'items_on_screen',
			[
				'label'     => esc_html__( 'Items on Screen', 'phox-host' ),
				'type'      => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'default' => 1,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);

		$this->add_control(
			'autoplay_hover',
			[
				'label'        => esc_html__( 'Autoplay Hover Pause', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'true',
				'default'      => '',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'        => esc_html__( 'Autoplay Speed', 'phox-host' ),
				'type'         => Controls_Manager::NUMBER,
				'default'      => 500,
				'description'  => esc_html__( 'Set 0 to reset autoplay speed', 'phox-host' ),
			]
		);

		$this->add_control(
			'infinity',
			[
				'label'        => esc_html__( 'Infinity loop', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'true',
				'default'      => '',
			]
		);

		$this->add_control(
			'nav',
			[
				'label'        => esc_html__( 'Show next/prev buttons', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'true',
				'default'      => 'false',
			]
		);

		$this->add_control(
			'dots',
			[
				'label'        => esc_html__( 'Show dots navigation.', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);

		$this->add_control(
			'auto_height',
			[
				'label'        => esc_html__( 'Auto Height', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);

		$this->end_controls_section();

		//content
		$this->start_controls_section(
			'content_section_items_data',
			[
				'label' => esc_html__( 'Items', 'phox-host' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_image',
			[
				'label'   => esc_html__( 'Image', 'phox-host' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'item_icon',
			[
				'label'       => esc_html__( 'Icon', 'phox-host' ),
				'type'        => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'label_block' => true,
				'file'        => '',
				'default'     => [
					'value' => 'fas fa-quote-left',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'item_title',
			[
				'label'   => esc_html__( 'Title', 'phox-host' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'item_comment',
			[
				'label'   => esc_html__( 'Comment', 'phox-host' ),
				'type'    => Controls_Manager::TEXTAREA,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'item_name',
			[
				'label'   => esc_html__( 'Name', 'phox-host' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'item_link',
			[
				'label'   => esc_html__( 'Link', 'phox-host' ),
				'type'    => Controls_Manager::URL,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'item_position',
			[
				'label'   => esc_html__( 'Position', 'phox-host' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'item_date',
			[
				'label'   => esc_html__( 'Date', 'phox-host' ),
				'type'    => Controls_Manager::DATE_TIME,
				'placeholder' => 'Select Date ...',
				'picker_options' => [ 'dateFormat' => 'l ,F j, Y' ],
				'description' => esc_html__( 'Note : For remove date you can select all the text and delete it', 'phox-host' )
			]
		);

		$repeater->add_control(
			'item_rating',
			[
				'label'   => esc_html__( 'Rating', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 0,
				'options' => [
					'0' => esc_html__( 'Hidden', 'phox-host' ),
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
				],
			]
		);

		$this->add_control(
			'item_list',
			[
				'label' => '',
				'type'     => Controls_Manager::REPEATER,
				'fields'   => $repeater->get_controls(),
				'default' => [
					[
						'item_comment'  => esc_html__( 'Lorem Ipsum has been the industry is standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'phox-host' ),
						'item_name'     => esc_html__( 'Cheryl Doyle', 'phox-host' ),
						'item_position' => esc_html__( 'Client', 'phox-host' ),
					],
					[
						'item_comment'  => esc_html__( 'Lorem Ipsum has been the industry is standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'phox-host' ),
						'item_name'     => esc_html__( 'Honey Carney', 'phox-host' ),
						'item_position' => esc_html__( 'Client', 'phox-host' ),
					],
					[
						'item_comment'  => esc_html__( 'Lorem Ipsum has been the industry is standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'phox-host' ),
						'item_name'     => esc_html__( 'Tanvir Zimmerman', 'phox-host' ),
						'item_position' => esc_html__( 'Client', 'phox-host' ),
					],
					[
						'item_comment'  => esc_html__( 'Lorem Ipsum has been the industry is standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'phox-host' ),
						'item_name'     => esc_html__( 'Emil Hirst', 'phox-host' ),
						'item_position' => esc_html__( 'Client', 'phox-host' ),
					],
				],
				'title_field' => '{{{ item_title }}}',
			]
		);

		$this->end_controls_section();

		/*
		 * Style
		 */
		// General Section
		$this->start_controls_section(
			'section_general_style',
			[
				'label'      => esc_html__( 'General Setting', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'item_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item_inner'],
			]
		);

		$this->add_responsive_control(
			'item_margin',
			[
				'label'    => esc_html__( 'Item Margin', 'phox-host' ),
				'type'     => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'render_type' => 'template',
				'selectors'   => [
					' {{WRAPPER}} ' . $css_scheme['item_inner'] => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'item_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => ' {{WRAPPER}} ' . $css_scheme['item_inner'],
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['item_inner'] => 'border-radius:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['item_inner'],
			]
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
			'image_order',
			[
				'label'     => esc_html__( 'Image Order', 'phox-host' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 1,
				'min'       => 1,
				'max'       => 8,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['image'] => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_order',
			[
				'label'   => esc_html__( 'Icon Order', 'phox-host' ),
				'type'    => Controls_Manager::NUMBER,
				'default'   => 2,
				'min'       => 1,
				'max'       => 8,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_order',
			[
				'label'   => esc_html__( 'Title Order', 'phox-host' ),
				'type'    => Controls_Manager::NUMBER,
				'default'   => 3,
				'min'       => 1,
				'max'       => 8,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['title'] => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'comment_order',
			[
				'label'   => esc_html__( 'Description Order', 'phox-host' ),
				'type'    => Controls_Manager::NUMBER,
				'default'   => 4,
				'min'       => 1,
				'max'       => 8,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'name_order',
			[
				'label'   => esc_html__( 'Name Order', 'phox-host' ),
				'type'    => Controls_Manager::NUMBER,
				'default'   => 5,
				'min'       => 1,
				'max'       => 8,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['name'] => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'position_order',
			[
				'label'   => esc_html__( 'Position Order', 'phox-host' ),
				'type'    => Controls_Manager::NUMBER,
				'default'   => 6,
				'min'       => 1,
				'max'       => 8,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['position'] => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'date_order',
			[
				'label'   => esc_html__( 'Date Order', 'phox-host' ),
				'type'    => Controls_Manager::NUMBER,
				'default'   => 7,
				'min'       => 1,
				'max'       => 8,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['date'] => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rating_order',
			[
				'label'   => esc_html__( 'Rating Order', 'phox-host' ),
				'type'    => Controls_Manager::NUMBER,
				'default'   => 8,
				'min'       => 1,
				'max'       => 8,
				'step'      => 1,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'order: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();

		// Image Section
		$this->start_controls_section(
			'section_image_style',
			[
				'label'      => esc_html__( 'Image', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'image_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'start', 'phox-host' ),
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
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['image'] => 'align-self: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => esc_html__( 'Width', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'%',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 150,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['image_tag'] => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label' => esc_html__( 'Height', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'%',
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 800,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 150,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['image_tag'] => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['image'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'image_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['image'],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['image'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['image'],
			]
		);

		$this->end_controls_section();

		// Icon Section
		$this->start_controls_section(
			'section_icon_style',
			[
				'label'      => esc_html__( 'Icon', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'icon_box_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'start', 'phox-host' ),
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
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'align-self: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'      => esc_html__( 'Icon Color', 'phox-host' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_bg_color',
			[
				'label'      => esc_html__( 'Icon Background Color', 'phox-host' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner']   => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_font_size',
			[
				'label' => esc_html__( 'Icon Font Size', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'em',
				],
				'range' => [
					'px' => [
						'min' => 18,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['icon']  => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_width',
			[
				'label' => esc_html__( 'Width', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'em',
					'%',
				],
				'range' => [
					'px' => [
						'min' => 18,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner'] => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_height',
			[
				'label' => esc_html__( 'Height', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'em',
					'%',
				],
				'range' => [
					'px' => [
						'min' => 18,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner'] => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_box_margin',
			[
				'label' => esc_html__( 'Margin', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [
					'px',
					'%',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'icon_border',
				'label' => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner'],
			]
		);

		$this->add_control(
			'icon_box_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'  => 'icon_box_shadow',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['icon'] . ' ' . $css_scheme['icon_inner'],
			]
		);

		$this->end_controls_section();

		// Title
		$this->start_controls_section(
			'section_title_style',
			[
				'label'      => esc_html__( 'Title', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'title_custom_width',
			[
				'label' => esc_html__( 'Custom width', 'phox-host' ),
				'type'  => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'phox-host' ),
				'label_off' => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default' => 'false',
			]
		);

		$this->add_responsive_control(
			'title_width',
			[
				'label' => esc_html__( 'Width', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'%',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 350,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['title'] => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'title_custom_width' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'title_text_alignment',
			[
				'label'   => esc_html__( 'Text Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'start', 'phox-host' ),
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
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['title'] => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'start', 'phox-host' ),
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
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['title'] => 'align-self: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type'  => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['title'] => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'title_typography',
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} ' . $css_scheme['title'],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Comment
		$this->start_controls_section(
			'section_comment_style',
			[
				'label'      => esc_html__( 'Comments', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'comment_text_alignment',
			[
				'label'   => esc_html__( 'Text Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'start', 'phox-host' ),
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
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'comment_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'start', 'phox-host' ),
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
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'align-self: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'comment_color',
			[
				'label'      => esc_html__( 'Color', 'phox-host' ),
				'type'       => Controls_Manager::COLOR,
				'default'    => '#ffffff',
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['comment'] . ' span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'comment_typography',
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} ' . $css_scheme['comment'] . ' span',
			]
		);

		$this->add_responsive_control(
			'comment_width',
			[
				'label' => esc_html__( 'Width', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'%',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 350,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'use_comment_corner',
			[
				'label' => esc_html__( 'Use comment corner', 'phox-host' ),
				'type'  => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'phox-host' ),
				'label_off' => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default' => 'false',
			]
		);

		$this->add_control(
			'comment_corner_color',
			[
				'label'      => esc_html__( 'Color', 'phox-host' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['comment'] . ':after' => 'border-color: {{VALUE}} transparent transparent transparent;',
				],
				'condition' => [
					'use_comment_corner' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'comment_corner_position',
			[
				'label' => esc_html__( 'Corner Position', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'%',
				],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 50,
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['comment'] . ':after' => 'left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'use_comment_corner' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'comment_corner_width',
			[
				'label' => esc_html__( 'Corner Width', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['comment'] . ':after' => 'border-right-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'use_comment_corner' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'comment_corner_height',
			[
				'label' => esc_html__( 'Corner Height', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['comment'] . ':after' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'use_comment_corner' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'comment_corner_skew',
			[
				'label' => esc_html__( 'Corner Skew', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['comment'] . ':after' => 'border-left-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'use_comment_corner' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'comment_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['comment'],
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

		$this->add_responsive_control(
			'comment_padding',
			[
				'label' => esc_html__( 'Padding', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top'    => 25,
					'right'  => 15,
					'bottom' => 25,
					'left'   => 15,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'comment_margin',
			[
				'label' => esc_html__( 'Margin', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'comment_border',
				'label' => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default' => '1px',
				'selector' => '{{WRAPPER}} ' . $css_scheme['comment'],
			]
		);

		$this->add_control(
			'comment_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [
					'px',
					'%',
				],
				'default' => [
					'top'    => 5,
					'right'  => 5,
					'bottom' => 5,
					'left'   => 5,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['comment'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}}  {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'  => 'comment_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['comment'],
			]
		);

		$this->end_controls_section();

		// Name
		$this->start_controls_section(
			'section_name_style',
			[
				'label'      => esc_html__( 'Name', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'name_text_alignment',
			[
				'label'   => esc_html__( 'Text Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left' => [
						'title' => esc_html__( 'start', 'phox-host' ),
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
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['name'] => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'name_custom_width',
			[
				'label' => esc_html__( 'Custom width', 'phox-host' ),
				'type'  => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'phox-host' ),
				'label_off' => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default' => 'false',
			]
		);

		$this->add_responsive_control(
			'name_width',
			[
				'label' => esc_html__( 'Width', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'%',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 350,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['name'] => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'name_custom_width' => 'yes',
				],
			]
		);

		$this->add_control(
			'name_color',
			[
				'label'      => esc_html__( 'Color', 'phox-host' ),
				'type'       => Controls_Manager::COLOR,
				'scheme'     => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_2,
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['name'] . ' span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'name_hover_color',
			[
				'label'      => esc_html__( 'Hover Color', 'phox-host' ),
				'type'       => Controls_Manager::COLOR,
				'scheme'     => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_2,
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['name'] . ' span:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'  => 'name_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['name'] . ' span',
			]
		);

		$this->add_responsive_control(
			'name_padding',
			[
				'label' => esc_html__( 'Padding', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['name'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'name_margin',
			[
				'label' => esc_html__( 'Margin', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['name'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		//Position
		$this->start_controls_section(
			'section_position_style',
			[
				'label'      => esc_html__( 'Position', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'position_alignment',
			[
				'label'   => esc_html__( 'Text Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'start', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['position'] => 'align-self: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'position_custom_width',
			[
				'label' => esc_html__( 'Custom width', 'phox-host' ),
				'type'  => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'phox-host' ),
				'label_off' => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default' => 'false',
			]
		);

		$this->add_responsive_control(
			'position_width',
			[
				'label' => esc_html__( 'Width', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'%',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 350,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['position'] => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'position_custom_width' => 'yes',
				],
			]
		);

		$this->add_control(
			'position_color',
			[
				'label'      => esc_html__( 'Color', 'phox-host' ),
				'type'       => Controls_Manager::COLOR,
				'scheme'     => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['position'] . ' span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'  => 'position_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['position'] . ' span',
			]
		);

		$this->add_responsive_control(
			'position_padding',
			[
				'label' => esc_html__( 'Padding', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['position'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'position_margin',
			[
				'label' => esc_html__( 'Margin', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['position'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		//Date
		$this->start_controls_section(
			'section_date_style',
			[
				'label'      => esc_html__( 'Date', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'date_alignment',
			[
				'label'   => esc_html__( 'Text Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'start', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'flex-end' => [
						'title' => esc_html__( 'End', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['date'] => 'align-self: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'date_custom_width',
			[
				'label' => esc_html__( 'Custom width', 'phox-host' ),
				'type'  => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'phox-host' ),
				'label_off' => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default' => 'false',
			]
		);

		$this->add_responsive_control(
			'date_width',
			[
				'label' => esc_html__( 'Width', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'%',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 350,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['date'] => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'date_custom_width' => 'yes',
				],
			]
		);

		$this->add_control(
			'date_color',
			[
				'label'      => esc_html__( 'Color', 'phox-host' ),
				'type'       => Controls_Manager::COLOR,
				'scheme'     => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['date'] . ' span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'  => 'date_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['date'] . ' span',
			]
		);

		$this->add_responsive_control(
			'date_padding',
			[
				'label' => esc_html__( 'Padding', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['date'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'date_margin',
			[
				'label' => esc_html__( 'Margin', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['date'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		//Rating
		$this->start_controls_section(
			'section_rating_style',
			[
				'label'      => esc_html__( 'Rating', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'star_color',
			[
				'label'      => esc_html__( 'Stars', 'phox-host' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['rating'] . ' i.regular-star' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'star_active_color',
			[
				'label'      => esc_html__( 'Active Stars', 'phox-host' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['rating'] . ' i.active-star' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_icon_size',
			[
				'label' => esc_html__( 'Size', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '20',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_icon_space',
			[
				'label' => esc_html__( 'Spacing', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => '7',
				],
				'selectors' => [
					'body {{WRAPPER}} i:not(:last-of-type) ' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_star_margin',
			[
				'label' => esc_html__( 'Margin', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['rating'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rating_star_style',
			[
				'label'   => esc_html__( 'Stars Style', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'solid',
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Solid', 'phox-host' ),
						'icon'  => 'eicon-star',
					],
					'outline' => [
						'title' => esc_html__( 'Outline', 'phox-host' ),
						'icon'  => 'eicon-star-o',
					],
				],
			]
		);

		$this->add_responsive_control(
			'rating_active_star_style',
			[
				'label'   => esc_html__( 'Active Stars Style', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'solid',
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Solid', 'phox-host' ),
						'icon'  => 'eicon-star',
					],
					'outline' => [
						'title' => esc_html__( 'Outline', 'phox-host' ),
						'icon'  => 'eicon-star-o',
					],
				],

			]
		);

		$this->end_controls_section();

		//Nav
		$this->start_controls_section(
			'section_arrows_style',
			[
				'label'      => esc_html__( 'Arrows', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->start_controls_tabs( 'tabs_arrows_style' );

		$this->start_controls_tab(
			'tab_arrows_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'arrow_normal_background',
				'label' => esc_html__( 'Background', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['arrow'] . ' button',
			]
		);

		$this->add_control(
			'arrow_normal_font_color',
			[
				'label'      => esc_html__( 'Font Color', 'phox-host' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' button span'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_normal_font_size',
			[
				'label' => esc_html__( 'Font Size', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
					],
					'rem' => [
						'min' => 0.1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' button span' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_normal_button_width',
			[
				'label' => esc_html__( 'Width', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_normal_button_height',
			[
				'label' => esc_html__( 'Height', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' button' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'arrow_normal_border',
				'label' => esc_html__( 'Border', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['arrow'] . ' button',
			]
		);

		$this->add_responsive_control(
			'arrow_normal_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' button'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'  => 'arrow_normal_shadow',
				'label' => esc_html__( 'Box Shadow', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['arrow'] . ' button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_arrows_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'arrow_hover_background',
				'label' => esc_html__( 'Background', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['arrow'] . ' button:hover',
			]
		);

		$this->add_control(
			'arrow_hover_font_color',
			[
				'label'      => esc_html__( 'Font Color', 'phox-host' ),
				'type'       => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' button:hover span'   => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_hover_font_size',
			[
				'label' => esc_html__( 'Font Size', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
					],
					'rem' => [
						'min' => 0.1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' button span:hover' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_hover_button_width',
			[
				'label' => esc_html__( 'Width', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' button:hover' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_hover_button_height',
			[
				'label' => esc_html__( 'Height', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' button:hover' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'arrow_hover_border',
				'label' => esc_html__( 'Border', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['arrow'] . ' button:hover',
			]
		);

		$this->add_responsive_control(
			'arrow_hover_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' button:hover'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'  => 'arrow_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['arrow'] . ' button:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prev_arrow_position',
			[
				'label'      => esc_html__( 'Prev Arrow Position', 'phox-host' ),
				'type'       => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'prev_vert_position',
			[
				'label'      => esc_html__( 'Vertical Position by', 'phox-host' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'top',
				'options' => [
					'top' => esc_html__( 'Top', 'phox-host' ),
					'bottom' => esc_html__( 'Bottom', 'phox-host' ),
				],
			]
		);

		$this->add_responsive_control(
			'prev_top_position',
			[
				'label' => esc_html__( 'Top Indent', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
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
					'prev_vert_position' => 'top',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' .owl-prev' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'prev_bottom_position',
			[
				'label' => esc_html__( 'Bottom Indent', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
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
					'prev_vert_position' => 'bottom',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' .owl-prev' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				],
			]
		);

		$this->add_control(
			'prev_hor_position',
			[
				'label'      => esc_html__( 'Horizontal Position by', 'phox-host' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'top',
				'options' => [
					'left' => esc_html__( 'Left', 'phox-host' ),
					'right' => esc_html__( 'Right', 'phox-host' ),
				],
			]
		);

		$this->add_responsive_control(
			'prev_left_position',
			[
				'label' => esc_html__( 'Left Indent', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
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
					'prev_hor_position' => 'left',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' .owl-prev' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'prev_right_position',
			[
				'label' => esc_html__( 'Right Indent', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
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
					'prev_hor_position' => 'right',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' .owl-prev' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				],
			]
		);

		$this->add_control(
			'next_arrow_position',
			[
				'label'      => esc_html__( 'Next Arrow Position', 'phox-host' ),
				'type'       => Controls_Manager::HEADING,
				'separator'  => 'before',
			]
		);

		$this->add_control(
			'next_vert_position',
			[
				'label'      => esc_html__( 'Vertical Position by', 'phox-host' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'top',
				'options' => [
					'top' => esc_html__( 'Top', 'phox-host' ),
					'bottom' => esc_html__( 'Bottom', 'phox-host' ),
				],
			]
		);

		$this->add_responsive_control(
			'next_top_position',
			[
				'label' => esc_html__( 'Top Indent', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
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
					'next_vert_position' => 'top',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' .owl-next' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'next_bottom_position',
			[
				'label' => esc_html__( 'Bottom Indent', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
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
					'next_vert_position' => 'bottom',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' .owl-next' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				],
			]
		);

		$this->add_control(
			'next_hor_position',
			[
				'label'      => esc_html__( 'Horizontal Position by', 'phox-host' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => 'top',
				'options' => [
					'left' => esc_html__( 'Left', 'phox-host' ),
					'right' => esc_html__( 'Right', 'phox-host' ),
				],
			]
		);

		$this->add_responsive_control(
			'next_left_position',
			[
				'label' => esc_html__( 'Left Indent', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
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
					'next_hor_position' => 'left',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' .owl-next' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'next_right_position',
			[
				'label' => esc_html__( 'Right Indent', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range' => [
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
					'next_hor_position' => 'right',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['arrow'] . ' .owl-next' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				],
			]
		);

		$this->end_controls_section();

		//Dots
		$this->start_controls_section(
			'section_dots_style',
			[
				'label'      => esc_html__( 'Dots', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'dots_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'start', 'phox-host' ),
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
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['dots'] => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dots_gap',
			[
				'label'      => esc_html__( 'Gap', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 5,
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => -400,
						'max' => 400,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['dots'] . ' button ' => 'padding-left: {{SIZE}}{{UNIT}} !important; padding-right: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'dots_margin',
			[
				'label'      => esc_html__( 'Dots Box Margin', 'phox-host' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['dots'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs( 'tabs_dots_style' );
		$this->start_controls_tab(
			'tab_dots_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'dots_normal_background',
				'label' => esc_html__( 'Background', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['dots'] . ' ' . $css_scheme['dot'],
			]
		);

		$this->add_responsive_control(
			'dots_box_size',
			[
				'label' => esc_html__( 'Box Size', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['dots'] . ' ' . $css_scheme['dot'] => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'dots_normal_border',
				'label' => esc_html__( 'Border', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['dots'] . ' ' . $css_scheme['dot'],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'  => 'dots_normal_shadow',
				'label' => esc_html__( 'Box Shadow', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['dots'] . ' ' . $css_scheme['dot'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'dots_hover_background',
				'label' => esc_html__( 'Background', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['dots'] . ' ' . $css_scheme['dot'] . ':hover',
			]
		);

		$this->add_responsive_control(
			'dots_box_size_hover',
			[
				'label' => esc_html__( 'Box Size', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['dots'] . ' ' . $css_scheme['dot'] . ':hover' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'dots_hover_border',
				'label' => esc_html__( 'Border', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['dots'] . ' ' . $css_scheme['dot'] . ':hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'  => 'dots_hover_shadow',
				'label' => esc_html__( 'Box Shadow', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['dots'] . ' ' . $css_scheme['dot'] . ':hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_active',
			[
				'label' => esc_html__( 'Active', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'dots_active_background',
				'label' => esc_html__( 'Background', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['dots'] . ' ' . $css_scheme['dot_active'],
			]
		);

		$this->add_responsive_control(
			'dots_box_size_active',
			[
				'label' => esc_html__( 'Box Size', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
					],
					'em' => [
						'min' => 0.1,
						'max' => 10,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['dots'] . ' ' . $css_scheme['dot_active'] => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'dots_active_border',
				'label' => esc_html__( 'Border', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['dots'] . ' ' . $css_scheme['dot_active'],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'  => 'dots_active_shadow',
				'label' => esc_html__( 'Box Shadow', 'phox-host' ),
				'selector' => '{{WRAPPER}} ' . $css_scheme['dots'] . ' ' . $css_scheme['dot_active'],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Render
	 * @access protected
	 */
	protected function render() {
		$testimonials = $this->get_settings_for_display( 'item_list' );
		$carousel_options = $this->options_json();

		$use_comment_corner = $this->get_settings( 'use_comment_corner' );

		$classes = [ 'wdes-testimonials-instance', 'owl-carousel', 'owl-theme' ];

		if ( helpers::check_var_true( $use_comment_corner ) ) {
			$classes [] = 'wdes-testimonials-comment-corner';
		}

		$this->add_render_attribute( 'instance', [
			'class' => $classes,
			'data-settings' => $carousel_options,
		] );

		/*
		 * Rating
		 */

		$this->render_html_block( $this->get_name(), '<div class="elementor-%s wdes-testimonials">' );

		$this->render_html_block( $this->get_render_attribute_string( 'instance' ), '<div %s>' );

		foreach ( $testimonials as $index => $item ) {
			print( '<div class="wdes-testimonials-item" >' );
				print( '<div class="wdes-testimonials-item-inner" >' );
					print( '<div class="wdes-testimonials-content" >' );
						$this->get_item_image( $item );
			if ( ! empty( $item['item_icon']['value'] ) ) {
				printf( '<div class="wdes-testimonials-icon" ><div class="wdes-testimonials-icon-inner" > <i class="%s"></i></div></div>', $item['item_icon']['value'] ); }
			if ( ! empty( $item['item_title'] ) ) {
				printf( '<h5 class="wdes-testimonials-title" >%s</h5>', $item['item_title'] ); }
			if ( ! empty( [ 'item_comment' ] ) ) {
				printf( '<p class="wdes-testimonials-comment" > <span>%s</span></p>', $item['item_comment'] ); }
						$this->get_item_name( $item );
			if ( ! empty( $item['item_position'] ) ) {
				printf( '<div class="wdes-testimonials-position" > <span>%s</span></div>', $item['item_position'] ); }
			if ( ! empty( $item['item_date'] ) ) {
				printf( '<div class="wdes-testimonials-date" > <span>%s</span></div>', $item['item_date'] );}
			if ( $item['item_rating'] ) {
				printf( '<div class="wdes-testimonials-rating" data-rating="%2$d" > <span>%1$s</span></div>', $this->get_stars( $item['item_rating'] ), $item['item_rating'] );}
					print( '</div>' );
				print( '</div>' );
			print( '</div>' );

		}
		print( '</div>' );

		print( '</div>' );
	}

	/**
	 * Render Stars
	 *
	 * @param $item_rating
	 * @return string
	 */
	public function get_stars( $item_rating ) {

		$stars_html = '';
		$stars = 1;

		$style = ( 'outline' === $this->get_settings_for_display( 'rating_star_style' ) ) ? 'far fa-star' : 'fas fa-star';
		$active_style = ( 'outline' === $this->get_settings_for_display( 'rating_active_star_style' ) ) ? 'far fa-star' : 'fas fa-star';
		for ( $stars; $stars <= 5; $stars++ ) {

			if ( $item_rating >= $stars ) {
				$stars_html .= '<i class="active-star ' . $active_style . '" aria-hidden="true" ></i>';
			} else {
				$stars_html .= '<i class="regular-star ' . $style . '" aria-hidden="true" ></i>';
			}
		}

		return $stars_html;

	}

	/**
	 * Render image with link
	 *
	 * @param $date
	 * @access protected
	 * @return int|void
	 */
	protected function get_item_image( $date ) {

		$image = $date['item_image'];
		$link = $date['item_link'];

		if ( empty( $image['url'] ) ) {
			return;
		}

		$item_link = isset( $link ) ? $link : false;

		if ( $item_link && ! empty( $item_link['url'] ) ) {

			$link_attr = [
				'href' => esc_attr( $item_link['url'] ),
			];

			if ( ! empty( $item_link['is_external'] ) ) {
				$link_attr['target'] = '_blank';
			}

			if ( ! empty( $item_link['nofollow'] ) ) {
				$link_attr['rel'] = 'nofollow';
			}

			return printf( '<div class="wdes-testimonials-image" ><a %3$s><img class="wdes-testimonials-image-tag" src="%1$s" alt="%2$s" ></a></div>',
				$image['url'],
				esc_attr( Control_Media::get_image_alt( $image ) ),
				Utils::render_html_attributes( $link_attr )
			);

		}

		return printf( '<div class="wdes-testimonials-image" ><img class="wdes-testimonials-image-tag" src="%1$s" alt="%2$s" ></div>',
			$image['url'],
			esc_attr( Control_Media::get_image_alt( $image ) )
		);

	}


	/**
	 * Render name with link
	 *
	 * @param $date
	 * @access protected
	 * @return int|void
	 */
	protected function get_item_name( $date ) {

		$name = $date['item_name'];
		$link = $date['item_link'];

		if ( empty( $name ) ) {
			return;
		}

		$item_link = isset( $link ) ? $link : false;

		if ( $item_link && ! empty( $item_link['url'] ) ) {

			$link_attr = [
				'href' => esc_attr( $item_link['url'] ),
			];

			if ( ! empty( $item_link['is_external'] ) ) {
				$link_attr['target'] = '_blank';
			}

			if ( ! empty( $item_link['nofollow'] ) ) {
				$link_attr['rel'] = 'nofollow';
			}

			return printf( '<div class="wdes-testimonials-name" ><a %2$s><span>%1$s</span></a></div>',
				$name,
				Utils::render_html_attributes( $link_attr )
			);

		}

		return printf( '<div class="wdes-testimonials-name" ><span>%s</span></div>', $name );

	}

	public function options_json() {

		$settings = $this->get_settings();

		$items_on_screen_tablet = ! empty( $settings['items_on_screen_tablet'] )  ? absint( $settings['items_on_screen_tablet'] ): false  ;
		$items_on_screen = ! empty( $settings['items_on_screen'] )  ? absint( $settings['items_on_screen'] ): false  ;
		$items_on_screen_mobile = ! empty( $settings['items_on_screen_mobile'] )  ? absint( $settings['items_on_screen_mobile'] ): false  ;
		$autoplay_speed = ! empty( $settings['autoplay_speed'] )  ? absint( $settings['autoplay_speed'] ): false  ;

		$options = [
			'items'              => [
				'desktop'  => $items_on_screen,
				'tablet'   => $items_on_screen_tablet ,
				'mobile'   => $items_on_screen_mobile,
			],
			'autoplay'           => helpers::check_var_true( $settings['autoplay'] ),
			'autoplayHoverPause' => helpers::check_var_true( $settings['autoplay_hover'] ),
			'autoplaySpeed'      => absint( $autoplay_speed ),
			'loop'               => helpers::check_var_true( $settings['infinity'] ),
			'nav'                => helpers::check_var_true( $settings['nav'] ),
			'dots'               => helpers::check_var_true( $settings['dots'] ),
			'autoHeight'         => helpers::check_var_true( $settings['auto_height'] ),
		];

		$json = wp_json_encode( $options );

		return $json;

	}


}

