<?php
namespace Phox_Host;


use Phox_Host\Elementor\Functions\Domain_Class;
use Phox_Host\Elementor\Functions\Woo_Handler;

if ( !defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Phox Host Plugin
 *
 * The main plugin handler class is responsible for initializing Phox Host
 *
 * @package Phox_Host
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * Holds the plugin instance
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
	public static $instance = null;


	/**
	 * Instance
	 *
	 * Ensures only one instance of the plugin class is loaded or can loaded
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return Plugin An instance of the class
	 */
	public static function instance(){
		if( is_null (self::$instance) ){

			self::$instance = new self();

		}
	}

	/**
	 * Shear Button
	 *
	 * Holds the share button
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Share_Button
	 */
	public $share_button;

	/**
	 * Author Profile
	 *
	 * Holds the seo options
	 *
	 * @since 1.3.0
	 * @access public
	 *
	 * @var Author_Profile
	 */
	public $author_profile;

	/**
	 * Pin Posts
	 *
	 * Holds the pin posts
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var Pin_Posts
	 */
	public $pin_posts;

	/**
	 * Wpml Elementor
	 *
	 * Holds the wpml elementor
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @var Init_Wpml_Elementor
	 */
	public $wpml_elementor;


	/**
	 * Register Widgets
	 *
	 * Holds the register widgets
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @var register_widgets
	 */
	public $register_widgets;

	/**
	 * Core_Elementor
	 *
	 * Holds the core elementor
	 *
	 * @since 1.4.0
	 * @access public
	 *
	 * @var Core_Elementor
	 */
	public $core_elementor;

	/**
	 * Post_Type
	 *
	 * Holds the builder post type
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @var Post_Type
	 */
	public $theme_builder;

	/**
	 * Plugin construction
	 *
	 * initializing Phox Host plugin
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function __construct() {

		$this->register_autoloader();

		add_action('init', [$this, 'init']);

		$this->init_classes();

	}

	/**
	 * Init
	 *
	 * Initialize Phox Host Plugin
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init(){

		$this->init_components();

	}


	/**
	 * Init components
	 *
	 * Initialize Phox Host components
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function init_components(){

		$this->share_button  = new Share_Button();

		$this->author_profile  = new Author_Profile();

		if(is_admin()){
			$this->pin_posts = new Pin_Posts();
		}

		//Check if wpml is active
		if ( function_exists('icl_object_id') ) {
			$this->wpml_elementor = new Init_Wpml_Elementor();
		}

		//Check if Elementor installed and activation
		if ( did_action( 'elementor/loaded' ) ) {
			$this->core_elementor = new Elementor\Core_Elementor();
			Domain_Class::instance();
			Woo_Handler::get_instance();
		}

		
	}

	/**
	 * Register Autoloader
	 *
	 * Phox Host Autoloader loads all the classes needed to run the plugin
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function register_autoloader(){

		require  Phox_HOST_PATH . '/includes/autoload.php';

		Autoloader::run();

	}

	/**
	 * init classes
	 *
	 * Initialize class before wordpress init action
	 *
	 * @since 2.0.0
	 * @access private
	 */
	private function init_classes(){

		$this->register_widgets = new Init_Widgets();

		$this->theme_builder = new Builder\Post_Type();

	}


}

//run the instance
Plugin::instance();