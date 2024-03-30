<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Features Info Box Icon Layout Loop
 * 
 * This will get all fields that in the loop and translate it in layout number 3 only
 * 
 * @see https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.2.0
 */
class Feature_Info_Box_Icon_Layout_Loop extends \WPML_Elementor_Module_With_Items  {


    /**
     * Get Item Fields
     * 
     * @since 1.2.0
     * @return string
     */
    public function get_items_field() {

        return 'the_info_box_list_icon';
    }
    
    /**
     * Get Fields
     * 
     * @return array
     */
    public function get_fields() {

	    return array( 'info_box_title', 'info_box_desc');

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
            case 'info_box_title':
                return esc_html__( 'Info Box Title', 'phox-host' );
            case 'info_box_desc':
                return esc_html__( 'Info Box Description', 'phox-host' );
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
            case 'info_box_title':
                return 'LINE';
            case 'info_box_desc':
                return 'AREA';
            default:
                return '';
        }
    }

}