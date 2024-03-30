<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Widget Type 
 *
 * Widget Type will compile all the fields that needs to translate and then add to wpml 
 *
 * @since 1.2.0
 * @abstract
 */

 Abstract class Widget_Type {

	/**
	 * Widget Type constructor.
	 *
	 * Add the lists of all the widget types that need to be translated to filter.
	 *
	 * @since 1.2.0
	 */
	public function __construct () {

		add_filter( 'wpml_elementor_widgets_to_translate', [ $this, 'widgets_fields' ] );

	}

	 /**
	 * Widget fields
	 *
	 * The fildes that will translation.
	 * 
	 * @param array $widgets
	 * @since 1.2.0
	 * @abstract
	 */
	abstract public function widgets_fields ( $widgets ) ;


 }