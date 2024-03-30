<?php
namespace Phox_Host\Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Main Wdes Core Elementor Class
 *
 * The main class that initiates and run the plugin
 *
 * @package Elementor
 * @since 1.4.0
 */
class Core_Elementor {

	/**
	 * Elementor Dir
	 *
	 * The direction to the elementor files
	 *
	 * @since 1.4.0
	 *
	 * @var string the path to elementor dir on this plugin
	 */
	const ELEMENTOR_DIR = Phox_HOST_PATH . 'includes/elementor';


	/**
	 * Plugin construction
	 *
	 * initializing Core Element
	 *
	 * @since  1.4.0
	 * @access public
	 */
	public function __construct() {

		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ], 10 );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ],10 );

		//Register Widget Styles & Script
		add_action( 'elementor/frontend/before_register_styles', [ $this, 'widget_lib_styles' ] );
		add_action( 'elementor/frontend/before_enqueue_styles', [ $this, 'widget_styles' ] );

		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'widget_lib_scripts' ] );
		add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'widget_scripts' ] );

		//Add Shortcode
		add_shortcode( 'wdes-elementor-template', [ $this, 'elementor_template' ] );

		//icon
		add_action( 'elementor/editor/after_enqueue_styles' ,[$this, 'icons_font_style']);
		add_action( 'elementor/preview/enqueue_styles', [$this, 'icons_font_style']);

	}

	/**
	 * Register widgets
	 *
	 * Register all wdes widgets
	 *
	 * @since  1.4.0
	 * @access public
	 */
	public function register_widgets( $widget_manager ) {

		$group_widgets = [
			[
				'name'  => 'section_header',
				'class' => '\Widgets\section_header',
				'type'  => 'section_header',
			],
			[
				'name'  => 'tabs',
				'class' => '\Widgets\Tabs',
				'type'  => 'tabs',
			],
			[
				'name'  => 'price_table',
				'class' => '\Widgets\Price_Table',
				'type'  => 'price_table',
			],
			[
				'name'  => 'posts_block_list',
				'class' => '\Widgets\Posts_Block_List',
				'type'  => 'posts_block_list',
			],
			[
				'name'  => 'testimonials',
				'class' => '\Widgets\Testimonials',
				'type'  => 'testimonial',
			],
			[
				'name'  => 'dual_button',
				'class' => '\Widgets\Dual_Button',
				'type'  => 'dual_button',
			],
			[
				'name'  => 'table',
				'class' => '\Widgets\Table',
				'type'  => 'table',
			],
			[
				'name'  => 'world_map',
				'class' => '\Widgets\World_Map',
				'type'  => 'world_map',
			],
			[
				'name'  => 'domain_search',
				'class' => '\Widgets\Domain_Search',
				'type'  => 'domain_search',
			],
			[
				'name'  => 'countdown_timer',
				'class' => '\Widgets\Countdown_Timer',
				'type'  => 'Countdown_Timer',
			],
			[
				'name'  => 'site_logo',
				'class' => '\Widgets\Site_Logo',
				'type'  => 'Site_Logo',
			],
			[
				'name'  => 'site_nav_menu',
				'class' => '\Widgets\Site_Nav_Menu',
				'type'  => 'Site_Nav_Menu',
			],
			[
				'name'  => 'site_search',
				'class' => '\Widgets\Site_Search',
				'type'  => 'Site_Search',
			],
			[
				'name'  => 'map',
				'class' => '\Widgets\Map',
				'type'  => 'map',
			]
		];

		if( class_exists('WooCommerce') ){
			$group_widgets[] = [
				'name'  => 'site_woo_cart',
				'class' => '\Widgets\Site_Woo_Cart',
				'type'  => 'Site_Woo_Cart',
			];
		}

		if( class_exists('bridgeHttpRequest') ){
			$group_widgets[] = [
				'name'  => 'site_bridge_cart',
				'class' => '\Widgets\Site_Bridge_Cart',
				'type'  => 'Site_Bridge_Cart',
			];
		}

		foreach ( $group_widgets as $widget ) {

			extract( $widget ); // phpcs:disable


			if ( ! empty( $name ) && ! empty( $class ) ) {

				$file = self::ELEMENTOR_DIR . '/widgets/' . $name . '.php';

				if ( file_exists( $file ) ) {

					include_once $file;

					if ( class_exists( __NAMESPACE__ . $class ) ) {

						$class_name = __NAMESPACE__ . $class;

					} else {

						wp_die( sprintf( __( 'Elementor Widgets class "%s" not found', 'phox-host' ), $class_name ) );

					}

					$widget_manager->register_widget_type( new $class_name() );

				}
			}
		}

	}

	/**
	 * Register Controls
	 *
	 * @since 1.4.0
	 * @access public
	 */
	public function register_controls( $control_manager ) {

		$group_controls = [
			[
				'name'  => 'select_templates',
				'class' => '\Controls\Select_Templates',
				'type'  => 'select-templates',
			],
			[
				'name'  => 'animate_effect',
				'class' => '\Controls\Animate_Effect',
				'type'  => 'animate-effect',
			],
			[
				'name'  => 'animate_delay',
				'class' => '\Controls\Animate_Delay',
				'type'  => 'animate-delay',
			],
			[
				'name'  => 'animate_speed',
				'class' => '\Controls\Animate_Speed',
				'type'  => 'animate-speed',
			],
		];

		foreach ( $group_controls as $control ) {

			extract( $control );

			if ( ! empty( $name ) && ! empty( $class ) ) {

				$file = self::ELEMENTOR_DIR . '/controls/' . $name . '.php';

				if ( file_exists( $file ) ) {

					include_once $file;

					if ( class_exists( __NAMESPACE__ . $class ) ) {

						$class_name = __NAMESPACE__ . $class;

					}

					$control_manager->register_control( 'wdes-' . $type, new $class_name() );

				}
			}
		}

	}

	/**
	 * Enqueue styles
	 *
	 * Enqueue all the frontend styles
	 *
	 * @since 1.4.0
	 * @access public
	 */
	public function widget_styles() {
		//wdes custom css
		wp_enqueue_style( 'wdes-host-elementor-widgets', Phox_HOST_URI . '/assets/css/elementor-widgets.css' );
		//animate.css
		wp_enqueue_style( 'wdes-host-elementor-animate', Phox_HOST_URI . '/assets/css/libs/animate.css', [], '3.7.0' );

	}

	/**
	 * Register Styles Libraries
	 *
	 * Enqueue all the frontend styles
	 *
	 * @since 1.4.3
	 * @access public
	 */
	public function widget_lib_styles() {

		wp_register_style(
			'wdes-host-owl',
			Phox_HOST_URI . 'assets/css/libs/owl-carousel/owl.carousel.min.css',
			false,
			'2.2.3'
		);

		wp_register_style(
			'wdes-host-owl-theme',
			Phox_HOST_URI . 'assets/css/libs/owl-carousel/owl.theme.default.min.css',
			false,
			'2.2.3'
		);

	}

	/**
	 * Register Scripts Libraries
	 *
	 * @since 1.4.3
	 * @access public
	 */
	public function widget_lib_scripts(){

		wp_register_script(
			'wdes-host-owl',
			Phox_HOST_URI . '/assets/js/libs/owl.carousel.min.js',
			['jquery'],
			'2.3.4',
			true
		);

		wp_register_script(
			'wdes-jquery-tablesorter',
			Phox_HOST_URI . '/assets/js/libs/jquery.tablesorter.min.js',
			['jquery'],
			'2.31.3',
			true
		);

		wp_register_script(
			'wdes-jquery-tablesorter-filter',
			Phox_HOST_URI . '/assets/js/libs/jquery.tablesorter.widget-filter.min.js',
			['jquery'],
			'2.31.3',
			true
		);

		wp_register_script(
			'wdes-ammap-worldlow',
			Phox_HOST_URI . '/assets/js/libs/worldLow.min.js',
			['jquery'],
			'2.2.0',
			true
		);

		wp_register_script(
			'wdes-ammap',
			Phox_HOST_URI . '/assets/js/libs/ammap.js',
			['jquery'],
			'2.2.0',
			true
		);

		wp_register_script(
			'wdes-psl',
			Phox_HOST_URI . '/assets/js/libs/psl.min.js',
			['jquery'],
			'1.8.0',
			true
		);

		wp_register_script(
			'wdes-jq-countdown',
			Phox_HOST_URI . '/assets/js/libs/jquery.countdown.min.js',
			['jquery'],
			'2.2.0',
			true
		);

		wp_register_script(
			'wdes-micromodal',
			Phox_HOST_URI . '/assets/js/libs/micromodal.min.js',
			['jquery'],
			'2.2.0',
			true
		);
	}

	/**
	 * Enqueue script
	 *
	 * Enqueue all the frontend script
	 *
	 * @since 1.4.3
	 * @access public
	 */
	public function widget_scripts(){

		wp_enqueue_script( 'wdes-host-elementor-widgets', Phox_HOST_URI . '/assets/js/elementor-widgets.js', [ 'jquery', 'elementor-frontend' ], Phox_HOST_VERSION );

	}

	/**
	 * Enqueue icons style
	 */
	public function icons_font_style(){
		wp_enqueue_style( 'wdes-host-elementor-widgets-icons', Phox_HOST_URI . '/assets/css/elementor-widgets-icons.css', [], Phox_HOST_VERSION );
	}

	/**
	 * Elementor Instance
	 *
	 * @since 1.4.0
	 * @access public
	 */
	public function elementor_instance() {
		return \Elementor\Plugin::instance();

	}


	/**
	 * Add Template
	 *
	 * @since 1.4.0
	 * @access public
	 */
	public function elementor_template( $attr ) {

		if ( ! class_exists( '\Elementor\Plugin' ) ) {
			return '';
		}
		if ( ! isset( $attr['id'] ) || empty( $attr['id'] ) ) {
			return '';
		}

		$post_id  = $attr['id'];
		$response = $this->elementor_instance()->frontend->get_builder_content_for_display( $post_id );
		return $response;

	}



}
