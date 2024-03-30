<?php
namespace Phox_Host;

if ( !defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}


/**
 * Phox Host Init Widgets
 *
 * All widgets will initializing and register here
 *
 * @package Phox_Host
 * @since 1.0.0
 */
class Init_Widgets{

	/**
	 * Instance
	 *
	 * Holds the Init Widgets instance
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
	protected static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the Init Widgets class is loaded or can loaded
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return Plugin An instance of the class
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;

	}

	/**
	 * Init Widgets construction
	 *
	 * Init Widgets Pin Posts
	 *
	 * @since  1.0.0
	 * @access Public
	 */
	public function __construct() {

		$this->load_files();

		add_action( 'widgets_init', array( $this, 'register_widgets' ) );


	}

	/**
	 * Load Widget File.
	 *
	 * require all widget files
	 *
	 * @since  1.0.0
	 * @access Public
	 */
	public function load_files(){

		require  Phox_HOST_PATH . '/includes/widgets/widget-about.php';
		require  Phox_HOST_PATH . '/includes/widgets/widget-newsletter.php';
		require  Phox_HOST_PATH . '/includes/widgets/widget-posts.php';
		require  Phox_HOST_PATH . '/includes/widgets/widget-ads.php';
		require  Phox_HOST_PATH . '/includes/widgets/widget-social.php';
		require  Phox_HOST_PATH . '/includes/widgets/widget-callaction.php';


	}


	/**
	 * Register Widgets.
	 *
	 * it will register the widget by use register_widget function
	 *
	 * @since  1.0.0
	 * @access Public
	 */
	public function register_widgets() {

		register_widget( 'Wdes_About' );
		register_widget( 'Wdes_Newsletter' );
		register_widget( 'Wdes_Posts' );
		register_widget( 'Wdes_Ads' );
		register_widget( 'Wdes_Social' );
		register_widget( 'Wdes_Call_To_Action' );

	}


}