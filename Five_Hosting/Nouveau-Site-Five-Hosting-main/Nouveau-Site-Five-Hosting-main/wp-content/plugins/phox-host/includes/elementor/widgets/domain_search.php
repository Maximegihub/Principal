<?php
namespace Phox_Host\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

use Phox_Host\Elementor\Base\Base_Widget;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Repeater;

/**
 * Domain Search widget.
 *
 * Tabs widget that will display in Phox category
 *
 * @package Elementor\Widgets
 * @since 1.7.5
 */
class Domain_Search extends Base_Widget {

	/**
	 * Get Widget name
	 *
	 * Retrieve Domain Search widget name
	 *
	 * @return string Widget name
	 * @since  1.7.5
	 * @access public
	 *
	 */
	public function get_name() {
		return 'wdes-forms-widget';
	}

	/**
	 * Get Widget title
	 *
	 * Retrieve Domain Search widget title
	 *
	 * @return string Widget title
	 * @since  1.7.5
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Domain Search', 'phox-host' );
	}

	/**
	 * Get Widget icon
	 *
	 * Retrieve Domain Search widget icon
	 *
	 * @return string Widget icon
	 * @since  1.7.5
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'wdes-widget-elementor wdes-widget-domain';
	}


	/**
	 * Get Widget keywords
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array widget keywords.
	 * @since  1.7.5
	 * @access public
	 *
	 */
	public function get_keywords() {
		return [ 'domain', 'search', 'form' ];
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
		return [ 'wdes-psl', 'wdes-micromodal' ];
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
			'input'              => '#wdes-domain-search .domain-search-area-main .domain-form-wrapper .reg-dom',
			'main-area'          => '#wdes-domain-search .domain-search-area-main .sea-dom',
			'ext-block'          => '#wdes-domain-search .domain-search-area-main .extensions-block .block',
			'result-box'         => '#wdes-domain-search .domain-search-area-main .domain-results-box .wdes-result-domain-box',
			'result-dom'         => '#wdes-domain-search .domain-search-area-main .domain-results-box .wdes-result-domain-box .results-wdes-dom',
			'result-pur'         => '#wdes-domain-search .domain-search-area-main .domain-results-box .wdes-result-domain-box .inner-block-result-item input.wdes-purchase-btn',
			'result-aval'        => '#wdes-domain-search .domain-search-area-main .domain-results-box .wdes-result-domain-box .inner-block-result-item .wdes-available-dom',
			'result-token'       => '#wdes-domain-search .domain-search-area-main .domain-results-box .wdes-result-domain-box .inner-block-result-item .wdes-btn-token',
			'suggestion'         => '#wdes-domain-search .domain-search-area-main #wdes-dc-more-options',
			'suggestion-items'   => '#wdes-domain-search .domain-search-area-main #wdes-dc-more-options ul'
		];
		$this->start_controls_section(
			'the_domain_controls',
			['label' => esc_html__('Content', 'phox-host'), ]
		);

		$this->add_control(
			'the_placeholder_input',
			[
				'label' => esc_html__('Search Input Placeholder', 'phox-host'),
				'type'  => Controls_Manager::TEXT,
				'default' => esc_html__('example.com', 'phox-host')
			]
		);

		$this->add_control(
			'the_check_button_text',
			[
				'label' => esc_html__('Search Button Text', 'phox-host'),
				'type'  => Controls_Manager::TEXT,
				'default' => esc_html__( 'Check', 'phox-host' ),
			]
		);

		$extensions = new Repeater();


		$extensions->add_control(
			'extension_domain',
			[
				'label' => esc_html__('Extension', 'phox-host'),
				'type'  => Controls_Manager::TEXT,
				'default'   => esc_html__('Extension', 'phox-host'),
			]
		);

		$extensions->add_control(
			'upload_ext_img',
			[
				'label'     => esc_html__('Extension Logo', 'phox-host'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes'
			]
		);

		$extensions->add_control(
			'extension_domain_img',
			[
				'label' => esc_html__('Extension', 'phox-host'),
				'type'  => Controls_Manager::MEDIA,
				'condition' => [
					'upload_ext_img' => 'yes',
				],
			]
		);

		$extensions->add_control(
			'extension_price',
			[
				'label' => esc_html__('Price', 'phox-host'),
				'type'  => Controls_Manager::NUMBER,
				'default'   => esc_html__('5', 'phox-host')
			]
		);

		$extensions->add_control(
			'currency_symbol',
			[
				'label' => esc_html__( 'Currency Symbol', 'phox-host' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'None', 'phox-host' ),
					'dollar' => '&#36; ' . esc_html__( 'Dollar', 'phox-host' ),
					'euro' => '&#128; ' . esc_html__( 'Euro', 'phox-host' ),
					'baht' => '&#3647; ' . esc_html__( 'Baht', 'phox-host' ),
					'franc' => '&#8355; ' . esc_html__( 'Franc', 'phox-host' ),
					'guilder' => '&fnof; ' . esc_html__( 'Guilder', 'phox-host' ),
					'krona' => 'kr ' . esc_html__( 'Krona', 'phox-host' ),
					'lira' => '&#8356; ' . esc_html__( 'Lira', 'phox-host' ),
					'peseta' => '&#8359 ' . esc_html__( 'Peseta', 'phox-host' ),
					'peso' => '&#8369; ' . esc_html__( 'Peso', 'phox-host' ),
					'pound' => '&#163; ' . esc_html__( 'Pound Sterling', 'phox-host' ),
					'real' => 'R$ ' . esc_html__( 'Real', 'phox-host' ),
					'ruble' => '&#8381; ' . esc_html__( 'Ruble', 'phox-host' ),
					'rupee' => '&#8360; ' . esc_html__( 'Rupee', 'phox-host' ),
					'indian_rupee' => '&#8377; ' . esc_html__( 'Rupee (Indian)', 'phox-host' ),
					'shekel' => '&#8362; ' . esc_html__( 'Shekel', 'phox-host' ),
					'yen' => '&#165; ' . esc_html__( 'Yen/Yuan', 'phox-host' ),
					'won' => '&#8361; ' . esc_html__( 'Won', 'phox-host' ),
					'custom' => esc_html__( 'Custom', 'phox-host' ),
				],
				'default' => 'dollar',
			]
		);

		$extensions->add_control(
			'currency_symbol_custom',
			[
				'label' => esc_html__( 'Custom Symbol', 'phox-host' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'currency_symbol' => 'custom',
				],
			]
		);

		$extensions->add_control(
			'currency_symbol_location',
			[
				'label' => esc_html__( 'Symbol Location', 'phox-host' ),
				'type' => Controls_Manager::SELECT,
				'options'	=> [
					'left' 	=> 'Left',
					'right' => 'Right'
				],
				'default'	=> 'left'
			]
		);

		$extensions->add_control(
			'show_ext',
			[
				'label' => esc_html__( 'Show Extension', 'phox-host' ),
				'type' => Controls_Manager::SWITCHER ,
				'default'	=> 'yes'
			]
		);

		$extensions->add_control(
			'add_suggestion_list',
			[
				'label' => esc_html__( 'Add To Suggestions List', 'phox-host' ),
				'type' => Controls_Manager::SWITCHER ,
				'default'	=> 'yes'
			]
		);

		$extensions->add_control(
			'style',
			[
				'label' => esc_html__( 'Custom Style', 'phox-host' ),
				'type' => Controls_Manager::HEADING ,
				'default'	=> 'yes',
				'separator' => 'before'
			]
		);

		$extensions->add_control(
			'text_choose_styling',
			[
				'label' => esc_html__( 'Extension Text Color', 'phox-host' ),
				'type'          => Controls_Manager::CHOOSE,
				'default'       => 'color',
				'toggle'        => false,
				'options'        =>[
					'color' =>  [
						'title' =>  esc_html__('Color', 'phox-host'),
						'icon'  =>  'eicon-global-colors'
					],
					'gradient' =>  [
						'title' =>  esc_html__('Gradient', 'phox-host'),
						'icon'  =>  'eicon-barcode'
					],
				],
				'condition' =>  [
					'upload_ext_img' => '',
				]
			]
		);

		$extensions->add_control(
			'text_gradient_bg_color',
			[
				'label'         => esc_html('Color', 'phox-host'),
				'type'          => Controls_Manager::COLOR,
				'default'       => '',
				'render_type'   => 'ui',
				'condition'     => [
					'text_choose_styling' => 'gradient',
					'upload_ext_img' => '',
				],
				'of_type'   =>  'gradient'
			]
		);

		$extensions->add_control(
			'text_gradient_bg_color_stop',
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
					'text_choose_styling' => 'gradient',
					'upload_ext_img' => '',
				],
				'of_type'   =>  'gradient'
			]
		);

		$extensions->add_control(
			'text_gradient_bg_color_two',
			[
				'label'         => esc_html('Second Color', 'phox-host'),
				'type'          => Controls_Manager::COLOR,
				'default'       => '#e3e3e3',
				'render_type'   => 'ui',
				'condition'     => [
					'text_choose_styling' => 'gradient',
					'upload_ext_img' => '',
				],
				'of_type'   =>  'gradient'
			]
		);

		$extensions->add_control(
			'text_gradient_bg_color_two_stop',
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
					'text_choose_styling' => 'gradient',
					'upload_ext_img' => '',
				],
				'of_type'   =>  'gradient'
			]
		);

		$extensions->add_control(
			'text_gradient_bg_gradient_type',
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
					'text_choose_styling' => 'gradient',
					'upload_ext_img' => '',
				],
				'of_type'   =>  'gradient'
			]
		);

		$extensions->add_control(
			'text_gradient_bg_gradient_angle',
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
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{text_gradient_bg_color.VALUE}} {{text_gradient_bg_color_stop.SIZE}}{{text_gradient_bg_color_stop.UNIT}}, {{text_gradient_bg_color_two.VALUE}} {{text_gradient_bg_color_two_stop.SIZE}}{{text_gradient_bg_color_two_stop.UNIT}})',
				],
				'condition'     => [
					'text_choose_styling' => 'gradient',
					'upload_ext_img' => '',
					'text_gradient_bg_gradient_type' => 'linear',
				],
				'of_type'   =>  'gradient'
			]
		);

		$extensions->add_control(
			'text_gradient_bg_gradient_position',
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
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{text_gradient_bg_color.VALUE}} {{text_gradient_bg_color_stop.SIZE}}{{text_gradient_bg_color_stop.UNIT}}, {{text_gradient_bg_color_two.VALUE}} {{text_gradient_bg_color_two_stop.SIZE}}{{text_gradient_bg_color_two_stop.UNIT}})',
				],
				'condition'     => [
					'text_choose_styling' => 'gradient',
					'upload_ext_img' => '',
					'text_gradient_bg_gradient_type' => 'radial',
				],
				'of_type'   =>  'gradient'
			]
		);

		$extensions->add_control(
			'text_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #wdes-domain-search {{CURRENT_ITEM}} .domain-ext-name'	=>	'color: {{VALUE}} !important;',
				],
				'condition' => [
					'text_choose_styling' => 'color',
					'upload_ext_img' => '',
				]
			]
		);

		$extensions->add_control(
			'img_height',
			[
				'label'	=> esc_html__('Logo Height', 'phox-host'),
				'type'	=> Controls_Manager::NUMBER,
				'min'   => 1,
				'max'   => 100,
				'default' => 30,
				'selectors'	=>	[
					'{{WRAPPER}} {{CURRENT_ITEM}} .domain-ext-img'	=>	'height: {{VALUE}}px;'
				],
				'condition' => [
					'upload_ext_img' => 'yes',
				]
			]
		);

		$this->add_control(
			'the_extensions',
			[
				'label'  => esc_html__('Extensions', 'phox-host'),
				'type'   => Controls_Manager::REPEATER,
				'fields' => $extensions->get_controls(),
				'default' =>[
					[
						'extension_domain' => '.com'
					],
					[
						'extension_domain' => '.net'
					]
				],
				'title_field' => '{{{extension_domain}}}',
			]
		);


		$this->end_controls_section();

		/**
		 * Layouts Section
		 * It will deprecate
		 */

		$this->start_controls_section(
			'the_form_layout',
			[
				'label'	=> esc_html__('Layouts', 'phox-host'),
				'condition' => [
					'the_extension_layouts' => [ 'l-2'],
				]

			]
		);

		$this->add_control(
			'the_extension_layouts',
			[
				'label' => esc_html__('Extension Layouts', 'phox-host'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'l-1',
				'options'   => [
					'l-1' => esc_html__('Layout 1', 'phox-host'),
					'l-2' => esc_html__('Layout 2', 'phox-host')
				],
				'multiple'  => false
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'the_general_setting',
			[
				'label'	=> esc_html__('Settings', 'phox-host'),

			]
		);

		$this->add_control(
			'the_url_type',
			[
				'label' => esc_html__('URL Type', 'phox-host'),
				'type'  => Controls_Manager::SELECT,
				'options' => [
					'whmcs'  => esc_html__( 'WHMCS URL', 'phox-host' ),
					'custom' => esc_html__( 'Custom URL', 'phox-host' ),
				],
				'default' => 'whmcs',

			]
		);

		$this->add_control(
			'the_whmcs_url',
			[
				'label' => esc_html__('WHMCS URL', 'phox-host'),
				'type'  => Controls_Manager::URL,
				'condition' => [
					'the_url_type' => 'whmcs'
				]
			]
		);

		$this->add_control(
			'the_custom_url',
			[
				'label' => esc_html__('Custom URL', 'phox-host'),
				'type'  => Controls_Manager::URL,
				'condition' => [
					'the_url_type' => 'custom'
				]
			]
		);

		$this->add_control(
			'the_form_method',
			[
				'label'   => esc_html__('Form Method', 'phox-host'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'post' => esc_html__('Post', 'phox-host'),
					'get' => esc_html__('Get', 'phox-host')
				],
				'default' => 'post',
				'condition' => [
					'the_url_type' => 'custom'
				]
			]
		);

		$this->add_control(
			'the_whois_button',
			[
				'label' => esc_html__('Whois Button', 'phox-host'),
				'type'  => Controls_Manager::SWITCHER,
				'condition' => [
					'the_lookup_provider_id' => 'lup-1'
				]
			]
		);

		$this->add_control(
			'the_lookup_provider_id',
			[
				'label' => esc_html__('Lookup Provider', 'phox-host'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'lup-1',
				'options'   => [
					'lup-1' => esc_html__('Standard', 'phox-host'),
					'lup-2' => esc_html__('Godaddy', 'phox-host'),
				],
				'multiple'  => false,
				'description' => esc_html__('If you select Godaddy you must add api key/secret on admin panel first')
			]
		);

		$this->add_control(
			'general_search_in_extensions',
			[
				'label'     => esc_html__('Search Only In Extensions', 'phox-host'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes'
			]
		);

		$this->add_control(
			'general_suggestion_section_display',
			[
				'label'     => esc_html__('Show Active Suggestion Section', 'phox-host'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes'
			]
		);

		$this->add_control(
			'general_suggestion_section_title',
			[
				'label' => esc_html__('Suggestion Section Title', 'phox-host'),
				'type'  => Controls_Manager::TEXT,
				'default' => esc_html__( 'More Options', 'phox-host' ),
				'condition' => [
					'general_suggestion_section_display' => 'yes',
				]

			]
		);


		$this->end_controls_section();

		/*-- Style Tab --*/

		$this->start_controls_section(
			'search_field_section_style',
			[
				'label'	=> esc_html__('Search Field', 'phox-host'),
				'tab'		=> Controls_Manager::TAB_STYLE,

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'the_search_field_form_typo',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} '.$css_scheme['main-area'],
				'fields_options' => [
					'typography'  => [
						'default' => 'yes'
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_family' => [
						'default' => 'Poppins',
					],
				]
			]
		);

		$this->start_controls_tabs( 'the_search_field_form_tabs' );

		$this->start_controls_tab(
			'the_search_field_form_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'the_search_field_form_background',
				'selector' => '{{WRAPPER}} ' .$css_scheme['main-area']
			]
		);

		$this->add_control(
			'the_search_field_form_text_color',
			[
				'label'	=> esc_html__('Text Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['main-area']	=>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'the_search_field_form_placeholder_color',
			[
				'label'	=> esc_html__('Placeholder Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['main-area'].'::placeholder'=>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'the_search_field_form_shadow_box',
				'selector' => '{{WRAPPER}} '.$css_scheme['main-area']
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'the_search_field_form_border',
				'selector' => '{{WRAPPER}} '.$css_scheme['main-area'],
				'fields_options' =>[
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1'
						],
					],
					'color' => [
						'default' => '#eee',
					]
				]
			]
		);

		$this->add_control(
			'the_search_field_form_border_radius',
			[
				'label'	=> esc_html__('Border Radius', 'phox-host'),
				'type'	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['main-area']	=>	'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'the_search_field_form_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'the_search_field_form_background_hover',
				'selector' => '{{WRAPPER}} ' .$css_scheme['main-area'].':hover'
			]
		);

		$this->add_control(
			'the_search_field_form_text_color_hover',
			[
				'label'	=> esc_html__('Text Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['main-area'].':hover'	=>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'the_search_field_form_shadow_box_hover',
				'selector' => '{{WRAPPER}} '.$css_scheme['main-area'].':hover'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'the_search_field_form_border_hover',
				'selector' => '{{WRAPPER}} '.$css_scheme['main-area'].':hover',
				'fields_options' =>[
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1'
						],
					],
					'color' => [
						'default' => '#eee',
					]
				]
			]
		);

		$this->add_control(
			'the_search_field_form_border_radius_hover',
			[
				'label'	=> esc_html__('Border Radius', 'phox-host'),
				'type'	=> Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['main-area'].':hover'	=>	'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'the_search_field_form_tab_focus',
			[
				'label' => esc_html__( 'Focus', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'the_search_field_form_background_focus',
				'selector' => '{{WRAPPER}} ' .$css_scheme['main-area'].':focus'
			]
		);

		$this->add_control(
			'the_search_field_form_text_color_focus',
			[
				'label'	=> esc_html__('Text Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['main-area'].':focus'	=>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'the_search_field_form_shadow_box_focus',
				'selector' => '{{WRAPPER}} '.$css_scheme['main-area'].':focus'
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'the_search_field_form_border_focus',
				'selector' => '{{WRAPPER}} '.$css_scheme['main-area'].':focus',
				'fields_options' =>[
					'border' => [
						'default' => 'solid',
					],
					'width' => [
						'default' => [
							'top' => '1',
							'right' => '1',
							'bottom' => '1',
							'left' => '1'
						],
					],
					'color' => [
						'default' => '#eee',
					]
				]
			]
		);

		$this->add_control(
			'the_search_field_form_border_radius_focus',
			[
				'label'	=> esc_html__('Border Radius', 'phox-host'),
				'type'	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['main-area'].':focus'	=>	'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'the_search_button_form',
			[
				'label'	=> esc_html__('Search Button', 'phox-host'),
				'tab'		=> Controls_Manager::TAB_STYLE,

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'message_typography',
				'selector' => '{{WRAPPER}} '.$css_scheme['input'],
			]
		);

		$this->start_controls_tabs( 'the_search_button_form_tabs' );

		$this->start_controls_tab(
			'the_search_button_form_tab_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'the_search_button_background_form',
				'selector' => '{{WRAPPER}} '.$css_scheme['input'],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'the_search_button_border_width_form',
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} '.$css_scheme['input'],
			]
		);

		$this->add_control(
			'the_search_button_border_radius',
			[
				'label'	=> esc_html__('Border Radius', 'phox-host'),
				'type'	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['input'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow',
				'selector' => '{{WRAPPER}} '.$css_scheme['input'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'the_search_button_form_tab_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'the_search_button_background_form_hover',
				'selector' => '{{WRAPPER}} '.$css_scheme['input'].':hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'the_search_button_border_width_form_hover',
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} '.$css_scheme['input'].':hover',
			]
		);

		$this->add_control(
			'the_search_button_border_radius_hover',
			[
				'label'	=> esc_html__('Border Radius', 'phox-host'),
				'type'	=> Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['input'].':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow_hover',
				'selector' => '{{WRAPPER}} '.$css_scheme['input'].':hover',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'the_search_button_form_tab_focus',
			[
				'label' => esc_html__( 'Focus', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'the_search_button_background_form_focus',
				'selector' => '{{WRAPPER}} '.$css_scheme['input'].':focus',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'the_search_button_border_width_form_focus',
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} '.$css_scheme['input'].':focus',
			]
		);

		$this->add_control(
			'the_search_button_border_radius_focus',
			[
				'label'	=> esc_html__('Border Radius', 'phox-host'),
				'type'	=> Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['input'].':focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'item_box_shadow_focus',
				'selector' => '{{WRAPPER}} '.$css_scheme['input'].':focus',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		//TLDS
		$this->start_controls_section(
			'the_heading_tlds_form',
			[
				'label'	=> esc_html__('Extensions', 'phox-host'),
				'tab'		=> Controls_Manager::TAB_STYLE,

			]
		);

		$this->add_control(
			'the_heading_tlds_general',
			[
				'label'	=> esc_html__('General', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'the_tlds_ext_inline',
			[
				'label'     => esc_html__('Inline Extension', 'phox-host'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes'
			]
		);

		$this->add_responsive_control(
			'the_tlds_ext_min_width',
			[
				'label'     => esc_html__( 'Width', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'%',
				],
				'range'      => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} '.$css_scheme['ext-block'] => 'min-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'the_tlds_ext_alignment',
			[
				'label'     => __('Alignment', 'phox-host'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} #wdes-domain-search .domain-search-area-main .extensions-block'  =>  'justify-content: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'the_tlds_ext_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} '.$css_scheme['ext-block'],
			]
		);

		$this->add_control(
			'the_heading_tlds_ext',
			[
				'label'	=> esc_html__('Extension', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'the_tlds_ext_typography_form',
				'selector' => '{{WRAPPER}} '.$css_scheme['ext-block'].' .domain-ext-name',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'the_tlds_ext_background_form',
				'selector' => '{{WRAPPER}} '.$css_scheme['ext-block'].' .domain-ext-name',
			]
		);

		$this->add_control(
			'the_tlds_ext_text_color_form',
			[
				'label'	=> esc_html__('Extension Text Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['ext-block'].' .domain-ext-name'	=>	'color: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'the_tlds_ext_padding_form',
			[
				'label'      => esc_html__( 'Extension Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} '.$css_scheme['ext-block'].' .domain-ext-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} '.$css_scheme['ext-block'].' .domain-ext-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'the_heading_tlds_price',
			[
				'label'	=> esc_html__('Price', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'the_tlds_sign_text_color_form_typography',
				'label'	=> esc_html__('Sign Typography', 'phox-host'),
				'selector' => '{{WRAPPER}} '.$css_scheme['ext-block'].' .price-extention-domain-wdes .dollar-sign-wdes',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'the_tlds_price_text_color_form_typography',
				'label'	=> esc_html__('Price Typography', 'phox-host'),
				'selector' => '{{WRAPPER}} '.$css_scheme['ext-block'].' .price-extention-domain-wdes .direct-price-extention-domain-wdes',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'the_tlds_price_background_form',
				'selector' => '{{WRAPPER}} '.$css_scheme['ext-block'].' .price-extention-domain-wdes',
			]
		);

		$this->add_control(
			'the_tlds_price_text_color_form',
			[
				'label'	=> esc_html__('Price Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['ext-block'].' .price-extention-domain-wdes'	=>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'the_tlds_price_text_padding_form',
			[
				'label'      => esc_html__( 'Price Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} '.$css_scheme['ext-block'].' .price-extention-domain-wdes' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'the_tlds_price_text_as_image_form',
			[
				'label'        => esc_html__( 'Text As Image', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'phox-host' ),
				'label_off'    => esc_html__( 'Hide', 'phox-host' ),
				'return_value' => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'the_tlds_price_text_as_image_bg_form',
				'selector' => '{{WRAPPER}} '.$css_scheme['ext-block'].' .text-as-background',
				'condition' => [
					'the_tlds_price_text_as_image_form' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		//Results Section
		$this->start_controls_section(
			'the_plan_layout_results',
			[
				'label'	=> esc_html__('Results', 'phox-host'),
				'tab'		=> Controls_Manager::TAB_STYLE,

			]
		);

		//general
		$this->add_control(
			'the_forms_results_general',
			[
				'label'	=> esc_html__('General', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'the_forms_results_general_background',
				'selector' => '{{WRAPPER}} '.$css_scheme['result-box']
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'the_forms_results_general_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} '.$css_scheme['result-box'],
			]
		);

		$this->add_control(
			'the_forms_results_general_border_radius',
			[
				'label'	=> esc_html__('Border Radius', 'phox-host'),
				'type'	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-box'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'the_forms_results_general_shadow_box',
				'selector' => '{{WRAPPER}} '.$css_scheme['result-box']
			]
		);

		$this->add_responsive_control(
			'the_forms_results_general_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '  . $css_scheme['result-box'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		//text
		$this->add_control(
			'the_forms_results_text',
			[
				'label'	=> esc_html__('Text', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'the_forms_results_text_typo',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} '.$css_scheme['result-dom'],
				'fields_options' => [
					'typography'  => [
						'default' => 'yes'
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_family' => [
						'default' => 'Poppins',
					],
				]
			]
		);

		$this->add_control(
			'the_forms_results_text_typo_color',
			[
				'label'	=> esc_html__('Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-dom']	=>	'color: {{VALUE}} !important;'
				]
			]
		);

		//button
		$this->add_control(
			'the_forms_results_button',
			[
				'label'	=> esc_html__('Button', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->start_controls_tabs( 'the_forms_results_button_tabs' );

		$this->start_controls_tab(
			'available',
			[
				'label' => esc_html__( 'Available', 'phox-host' ),
			]
		);

		$this->add_control(
			'the_forms_results_button_available_background',
			[
				'label'	=> esc_html__('Background Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-pur']	=>	'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'the_forms_results_button_available_hover_background',
			[
				'label'	=> esc_html__('Hover Background Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-pur'].':hover'	=>	'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'the_forms_results_button_available_text_color',
			[
				'label'	=> esc_html__('Text Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-pur']	=>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'the_forms_results_button_available_text_typo',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} '.$css_scheme['result-pur'],
			]
		);

		$this->add_control(
			'the_forms_results_button_available_border_radius',
			[
				'label'	=> esc_html__('Border Radius', 'phox-host'),
				'type'	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-pur']	=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'the_forms_results_button_available_icon',
			[
				'label'	=> esc_html__('Available Icon', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'the_forms_results_button_available_icon_color',
			[
				'label'	=> esc_html__('Icon Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-aval']	=>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'the_forms_results_button_available_icon_x_position',
			[
				'label'	=> esc_html__('X position', 'phox-host'),
				'type'	=> Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-aval']	=>	'left: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'the_forms_results_button_available_icon_y_position',
			[
				'label'	=> esc_html__('Y position', 'phox-host'),
				'type'	=> Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-aval']	=>	'top: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'the_forms_results_button_available_icon_size',
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
					'{{WRAPPER}} '.$css_scheme['result-aval'] => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'unavailable',
			[
				'label' => esc_html__( 'Token', 'phox-host' ),
			]
		);

		$this->add_control(
			'the_forms_results_button_unavailable_background',
			[
				'label'	=> esc_html__('Background Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-token']	=>	'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'the_forms_results_button_unavailable_hover_background',
			[
				'label'	=> esc_html__('Hover Background Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-token'].':hover'	=>	'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'the_forms_results_button_unavailable_text_color',
			[
				'label'	=> esc_html__('Text Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-token']	=>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'the_forms_results_button_unavailable_text_typo',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} '.$css_scheme['result-token'],
			]
		);

		$this->add_control(
			'the_forms_results_button_unavailable_border_radius',
			[
				'label'	=> esc_html__('Border Radius', 'phox-host'),
				'type'	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-token']	=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		//Spinner
		$this->add_control(
			'the_forms_results_spinner',
			[
				'label'	=> esc_html__('Spinner', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'the_forms_results_spinner_icon',
			[
				'label'       => esc_html__( 'Icon', 'phox-host' ),
				'type'        => Controls_Manager::ICONS,
				'skin' => 'inline',
				'exclude_inline_options' => ['svg'],
				'default'     => [
					'value'   => 'fas fa-circle-notch',
					'library' => 'fa-solid',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'the_forms_results_spinner_icon_color',
			[
				'label'       => esc_html__( 'Icon Color', 'phox-host' ),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['result-box'].' .wdes-loading-results i'	=>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'the_forms_results_spinner_icon_size',
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
					'{{WRAPPER}} '.$css_scheme['result-box'].' .wdes-loading-results i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'suggestions_section_style',
			[
				'label'	=> esc_html__('Suggestions', 'phox-host'),
				'tab'		=> Controls_Manager::TAB_STYLE,

			]
		);

		$this->add_control(
			'suggestions_section_main_heading',
			[
				'label'	=> esc_html__('Main Heading', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
			]
		);


		$this->add_control(
			'suggestions_section_main_heading_color',
			[
				'label'	=> esc_html__('Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion'].' > h2'  =>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'suggestions_section_main_heading_typo',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['suggestion'] . ' > h2',
				'fields_options' => [
					'typography'  => [
						'default' => 'yes'
					],
					'font_weight' => [
						'default' => '600',
					],
					'font_family' => [
						'default' => 'Poppins',
					],
				]
			]
		);

		$this->add_responsive_control(
			'suggestions_section_main_heading_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['suggestion'] . ' > h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'suggestions_section_main_heading_alignment',
			[
				'label'     => __('Alignment', 'phox-host'),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'center',
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
					'{{WRAPPER}} ' . $css_scheme['suggestion'] . ' > h2'   =>  'justify-content: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'suggestions_section_items_general',
			[
				'label'	=> esc_html__('Items General', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'suggestions_section_item_general',
				'selector' => '{{WRAPPER}} '.$css_scheme['suggestion-items'],
			]
		);

		$this->add_responsive_control(
			'suggestions_section_item_general_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} '.$css_scheme['suggestion-items'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'suggestions_section_item_general_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '.$css_scheme['suggestion-items'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'suggestions_section_item_general_border',
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} '.$css_scheme['suggestion-items'],
			]
		);

		$this->add_control(
			'suggestions_section_item_general_border_radius',
			[
				'label'	=> esc_html__('Border Radius', 'phox-host'),
				'type'	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion-items'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'suggestions_section_item_general__shadow',
				'selector' => '{{WRAPPER}} '.$css_scheme['suggestion-items'],
			]
		);

		$this->add_control(
			'suggestions_section_item',
			[
				'label'	=> esc_html__('Item', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'suggestions_section_item_background',
				'selector' => '{{WRAPPER}} '.$css_scheme['suggestion-items'].' li',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'suggestions_section_item_border',
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} '.$css_scheme['suggestion-items'].' li',
			]
		);

		$this->add_control(
			'suggestions_section_item_border_radius',
			[
				'label'	=> esc_html__('Border Radius', 'phox-host'),
				'type'	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion-items'].' li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_responsive_control(
			'suggestions_section_item_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} '.$css_scheme['suggestion-items'].' li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'suggestions_section_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} '.$css_scheme['suggestion-items'].' li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'suggestions_section_items',
			[
				'label'	=> esc_html__('Item Text', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before',
			]
		);

		$this->add_control(
			'suggestions_section_item_text_color',
			[
				'label'	=> esc_html__('Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion-items'].' li > h5'  =>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'suggestions_section_item_text_typo',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['suggestion-items'].' li > h5',
				'fields_options' => [
					'typography'  => [
						'default' => 'yes'
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_family' => [
						'default' => 'Poppins',
					],
				]
			]
		);

		$this->add_control(
			'suggestions_section_items_price',
			[
				'label'	=> esc_html__('Items Price', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'suggestions_section_item_price_color',
			[
				'label'	=> esc_html__('Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion-items'].' li > span'  =>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'suggestions_section_item_price_typo',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['suggestion-items'] . ' li > span',
			]
		);

		$this->add_control(
                'suggestions_section_items_purchase_button',
			[
				'label'	=> esc_html__('Purchase Button', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'suggestions_section_items_purchase_button_background',
			[
				'label'	=> esc_html__('Background Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion-items'] . ' li > div input[type="submit"]'	=>	'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'suggestions_section_items_purchase_button_hover_background',
			[
				'label'	=> esc_html__('Hover Background Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion-items'].' li > div input[type="submit"]:hover'	=>	'background-color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'suggestions_section_items_purchase_button_text_color',
			[
				'label'	=> esc_html__('Text Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion-items'] . ' li > div input[type="submit"]'	=>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'suggestions_section_items_purchase_button_text_typo',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} '.$css_scheme['suggestion-items'] . ' li > div input[type="submit"]',
			]
		);

		$this->add_control(
			'suggestions_section_items_purchase_button_border_radius',
			[
				'label'	=> esc_html__('Border Radius', 'phox-host'),
				'type'	=> Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion-items'] . ' li > div input[type="submit"]'	=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'suggestions_section_items_purchase_button_icon',
			[
				'label'	=> esc_html__('Icon', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'suggestions_section_items_purchase_button_icon_color',
			[
				'label'	=> esc_html__('Icon Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion-items'] . ' li > div .wdes-available-dom'	=>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'suggestions_section_items_purchase_button_icon_x_position',
			[
				'label'	=> esc_html__('X position', 'phox-host'),
				'type'	=> Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion-items'] . ' li > div .wdes-available-dom'	=>	'left: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'suggestions_section_items_purchase_button_icon_y_position',
			[
				'label'	=> esc_html__('Y position', 'phox-host'),
				'type'	=> Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion-items'] . ' li > div .wdes-available-dom'	=>	'top: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'suggestions_section_items_purchase_button_icon_size',
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
					'{{WRAPPER}} '.$css_scheme['suggestion-items'] . ' li > div .wdes-available-dom' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'suggestions_section_items_spinner',
			[
				'label'	=> esc_html__('Spinner', 'phox-host'),
				'type'	=> Controls_Manager::HEADING,
				'separator'	=> 'before'
			]
		);

		$this->add_control(
			'suggestions_section_item_spinner_icon',
			[
				'label'       => esc_html__( 'Icon', 'phox-host' ),
				'type'        => Controls_Manager::ICONS,
				'skin' => 'inline',
				'exclude_inline_options' => ['svg'],
				'default'     => [
					'value'   => 'fas fa-circle-notch',
					'library' => 'fa-solid',
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'suggestions_section_item_spinner_color',
			[
				'label'	=> esc_html__('Color', 'phox-host'),
				'type'	=> Controls_Manager::COLOR,
				'selectors'	=>	[
					'{{WRAPPER}} '.$css_scheme['suggestion'].' .spinner i'  =>	'color: {{VALUE}};'
				]
			]
		);

		$this->add_responsive_control(
			'suggestions_section_items_spinner_icon_size',
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
					'{{WRAPPER}} '.$css_scheme['suggestion'].' .spinner i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if($settings['the_url_type'] === 'custom'){
			$url = $settings['the_custom_url']['url'];
			$method = $settings['the_form_method'];
		}else{
			$url = $settings['the_whmcs_url']['url'];
			$method = 'post';
		}

		$spinner_icon = $settings['the_forms_results_spinner_icon'];

		if( !empty( $spinner_icon['value'] ) && $spinner_icon['library'] !== 'svg' ){

			$spinner_icon =  $spinner_icon['value'];

		}else{

			$spinner_icon = '';

		}

		$suggestions_spinner_icon = $settings['suggestions_section_item_spinner_icon'];

		if( ! empty( $suggestions_spinner_icon['value'] ) && $suggestions_spinner_icon['library'] !== 'svg' ){

			$suggestions_spinner_icon =  $suggestions_spinner_icon['value'];

		}else{

			$suggestions_spinner_icon = '';

		}

		$domain_settings = [
			'spinnerIcon' =>  $spinner_icon,
			'suggestionsSpinnerIcon' => $suggestions_spinner_icon,
			'whois_button' => $settings['the_whois_button']
		];

		$method = (x_wdes()->wdes_bridge_checker())?'post': $method;

		$domain_exts = [];
		$local_exts = [];

		?>
        <div class="domain-element-wdes">
            <div id="wdes-domain-search">
                <form id="wdes-domain-form" class="domain-search-area-main" method="<?php echo esc_attr($method)?>" action="<?php echo esc_html(x_wdes()->wdes_domain_action_url( $url, $settings['the_url_type'] ))?>" data-setting="<?php esc_attr_e(json_encode($domain_settings)) ?>">
                    <div class="domain-form-wrapper">
						<?php do_action('wdes_domain_verify_code'); ?>

                        <input id="wdes-domain" class="sea-dom" type="search" name="domain" placeholder="<?php echo esc_attr(($settings['the_placeholder_input']) ? $settings['the_placeholder_input'] : '') ; ?>">
						<?php  wp_nonce_field('check-domain-nonce', 'security', true, true); ?>
                        <input type="hidden" id="wdes_lup" name="wdes_lup" value="<?php echo esc_html($settings['the_lookup_provider_id']); ?>">

                        <input id="wdes-search" class="reg-dom" type="submit" value="<?php echo esc_attr( ! empty( $settings['the_check_button_text'] ) ? $settings['the_check_button_text'] : 'Check' )?>">
                    </div>
                    <div id="dc-error-message-invalid" class="d-none">
                        <i class="fas fa-exclamation-circle"></i>
                        <p class="text-h-warning"><?php esc_html_e('Invalid domain name', 'phox-host'); ?></p>
                    </div>

                    <div id="dc-error-message-unsupported" class="d-none">
                        <i class="fas fa-exclamation-circle"></i>
                        <p class="text-h-warning"><?php esc_html_e('We are not support this extension', 'phox-host'); ?></p>
                    </div>

                    <div class="extensions-block">
						<?php foreach ($settings['the_extensions'] as $item): ?>

							<?php if( $settings['the_extension_layouts'] === 'l-1' || is_null($settings['the_extension_layouts']) ): ?>
								<?php
								if( $item['currency_symbol'] == 'custom' ){

									$symbol = $item['currency_symbol_custom'];


								}else {

									$symbol = x_wdes()->wdes_get_currency_symbol( $item['currency_symbol'] );

								}

								?>
								<?php if(!empty($item['show_ext'])): ?>
                                    <a href="#" class="block elementor-repeater-item-<?php echo esc_attr($item['_id']);?> <?php echo ($settings['the_tlds_ext_inline']) ? esc_attr('inline') : ''; ?>">
										<?php if( ! empty($item['extension_domain'])): ?>

											<?php if($item['upload_ext_img'] === 'yes'): ?>
												<?php if(!empty($item['extension_domain_img']['url'])): ?>
                                                    <img class="domain-ext-img" src="<?php echo esc_url($item['extension_domain_img']['url'])?>" alt="tld">
												<?php endif; ?>
											<?php else: ?>
												<?php if( !empty($item['extension_domain']) ): ?>
                                                    <span class="domain-ext-name"><?php echo esc_html($item['extension_domain']); ?></span>
												<?php endif; ?>
											<?php endif; ?>
											<?php $text_as_image = $settings['the_tlds_price_text_as_image_form'] === 'yes' ? 'text-as-background' : ''; ?>
                                            <div class="price-extention-domain-wdes">
												<?php if( $item['currency_symbol_location'] == 'left' ) : ?>
                                                    <span class="dollar-sign-wdes <?php echo esc_attr($text_as_image);?>"><?php echo esc_html($symbol); ?></span>
                                                    <span class="direct-price-extention-domain-wdes <?php echo esc_attr($text_as_image);?>"><?php echo esc_html($item['extension_price']); ?></span>
												<?php else : ?>
                                                    <span class="direct-price-extention-domain-wdes <?php echo esc_attr($text_as_image);?>"><?php echo esc_html($item['extension_price']); ?></span>
                                                    <span class="dollar-sign-wdes <?php echo esc_attr($text_as_image);?>">
                                                <?php echo esc_html($symbol); ?>
                                            </span>
												<?php endif; ?>
                                            </div>
										<?php endif; ?>
                                    </a>
								<?php endif; ?>
								<?php

								$remove_dot = preg_replace('/\./', '', $item['extension_domain'], 1);
								$domain_ext = preg_replace('/[0-9]/', '', $remove_dot);

								if ( !empty($item['add_suggestion_list'] ) && ! empty($settings['general_suggestion_section_display']) ) {
									$domain_exts [] = [ 'tld' => 'domain-' . $domain_ext, 'price' => $symbol.$item['extension_price'] ];
								}

								$local_exts [] = $domain_ext;

								?>
							<?php else: ?>

                                <div class="ext-dom">
									<?php if(!empty($item['extension_domain'])): ?>
                                        <span class="ext"><?php echo esc_html($item['extension_domain']) ; ?></span>
                                        <span class="ext-p">
                                    <?php
                                    if( $item['currency_symbol_location'] == 'left' ) {
	                                    if( $item['currency_symbol'] == 'custom' ){

		                                    echo esc_html( $item['currency_symbol_custom'] );

	                                    }else {

		                                    echo esc_html( x_wdes()->wdes_get_currency_symbol( $item['currency_symbol'] ) );

	                                    };

	                                    echo esc_html($item['extension_price']);
                                    }else{
	                                    echo esc_html($item['extension_price']);

	                                    if( $item['currency_symbol'] == 'custom' ){

		                                    echo esc_html( $item['currency_symbol_custom'] );

	                                    }else {

		                                    echo esc_html( x_wdes()->wdes_get_currency_symbol( $item['currency_symbol'] ) );

	                                    };

                                    }

                                    ?>
						        </span>
									<?php endif; ?>
                                </div>
							<?php endif; ?>
						<?php endforeach; ?>
                    </div>

					<?php if( $settings['general_search_in_extensions'] !== 'yes' ){ $local_exts = []; } ?>

                    <div id="preloader-resource" data-priority-tlds='<?php echo json_encode($domain_exts); ?>' data-priority-local-tlds='<?php echo json_encode($local_exts); ?>' ></div>
                    <!-- Result section-->
                    <div id="wdes-domain-results" class="domain-results-box">
                        <!-- Modal -->
                        <div id="wdesDomainWhois" class="modal micromodal-slide" aria-hidden="true">
                            <div class="modal__overlay" tabindex="-1" data-micromodal-close>
                                <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="wdesDomainWhois-title" >
                                    <header class="modal__header">
                                        <h2 class="modal__title" id="wdesDomainWhoisLabel"><?php esc_html_e('Domain Whois Lookup', 'phox-host') ?></h2>
                                        <button class="modal__close" data-micromodal-close aria-label="Close this dialog window"></button>
                                    </header>
                                    <main class="modal__content" id="wdesDomainWhois-content"></main>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--more option section-->
                    <div id="wdes-dc-more-options" class="d-none"> <h2> <?php echo esc_attr( ! empty( $settings['general_suggestion_section_title'] ) ? $settings['general_suggestion_section_title'] : 'More Options' )?> </h2> </div>
                </form>
            </div>

        </div>
		<?php

	}

}