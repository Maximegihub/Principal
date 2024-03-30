<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * FAQ Loop
 * 
 * This will get all fields that in the loop and transaltion it
 * 
 * @see https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.2.0
 */
class FAQ_Loop extends \WPML_Elementor_Module_With_Items  {

    /**
     * Get Item Fields
     * 
     * @since 1.2.0
     * @return string
     */
    public function get_items_field() {
        return 'the_faqs';
    }
    
    /**
     * Get Fields
     * 
     * @return array
     */
    public function get_fields() {
        return array( 'question', 'answer' );
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
            case 'question':
                return esc_html__( 'Question', 'phox-host' );
            case 'answer':
                return esc_html__( 'Answer', 'phox-host' );
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
            case 'question':
                return 'LINE';	
            case 'answer':
                return 'AREA';		
            default:
                return '';
        }
    }
    
    
}