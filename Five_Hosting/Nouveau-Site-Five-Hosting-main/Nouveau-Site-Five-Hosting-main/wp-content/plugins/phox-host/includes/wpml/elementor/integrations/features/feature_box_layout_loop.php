<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Features Box Layout Loop
 * 
 * This will get all fields that in the loop and translate it in layout number 1 only
 * 
 * @see https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.2.0
 */
class Feature_Box_Layout_Loop extends \WPML_Elementor_Module_With_Items  {


    /**
     * Get Item Fields
     * 
     * @since 1.2.0
     * @return string
     */
    public function get_items_field() {

        return 'the_boxs_list';
    }
    
    /**
     * Get Fields
     * 
     * @return array
     */
    public function get_fields() {

	    return array( 'box_title', 'box_button');

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
            case 'box_title':
                return esc_html__( 'Box Title', 'phox-host' );
            case 'box_button':
                return esc_html__( 'Box Button', 'phox-host' );
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
            case 'box_title':
            case 'box_button':
                return 'LINE';
            default:
                return '';
        }

    }

}