<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Tabs Layouts Testimonial Loop
 * 
 * This will get all fields that in the loop and translate it in Testimonial only
 * 
 * @link https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.2.0
 */
class Tabs_Layouts_Testimonial_Loop extends \WPML_Elementor_Module_With_Items  {

    /**
     * Get Item Fields
     * 
     * @since 1.2.0
     * @return string
     */
    public function get_items_field() {

        return 'the_testimonial';
    }
    
    /**
     * Get Fields
     * 
     * @return array
     */
    public function get_fields() {

	    return array( 'user_name', 'user_website', 'user_comment');

    }
    
    /**
     * Get Title
     * 
     * @since 1.2.0
     * @param string $field
     * @return string
     * 
     */
    protected function get_title( $field ) {

        switch( $field ) {
            case 'user_name':
                return esc_html__( 'User Name', 'phox-host' );
            case 'user_website':
                return esc_html__( 'User Website', 'phox-host' );
            case 'user_comment':
                return esc_html__( 'User Comment', 'phox-host' );
            default:
                return '';
        }

    }
    
    /**
     * Get Editor Type
     * 
     * @param string $field
     * 
     * @since 1.2.0
     * @return string
     */
    protected function get_editor_type( $field ) {

        switch( $field ) {
	        case 'user_name':
            case 'user_website':
            case 'user_comment':
                return 'LINE';
            default:
                return '';
        }

    }

    
}