<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Partners Loop
 * 
 * This will get all fields that in the loop and transaltion it
 * 
 * @see https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.2.0
 */
class Partners_Loop extends \WPML_Elementor_Module_With_Items  {

    /**
     * Get Item Fields
     * 
     * @since 1.2.0
     * @return string
     */
    public function get_items_field() {
        return 'the_partners_list';
    }
    
    /**
     * Get Fields
     * 
     * @return array
     */
    public function get_fields() {
        return array( 'partner_name' );
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
            case 'partner_name':
                return esc_html__( 'Partner Name', 'phox-host' );
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
            case 'partner_name':
                return 'LINE';	
            default:
                return '';
        }
    }
    
    
}