<?php
namespace Phox_Host;

if ( !defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Phox Host Pin Posts
 *
 * The Pin Posts is the feature in the blog
 *
 * @package Phox_Host
 * @since 1.0.0
 */
class Pin_Posts {

	/**
	 * Instance
	 *
	 * Holds the Pin Posts instance
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
	 * Ensures only one instance of the Pin Posts class is loaded or can loaded
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
	 * Pin Posts construction
	 *
	 * initializing Pin Posts
	 *
	 * @since  1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'wdes_add_custom_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'wdes_save_post_options' ) );
	}

	/**
	 * Add custom meta boxes.
	 *
	 * Add meta box to post for pin posts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function wdes_add_custom_meta_boxes() {
		add_meta_box(
			'wdes_pin_option',
			esc_html__( 'Phox - Pin Post', 'phox-host' ),
			array( $this, 'wdes_pin_the_posts' ),
			'post',
			'side',
			'low'
		);
	}

	/**
	 * Pin the posts.
	 *
	 * The option html template
	 *
	 * @since 1.0.0
	 * @access
	 * @param int $post_id The post id.
	 */
	public function wdes_pin_the_posts( $post_id ) {

		$data = get_option( 'wdes_posts_options' );

		if(isset($data[ $post_id->ID ])){

			$value = ( 'on' === $data[ $post_id->ID ] ) ? 1 : 0;

		}else{

			$value = 0;

		}

		echo '<p>' . esc_html__( 'Pin to Top of Page', 'phox-host' ) . '</p>';
		echo '<label class="switch">';
			echo '<input id="wdes_set_post_front" name="post_on_top" type="checkbox" ' . checked( $value, true, false ) . ' />';
			echo '<div class="slider"></div>';
		echo '</label>';

	}

	/**
	 * Save post options.
	 *
	 * Save the meta box data
	 *
	 * @since 1.0.0
	 * @access
	 * @param int $post_id The post id.
	 * @return mixed
	 */
	public function wdes_save_post_options( $post_id ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( ! empty( $_POST['post_on_top'] ) ) {
			$data = $_POST['post_on_top'];
		} else {
			$data = 'off';
		}

		$wdes_posts_options = get_option( 'wdes_posts_options' );

		$wdes_posts_options[ $post_id ] = $data;

		update_option( 'wdes_posts_options', $wdes_posts_options, 'yes' );

		wp_cache_flush();

	}

}
