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
use \Elementor\Control_Media;
use Elementor\Utils;

/**
 * Site  widget.
 *
 * Site Search widget that will display in Phox Builder category
 *
 * @package Elementor\Widgets
 * @since 2.0.0
 */
class Site_Search extends Base_Builder_Widget {
	/**
	 * Get Widget name
	 *
	 * Retrieve Search widget name
	 *
	 * @return string Widget name
	 * @since  2.0.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'wdes-search';
	}

	/**
	 * Get Widget title
	 *
	 * Retrieve Search widget title
	 *
	 * @return string Widget title
	 * @since  2.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Site Search', 'phox-host' );
	}

	/**
	 * Get Widget icon
	 *
	 * Retrieve Search widget icon
	 *
	 * @return string Widget icon
	 * @since  2.0.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'wdes-widget-elementor wdes-widget-search';
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
		return ['search'];
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
			'form'                    => '.wdes-search-form',
			'form_input'              => '.wdes-search-field',
			'form_submit'             => '.wdes-search-submit',
			'form_submit_icon'        => '.wdes-search-submit-icon',
			'popup'                   => '.wdes-search-popup',
			'popup_full_screen'       => '.wdes-search-popup-full-screen',
			'popup_content'           => '.wdes-search-popup-content',
			'popup_close'             => '.wdes-search-popup-close',
			'popup_close_icon'        => '.wdes-search-popup-close-icon',
			'popup_trigger_container' => '.wdes-search-popup-trigger-container',
			'popup_trigger'           => '.wdes-search-popup-trigger',
			'popup_trigger_icon'      => '.wdes-search-popup-trigger-icon',
			'popup_trigger_img'       => '.wdes-search-popup-trigger-img',
			'popup_trigger_label'     => '.wdes-search-popup-trigger-submit-label'
		];

		$this->start_controls_section(
			'section_search_general_settings',
			[
				'label' => esc_html__( 'General Settings', 'phox-host' ),
			]
		);

		$this->add_control(
			'search_layouts',
			[
				'label'   => esc_html__( 'Layouts', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'normal' => esc_html__( 'Normal', 'phox-host' ),
					'popup' => esc_html__( 'Popup', 'phox-host' )
				],
				'default' => 'normal',
			]
		);

		$this->add_control(
			'search_placeholder',
			[
				'label'   => esc_html__( 'Search Placeholder', 'phox-host' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Search &hellip;', 'phox-host' ),
			]
		);

		$this->add_control(
			'search_button_heading',
			[
				'label'   => esc_html__( 'Button', 'phox-host' ),
				'type'    => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'show_search_submit',
			[
				'label'        => esc_html__( 'Show Submit Button', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'true',
				'default'      => 'true',
			]
		);

		$this->add_control(
			'search_submit_label',
			[
				'label'     => esc_html__( 'Submit Button Label', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => [
					'show_search_submit' => 'true',
				],
			]
		);

		$this->add_control(
			'search_submit_icon',
			[
				'label'       => esc_html__( 'Submit Button Icon', 'phox-host' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => false,
				'skin'        => 'inline',
				'file'        => '',
				'default' => [
					'value'   => 'fas fa-search',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'is_product_search',
			[
				'label'        => esc_html__( 'Is Product Search', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'true',
				'default'      => '',
				'separator'    => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_search_popup_settings',
			[
				'label' => esc_html__( 'Popup Settings', 'phox-host' ),
				'condition' => [
					'search_layouts' => 'popup',
				],
			]
		);

		$this->add_control(
			'full_screen_popup',
			[
				'label'        => esc_html__( 'Full Screen Popup', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'true',
				'default'      => ''
			]
		);

		$this->add_control(
			'search_popup_trigger_img_icon',
			[
				'label'   => esc_html__( 'Popup Trigger Type', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'img' => esc_html__( 'Image', 'phox-host' ),
					'icon' => esc_html__( 'Icon', 'phox-host' )
				],
				'default' => 'icon',
			]
		);

		$this->add_control(
			'search_popup_trigger_image',
			[
				'label'       => esc_html__( 'Popup Trigger Image', 'phox-host' ),
				'type'        => Controls_Manager::MEDIA,
				'condition' => [
					'search_popup_trigger_img_icon' => 'img',
				]
			]
		);

		$this->add_control(
			'search_popup_trigger_icon',
			[
				'label'       => esc_html__( 'Popup Trigger Icon', 'phox-host' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => false,
				'skin'        => 'inline',
				'file'        => '',
				'default' => [
					'value'   => 'fas fa-search',
					'library' => 'fa-solid',
				],
				'condition' => [
					'search_popup_trigger_img_icon' => 'icon',
				]
			]
		);

		$this->add_control(
			'search_close_icon',
			[
				'label'       => esc_html__( 'Popup Close Button Icon', 'phox-host' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => false,
				'skin'        => 'inline',
				'file'        => '',
				'default' => [
					'value'   => 'fas fa-times',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'search_popup_trigger_submit_label',
			[
				'label'     => esc_html__( 'Submit Button Label', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => ''
			]
		);

		$this->add_control(
			'popup_show_effect',
			[
				'label'   => esc_html__( 'Show Effect', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'      => esc_html__( 'None', 'phox-host' ),
					'fade'      => esc_html__( 'Fade', 'phox-host' ),
					'scale'     => esc_html__( 'Scale', 'phox-host' ),
					'move-up'   => esc_html__( 'Move Up', 'phox-host' ),
					'move-down' => esc_html__( 'Move Down', 'phox-host' ),
				],
				'default' => 'move-up',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_form_style',
			[
				'label' => esc_html__( 'Form', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'form_bg_color',
			[
				'label'  => esc_html__( 'Background Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form'] => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'form_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['form'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['form'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'form_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['form'],
			]
		);

		$this->add_responsive_control(
			'form_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['form'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'form_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['form'],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_input_style',
			[
				'label' => esc_html__( 'Input', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'form_input_typography',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['form_input'],
			]
		);

		$this->start_controls_tabs( 'form_input_tabs' );

		$this->start_controls_tab(
			'form_input_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'form_input_bg_color',
			[
				'label'  => esc_html__( 'Background Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form_input'] => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'form_input_color',
			[
				'label'  => esc_html__( 'Text Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form_input'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'form_input_placeholder_color',
			[
				'label'  => esc_html__( 'Placeholder Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form_input'] . '::-webkit-input-placeholder' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['form_input'] . '::-moz-placeholder'          => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':-ms-input-placeholder'      => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'form_input_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['form_input'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'form_input_tab_focus',
			[
				'label' => esc_html__( 'Focus', 'phox-host' ),
			]
		);

		$this->add_control(
			'form_input_bg_color_focus',
			[
				'label'  => esc_html__( 'Background Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'form_input_color_focus',
			[
				'label'  => esc_html__( 'Text Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'form_input_placeholder_color_focus',
			[
				'label'  => esc_html__( 'Placeholder Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus::-webkit-input-placeholder' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus::-moz-placeholder'          => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus:-ms-input-placeholder'      => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'form_input_border_color_focus',
			[
				'label'  => esc_html__( 'Border Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'form_input_border_border!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'form_input_box_shadow_focus',
				'selector' => '{{WRAPPER}} ' . $css_scheme['form_input'] . ':focus',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'form_input_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['form_input'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'form_input_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['form_input'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'form_input_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['form_input'],
			]
		);

		$this->add_responsive_control(
			'form_input_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['form_input'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_submit_style',
			[
				'label' => esc_html__( 'Submit', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'form_submit_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['form_submit'],
			]
		);

		$this->add_responsive_control(
			'form_submit_icon_size',
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
					'{{WRAPPER}} ' . $css_scheme['form_submit_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->start_controls_tabs( 'tabs_form_submit_style' );

		$this->start_controls_tab(
			'tab_form_submit_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'form_submit_bg_color',
			[
				'label'  => esc_html__( 'Background Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form_submit'] => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'form_submit_color',
			[
				'label'  => esc_html__( 'Text Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form_submit'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_form_submit_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'form_submit_bg_color_hover',
			[
				'label'  => esc_html__( 'Background Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form_submit'] . ':hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'form_submit_color_hover',
			[
				'label'  => esc_html__( 'Text Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form_submit'] . ':hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'form_submit_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'form_submit_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['form_submit'] . ':hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'form_submit_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['form_submit'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'form_submit_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['form_submit'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'form_submit_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['form_submit'],
			]
		);

		$this->add_responsive_control(
			'form_submit_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['form_submit'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'form_submit_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['form_submit'],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_style',
			[
				'label'      => esc_html__( 'Popup Box', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => [
					'search_layouts' => 'popup',
				],
			]
		);

		$this->add_responsive_control(
			'popup_width',
			[
				'label' => esc_html__( 'Popup Content Width', 'phox-host' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['popup'] . ':not(' . $css_scheme['popup_full_screen'] . ')' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['popup_full_screen'] . ' ' . $css_scheme['popup_content'] => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'popup_bg_color',
			[
				'label'  => esc_html__( 'Background Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['popup'] => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'popup_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['popup'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'popup_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['popup'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'popup_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['popup'],
			]
		);

		$this->add_responsive_control(
			'popup_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['popup'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'popup_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['popup'],
			]
		);

		$this->add_control(
			'popup_position',
			[
				'label'     => esc_html__( 'Popup Position', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'full_screen_popup' => '',
				],
			]
		);

		$this->add_control(
			'popup_vert_position',
			[
				'label'   => esc_html__( 'Vertical Postition by', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'top'    => esc_html__( 'Top', 'phox-host' ),
					'bottom' => esc_html__( 'Bottom', 'phox-host' ),
				],
				'condition' => [
					'full_screen_popup' => '',
				],
			]
		);

		$this->add_responsive_control(
			'popup_top_position',
			[
				'label'      => esc_html__( 'Top Indent', 'phox-host' ),
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
					'popup_vert_position' => 'top',
					'full_screen_popup'   => '',
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['popup'] => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'popup_bottom_position',
			[
				'label'      => esc_html__( 'Bottom Indent', 'phox-host' ),
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
					'popup_vert_position' => 'bottom',
					'full_screen_popup'   => '',
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['popup'] => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				],
			]
		);

		$this->add_control(
			'popup_hor_position',
			[
				'label'   => esc_html__( 'Horizontal Position by', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Left', 'phox-host' ),
					'right' => esc_html__( 'Right', 'phox-host' ),
				],
				'condition' => [
					'full_screen_popup' => '',
				],
			]
		);

		$this->add_responsive_control(
			'popup_left_position',
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
					'popup_hor_position' => 'left',
					'full_screen_popup'  => '',
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['popup'] => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'popup_right_position',
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
					'popup_hor_position' => 'right',
					'full_screen_popup'  => '',
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['popup'] => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_trigger_style',
			[
				'label'      => esc_html__( 'Popup Trigger', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => [
					'search_layouts' => 'popup',
				],
			]
		);

		$this->add_responsive_control(
			'popup_trigger_icon_size',
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
					'{{WRAPPER}} ' . $css_scheme['popup_trigger_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'search_popup_trigger_img_icon' => 'icon',
				]
			]
		);

		$this->add_responsive_control(
			'popup_trigger_img_height',
			[
				'label'      => esc_html__( 'Image Height', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['popup_trigger_img'] => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'search_popup_trigger_img_icon' => 'img',
				]
			]
		);

		$this->start_controls_tabs( 'tabs_popup_trigger_style' );

		$this->start_controls_tab(
			'tab_popup_trigger_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'popup_trigger_bg_color',
			[
				'label'  => esc_html__( 'Background Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['popup_trigger'] => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'popup_trigger_color',
			[
				'label'  => esc_html__( 'Text Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['popup_trigger'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_popup_trigger_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'popup_trigger_bg_color_hover',
			[
				'label'  => esc_html__( 'Background Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['popup_trigger'] . ':hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'popup_trigger_color_hover',
			[
				'label'  => esc_html__( 'Text Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['popup_trigger'] . ':hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'popup_trigger_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'popup_trigger_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['popup_trigger'] . ':hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'popup_trigger_alignment',
			[
				'label'   => esc_html__( 'Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
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
				'selectors' => [
					'{{WRAPPER}} '  . $css_scheme['popup_trigger_container'] => 'justify-content: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'popup_trigger_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['popup_trigger'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'popup_trigger_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['popup_trigger'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'popup_trigger_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['popup_trigger'],
			]
		);

		$this->add_responsive_control(
			'popup_trigger_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['popup_trigger'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'popup_trigger_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['popup_trigger'],
			]
		);

		$this->add_control(
			'popup_trigger_label',
			[
				'label'     => esc_html__( 'Label', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'popup_trigger_label_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type'  => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['popup_trigger_label'] => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'popup_trigger_label_typography',
				'scheme'    => Typography::TYPOGRAPHY_3,
				'selector'  => '{{WRAPPER}} ' . $css_scheme['popup_trigger_label'],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_close_style',
			[
				'label'      => esc_html__( 'Popup Close', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => [
					'search_layouts' => 'popup',
				],
			]
		);

		$this->add_responsive_control(
			'popup_close_icon_size',
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
					'{{WRAPPER}} ' . $css_scheme['popup_close_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_popup_close_style' );

		$this->start_controls_tab(
			'tab_popup_close_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'popup_close_bg_color',
			[
				'label'  => esc_html__( 'Background Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['popup_close'] => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'popup_close_color',
			[
				'label'  => esc_html__( 'Text Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['popup_close'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_popup_close_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'popup_close_bg_color_hover',
			[
				'label'  => esc_html__( 'Background Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['popup_close'] . ':hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'popup_close_color_hover',
			[
				'label'  => esc_html__( 'Text Color', 'phox-host' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['popup_close'] . ':hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'popup_close_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'popup_close_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['popup_close'] . ':hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'popup_close_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['popup_close'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'popup_close_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['popup_close'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'           => 'popup_close_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['popup_close'],
			)
		);

		$this->add_responsive_control(
			'popup_close_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['popup_close'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'popup_close_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['popup_close'],
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

        print( '<div class="wdes-search">' );

        if ( $settings['search_layouts'] === 'popup' ) {
            $this->popup_template($settings);
        } else {
            $this->form_template($settings);
        }

        print( '</div>' );

    }

    private function popup_template($settings){

        $search_popup_class []= 'wdes-search-popup';

        if ( isset( $settings['full_screen_popup'] ) &&  $settings['full_screen_popup'] === 'true' ) {
            $search_popup_class []= 'wdes-search-popup-full-screen';
        }

        if ( isset( $settings['popup_show_effect'] ) ) {
            $search_popup_class []= sprintf( 'wdes-search-popup-%s-effect', $settings['popup_show_effect'] );
        }

        printf('<div class="%s">', implode(' ', $search_popup_class));

            print('<div class="wdes-search-popup-content">');

                $this->form_template($settings);

                print ('<button type="button" class="wdes-search-popup-close">');

                    if( ! empty( $settings['search_close_icon']['library'] ) && ! empty( $settings['search_close_icon']['value'] ) ){

                        print ('<span class="wdes-search-popup-close-icon wdes-blocks-icon">');

                            printf('<i class="%s" aria-hidden="true"></i>', $settings['search_close_icon']['library'] .' '. $settings['search_close_icon']['value']);

                        print ('</span>');

                    }

                print ('</button>');

            print('</div>');

        print('</div>');

        print ('<div class="wdes-search-popup-trigger-container">');

		    print ('<button type="button" class="wdes-search-popup-trigger">');

			    if( $settings['search_popup_trigger_img_icon'] === 'icon' ){

				    if( ! empty( $settings['search_popup_trigger_icon']['library'] ) && ! empty( $settings['search_popup_trigger_icon']['value'] ) ){

					    print('<span class="wdes-search-popup-trigger-icon wdes-blocks-icon">');

					        printf('<i class="%s" aria-hidden="true"></i>', $settings['search_popup_trigger_icon']['library'] .' '. $settings['search_popup_trigger_icon']['value']);

					    print ('</span>');

				    }

			    }else {

				    if( ! empty( $settings['search_popup_trigger_image']['url'] ) ){

					    printf('<img class="wdes-search-popup-trigger-img wdes-blocks-img" src="%1$s" alt="%2$s" >',
						    $settings['search_popup_trigger_image']['url'],
						    esc_attr( Control_Media::get_image_alt( $settings['search_popup_trigger_image']['url'] ) ));

				    }

			    }

			    if( ! empty( $settings['search_popup_trigger_submit_label'] ) ){

				    printf ('<div class="wdes-search-popup-trigger-submit-label">%s</div>', $settings['search_popup_trigger_submit_label']);

			    }

		    print('</button>');

        print('</div>');



    }

    private function form_template($settings){

       printf('<form role="search" method="get" class="wdes-search-form" action="%s">', esc_url( home_url( '/' ) ) );

            print ('<label class="wdes-search-label">');

                printf('<input type="search" class="wdes-search-field" placeholder="%1$s" value="%2$s" name="s" />', esc_attr( $settings['search_placeholder'] ), get_search_query());

            print ('</label>');

            if ( $settings['show_search_submit'] === 'true' ){

                print ('<button type="submit" class="wdes-search-submit">');

                    if( ! empty( $settings['search_submit_icon']['library'] ) && ! empty( $settings['search_submit_icon']['value'] ) ){

                        print ('<span class="wdes-search-submit-icon wdes-search-icon">');

                            printf('<i class="%s" aria-hidden="true"></i>', $settings['search_submit_icon']['library'] .' '. $settings['search_submit_icon']['value']);

                        print ('</span>');
                    }

                    if( ! empty( $settings['search_submit_label'] ) ){

                        printf ('<div class="wdes-search-submit-label">%s</div>', $settings['search_submit_label']);

                    }

                print ('</button>');
            }

            if ( isset( $settings['is_product_search'] ) && 'true' === $settings['is_product_search'] ){

                print ('<input type="hidden" name="post_type" value="product" />');

            }

       print ('</form>');

    }

}
