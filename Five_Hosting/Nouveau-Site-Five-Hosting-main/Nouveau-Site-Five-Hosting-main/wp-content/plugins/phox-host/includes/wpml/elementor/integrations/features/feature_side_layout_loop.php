<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Features Side Layout Loop
 * 
 * This will get all fields that in the loop and translate it in layout number 4 only
 * 
 * @see https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.2.0
 */
class Feature_Side_Layout_Loop extends \WPML_Elementor_Module_With_Items  {


    /**
     * Get Item Fields
     * 
     * @since 1.2.0
     * @return string
     */
    public function get_items_field() {

        return 'the_side_feature_item';
    }
    
    /**
     * Get Fields
     * 
     * @return array
     */
    public function get_fields() {

	    return array( 'item_content');

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
	        case 'item_content':
		        return esc_html__( 'Item Content', 'phox-host' );
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
	        case 'item_content':
		        return 'LINE';
            default:
                return '';
        }

    }

}