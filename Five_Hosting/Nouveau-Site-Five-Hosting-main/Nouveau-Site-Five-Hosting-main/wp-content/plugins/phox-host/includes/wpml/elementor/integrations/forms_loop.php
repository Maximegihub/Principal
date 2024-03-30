<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Forms Loop
 * 
 * This will get all fields that in the loop and transaltion it
 * 
 * @see https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.2.0
 */
class Forms_Loop extends \WPML_Elementor_Module_With_Items  {

    /**
     * Get Item Fields
     * 
     * @since 1.2.0
     * @return string
     */
    public function get_items_field() {
        return 'the_extensions';
    }
    
    /**
     * Get Fields
     * 
     * @return array
     */
    public function get_fields() {
        return array( 'extension_domain', 'currency_symbol_custom', 'the_whmcs_url'=> array('url') );
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
            case 'extension_domain':
                return esc_html__( 'Extension Domain', 'phox-host' );
            case 'currency_symbol_custom':
                return esc_html__( 'Currency Symbol', 'phox-host' );
            case 'url':
                return esc_html__( 'WHMCS Url', 'phox-host' );
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
            case 'extension_domain':
                return 'LINE';	
            case 'currency_symbol':
                return 'LINE';	
            case 'url':
                return 'LINK';	
            default:
                return '';
        }
    }
    
    
}