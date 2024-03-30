<?php
namespace Phox_Host\Elementor\Base;

use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit; //Exit if assessed directly
}

/**
 * Base_Builder_widget
 *
 * An abstract class to register new Elementor widgets for builder category to the Phox. it extended the
 * Base_Widget class
 *
 * This class for all phox widgets that display in category 'phox-site-builder' and for not repeating
 *
 * @since  2.0.0
 * @package Phox_Host\Elementor\Base
 * @access abstract
 */
abstract class Base_Builder_Widget extends Base_Widget {

    /**
     * Get Widget categories
     *
     * Retrieve the widget categories
     *
     * @since  2.0.0
     * @access public
     *
     * @return array widget categories
     */
    public function get_categories() {
        return [ 'phox-site-builder' ];
    }

}
