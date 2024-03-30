<?php
namespace Phox_Host\Elementor\Base;

use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Base_widget
 *
 * An abstract class to register new Elementor widgets to the Phox. it extended the
 * Widget_Base class
 *
 * This class for all phox widgets that display in category 'phox-elements' and for not repeating
 *
 * @since  1.4.1
 * @package Phox_Host\Elementor\Base
 * @access abstract
 */
abstract class Base_Widget extends Widget_Base {

	/**
	 * Get Widget categories
	 *
	 * Retrieve the widget categories
	 *
	 * @since  1.4.1
	 * @access public
	 *
	 * @return array widget categories
	 */
	public function get_categories() {
		return [ 'phox-elements' ];
	}

	/**
	 * Render Html Block
	 *
	 * Use to check if value is set to display full html block
	 *
	 * @since  1.4.1
	 * @access public
	 * @param string $option
	 * @param string $block
	 *
	 * @return string
	 */
	public function render_html_block( $option, $block ) {

		if ( empty( $option ) ) {
			return '';
		}

		printf( $block, $option );

	}

	/**
	 * Instance Elementor
	 *
	 * @return mixed
	 * @since 1.4.5
	 */
	protected function elementor() {
		return \Elementor\Plugin::$instance;
	}

}

