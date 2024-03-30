<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Plan Layout Table Body Loop
 * 
 * This will get all fields that in the loop and translate it in layout number 4 body loop
 * 
 * @link https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.2.0
 */
class Plan_Layout_Table_Body_Loop extends \WPML_Elementor_Module_With_Items  {


    /**
     * Get Item Fields
     * 
     * @since 1.2.0
     * @return string
     */
    public function get_items_field() {

        return 'the_plans_4_body';
    }
    
    /**
     * Get Fields
     * 
     * @return array
     */
    public function get_fields() {

	    return array( 'row_head', 'body_content', 'button_title' );

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
            case 'row_head':
                return esc_html__( 'Row Head', 'phox-host' );
            case 'body_content':
                return esc_html__( 'Body Content', 'phox-host' );
            case 'button_title':
                return esc_html__( 'Button Title', 'phox-host' );
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
            case 'row_head':
                return 'LINE';
            case 'body_content':
                return 'AREA';
            case 'button_title':
                return 'LINE';
            default:
                return '';
        }
    }

}