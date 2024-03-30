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
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;

/**
 * Site Logo widget.
 *
 * Site Logo widget that will display in Phox Builder category
 *
 * @package Elementor\Widgets
 * @since 2.0.0
 */
class Site_Logo extends Base_Builder_Widget {
	/**
	 * Get Widget name
	 *
	 * Retrieve Logo widget name
	 *
	 * @return string Widget name
	 * @since  2.0.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'wdes-logo';
	}

	/**
	 * Get Widget title
	 *
	 * Retrieve Logo widget title
	 *
	 * @return string Widget title
	 * @since  2.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Site Logo', 'phox-host' );
	}

	/**
	 * Get Widget icon
	 *
	 * Retrieve Domain Search widget icon
	 *
	 * @return string Widget icon
	 * @since  2.0.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'wdes-widget-elementor wdes-widget-logo';
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
		return [ 'domain', 'search', 'form' ];
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

		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'phox-host' ),
			]
		);

		$this->add_control(
			'logo_type',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Logo Type', 'phox-host' ),
				'default' => 'text',
				'options' => [
					'text'  => esc_html__( 'Text', 'phox-host' ),
					'image' => esc_html__( 'Image', 'phox-host' ),
					'both'  => esc_html__( 'Both Text and Image', 'phox-host' ),
				],
			]
		);

		$this->add_control(
			'logo_image_custom',
			[
				'type'    => Controls_Manager::SWITCHER,
				'label'   => esc_html__( 'Custom Image', 'phox-host' ),
				'default' => '',
				'condition' => [
					'logo_type' => ['image', 'both']
				],
			]
		);

		$this->add_control(
			'logo_text_from',
			[
				'type'       => Controls_Manager::SELECT,
				'label'      => esc_html__( 'Logo Text From', 'phox-host' ),
				'default'    => 'site_name',
				'options'    => [
					'site_name' => esc_html__( 'Site Name', 'phox-host' ),
					'admin_panel' => esc_html__( 'Phox Admin Panel', 'phox-host' ),
					'custom'    => esc_html__( 'Custom', 'phox-host' ),
				],
				'condition' => [
					'logo_type!' => 'image',
				],
			]
		);

		$this->add_control(
			'logo_text',
			[
				'label'     => esc_html__( 'Custom Logo Text', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Site Name',
				'condition' => [
					'logo_text_from' => 'custom',
					'logo_type!'     => 'image',
				],
			]
		);

		$this->add_control(
			'logo_image',
			[
				'label'     => esc_html__( 'Logo Image', 'phox-host' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'logo_type!' => 'text',
					'logo_image_custom' => 'yes',
				],
			]
		);

		$this->add_control(
			'logo_image_2x',
			[
				'label'     => esc_html__( 'Retina Logo Image', 'phox-host' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'logo_type!' => 'text',
					'logo_image_custom' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_settings',
			[
				'label' => esc_html__( 'Settings', 'phox-host' ),
			]
		);

		$this->add_control(
			'link',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Link', 'phox-host' ),
				'default' => 'default',
				'options' => [
					'default'  => esc_html__( 'Default', 'phox-host' ),
					'custom' => esc_html__( 'Custom', 'phox-host' ),
					'none'  => esc_html__( 'None', 'phox-host' ),
				],
			]
		);

		$this->add_control(
			'link_custom',
			[
				'label'     => esc_html__( 'Custom Logo Text', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'link' => 'custom'
				],
			]
		);

		//Image
		$this->add_control(
			'logo_image_settings',
			[
				'label'	=> esc_html__('Image Settings', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'condition' => [
					'logo_type' => ['image', 'both']
				],
			]
		);

		$this->add_responsive_control(
			'alignment_image',
			[
				'label'     => __('Alignment', 'phox-host'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'flex-start',
				'options'   => [
					'flex-start'    => [
						'title' =>  __('Left', 'phox-host'),
						'icon'  =>  'eicon-arrow-left'
					],
					'center'    => [
						'title' =>  __('Center', 'phox-host'),
						'icon'  =>  'eicon-text-align-justify'
					],
					'flex-end'    => [
						'title' =>  __('Right', 'phox-host'),
						'icon'  =>  'eicon-arrow-right'
					],
				],
				'selectors'     => [
					'{{WRAPPER}} .wdes-logo_link'    =>  'justify-content: {{VALUE}};'
				],
				'condition' => [
					'logo_type' => ['image', 'both']
				]
			]
		);

		//Both
		$this->add_control(
			'logo_both_settings',
			[
				'label'	=> esc_html__('Order Items', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'condition' => [
					'logo_type' => ['both']
				],
			]
		);
		$this->add_control(
			'logo_display',
			[
				'type'        => 'select',
				'label'       => esc_html__( 'Display Logo Image and Text', 'phox-host' ),
				'label_block' => true,
				'default'     => 'inline',
				'options'     => [
					'inline' => esc_html__( 'Inline', 'phox-host' ),
					'block'  => esc_html__( 'Block', 'phox-host' ),
				],
				'condition' => [
					'logo_type' => 'both',
				],
			]
		);

		$this->add_control(
			'logo_order_img',
			[
				'label'	=> esc_html__('Image Order', 'phox-host'),
				'type'	=> Controls_Manager::NUMBER,
				'min' => 1,
				'default' => 1,
				'condition' => [
					'logo_type' => 'both'
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-logo_img' => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'logo_order_txt',
			[
				'label'	=> esc_html__('Text Order', 'phox-host'),
				'type'	=> Controls_Manager::NUMBER,
				'min' => 1,
				'default' => 2,
				'condition' => [
					'logo_type' => 'both'
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-logo_text' => 'order: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'img_logo_style',
			[
				'label'      => esc_html__( 'Image', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition' => [
					'logo_type' => ['image', 'both'],
				],
			]
		);

		$this->add_responsive_control(
			'logo_img_height',
			[
				'label'          => __( 'Height', 'phox-host' ),
				'type'           => Controls_Manager::SLIDER,
				'range'          => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-logo_img' => 'height: {{SIZE}}px;',
				],
			]
		);

		$this->start_controls_tabs( 'image_effects' );

		$this->start_controls_tab(
			'normal',
			[
				'label' => __( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'opacity',
			[
				'label'     => __( 'Opacity', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-logo_img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .wdes-logo_img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => __( 'Hover', 'phox-host' ),
			]
		);
		$this->add_control(
			'opacity_hover',
			[
				'label'     => __( 'Opacity', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-logo_img:hover' => 'opacity: {{SIZE}};',
				],
			]
		);
		$this->add_control(
			'background_hover_transition',
			[
				'label'     => __( 'Transition Duration', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max'  => 3,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-logo_img' => 'transition-duration: {{SIZE}}s',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .wdes-logo_img:hover',
			]
		);

		$this->add_control(
			'hover_animation',
			[
				'label' => __( 'Hover Animation', 'phox-host' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'image_logo_gap',
			array(
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .wdes-logo_img'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'logo_type' => 'both',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'text_logo_style',
			array(
				'label'      => esc_html__( 'Text', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition' => [
					'logo_type' => ['text', 'both'],
				],
			)
		);

		$this->add_control(
			'text_logo_color',
			array(
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => array(
					'type'  => Color::get_type(),
					'value' => Color::COLOR_4,
				),
				'selectors' => array(
					'{{WRAPPER}} .wdes-logo_text' => 'color: {{VALUE}}',
				),
				'default' => '#0A2540',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_logo_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wdes-logo_text',
				'fields_options' => [
					'typography'  => [
						'default' => 'yes'
					],
					'font_weight' => [
						'default' => '700',
					],
					'font_family' => [
						'default' => 'Poppins',
					],
				]
			)
		);

		$this->add_control(
			'text_logo_gap',
			array(
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'size' => 5,
				),
				'selectors'  => array(
					'{{WRAPPER}} .wdes-logo_text'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'logo_type' => 'both',
				),
			)
		);

		$this->add_responsive_control(
			'text_logo_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left' => array(
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
				'selectors' => array(
					'{{WRAPPER}} .wdes-logo_text' => 'text-align: {{VALUE}}',
				),
				'condition' => array(
					'logo_type'    => 'both',
					'logo_display' => 'block',
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

		$classes = [
			'wdes-logo',
			'wdes-logo-type-' . $settings['logo_type'],
			'wdes-logo-display-' . $settings['logo_display'],
		];

		printf('<div class="%1$s">', esc_attr(implode(' ', $classes)));

		$link = $this->get_link($settings['link']);

		if( $link ){

				printf( '<a  href="%1$s" class="wdes-logo_link">', esc_url($link));

		}else{

				print ('<div class="wdes-logo_link">');

		}

		echo $this->logo_image();
		echo $this->logo_text();

		if( $link ){

			print ('</a>');

		}else{

			print ('</div>');

		}

		print ('</div>');

	}

	/**
	 * Logo text
	 *
	 * @since  2.0.0
	 * @access protected
	 */
	private function logo_text(){

		$settings    = $this->get_settings();
		$type        = isset( $settings['logo_type'] ) ? esc_attr( $settings['logo_type'] ) : 'text';
		$text_from   = isset( $settings['logo_text_from'] ) ? esc_attr( $settings['logo_text_from'] ) : 'site_name';
		$custom_text = isset( $settings['logo_text'] ) ? wp_kses_post( $settings['logo_text'] ) : 'Site Name';
		$text_tag = 'h2';

		if ( 'image' === $type ) {
			return;
		}

		if ( 'site_name' === $text_from ) {
			$text = get_bloginfo( 'name' );
		} elseif ('admin_panel' === $text_from){
			$text = wdes_opts_get('text-logo', 'Site Name');
		} else {
			$text = $custom_text;
		}

		return sprintf( '<%2$s class="wdes-logo_text"> %1$s </%2$s>', $text, $text_tag);

	}

	/**
	 * Logo Image
	 *
	 * @since  2.0.0
	 * @access protected
	 */
	public function logo_image() {

		$settings    = $this->get_settings();
		$type     = isset( $settings['logo_type'] ) ? esc_attr( $settings['logo_type'] ) : 'text';
		$image    = ( ! empty( $settings['logo_image_custom'] ) ) ? ( $settings['logo_image'] ?? false )  : wdes_opts_get('logo');
		$image_2x = ( ! empty( $settings['logo_image_custom'] ) ) ? ( $settings['logo_image_2x'] ?? false ) : wdes_opts_get('retinal-logo');

		if ( 'text' === $type || ! $image ) {
			return;
		}
		$image_src    = ( empty( $settings['logo_image_custom'] ) ) ? $image : $this->get_logo_image_src( $image );
		$image_2x_src = ( empty( $settings['logo_image_custom'] ) ) ? $image_2x : $this->get_logo_image_src( $image_2x );


		if ( empty( $image_src ) && empty( $image_2x_src ) ) {
			return;
		}


		$image_data  = (! empty( $settings['logo_image_custom'] ) ) ? ! empty( $image['id'] ) ? wp_get_attachment_image_src( $image['id'], 'full' ) : array() : false;
		$width       = (! empty( $settings['logo_image_custom'] ) ) ? (! empty( $settings['logo_img_height']['size'] ) ) ? 'auto' : $image_data[1] ?? false : false;
		$height      = (! empty( $settings['logo_image_custom'] ) ) ? (! empty( $settings['logo_img_height']['size'] ) ) ? $settings['logo_img_height']['size'] : $image_data[2] ?? false : false ;

		$attrs = sprintf(
			'%1$s%2$s%3$s',
			$width ? ' width="' . $width . '"' : '',
			$height ? ' height="' . $height . '"' : '',
			( ! empty( $image_2x_src ) ? ' srcset="'.esc_url( $image_src ).' 1x,' . esc_url( $image_2x_src ) . ' 2x"' : '' )
		);

		$site_image_class = 'elementor-animation-';

		$img_animation = 'none';

		if ( ! empty( $settings['hover_animation'] ) ) {
			$img_animation = $settings['hover_animation'];
		}

		$class_animation = $site_image_class . $img_animation;

		return sprintf( '<img class="wdes-logo_img %4$s" src="%1$s" width="200" height="200" alt="%2$s"%3$s>', esc_url( $image_src ), get_bloginfo( 'name' ), $attrs, $class_animation );

	}

	/**
	 * Get Image Scr
	 *
	 * @since  2.0.0
	 * @access protected
	 * @param array $img_args
	 */
	private function get_logo_image_src( $img_args = [] ){

		if ( ! empty( $img_args['id'] ) ) {
			$img_data = wp_get_attachment_image_src( $img_args['id'], 'full' );

			return ! empty( $img_data[0] ) ? $img_data[0] : false;
		}

		if ( ! empty( $img_args['url'] ) ) {
			return $img_args['url'];
		}

		return false;

	}

	/**
	 * Get Link
	 * Check link setting and back with right value
	 *
	 * @since  2.0.0
	 * @access protected
	 * @param $link_type
	 * @return string|bool
	 */
	private function get_link ( $link_type ){

		switch ($link_type) {
			case 'custom':
				$link = $this->get_settings('link_custom');
				break;
			case 'none':
				$link = false;
				break;
			default:
				$link = get_home_url();
		}

		return $link ;

	}
}