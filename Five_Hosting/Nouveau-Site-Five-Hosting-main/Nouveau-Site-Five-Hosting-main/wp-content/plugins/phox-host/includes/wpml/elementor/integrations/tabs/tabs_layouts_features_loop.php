<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Tabs Layouts Features Loop
 * 
 * This will get all fields that in the loop and translate it in layout Tab only
 * 
 * @link https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.2.0
 */
class Tabs_Layouts_Features_Loop extends \WPML_Elementor_Module_With_Items  {

    /**
     * Get Item Fields
     * 
     * @since 1.2.0
     * @return string
     */
    public function get_items_field() {

        return 'tab_items';
    }
    
    /**
     * Get Fields
     * 
     * @return array
     */
    public function get_fields() {

        return array( 'tab_label', 'tab_description','tab_editor_content');

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
            case 'tab_label':
                return esc_html__( 'Title', 'phox-host' );
            case 'tab_description':
                return esc_html__( 'Description', 'phox-host' );
            case 'tab_editor_content':
                return esc_html__( 'Content', 'phox-host' );
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
            case 'tab_label':
            case 'tab_editor_content':
                return 'LINE';
            case 'tab_description':
                return 'AREA';
            default:
                return '';
        }
    }

    
}