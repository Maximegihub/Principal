<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Plan Layout One Loop
 * 
 * This will get all fields that in the loop and translate it in layout number 1 & 2 only
 * 
 * @link https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.2.0
 */
class Plan_Layout_One_Loop extends \WPML_Elementor_Module_With_Items  {


    /**
     * Get Item Fields
     * 
     * @since 1.2.0
     * @return string
     */
    public function get_items_field() {

        return 'the_plans';
    }
    
    /**
     * Get Fields
     * 
     * @return array
     */
    public function get_fields() {

	    return array( 'title', 'price', 'currency_symbol_custom', 'features_items', 'order_button');

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
            case 'title':
                return esc_html__( 'Title', 'phox-host' );
            case 'price':
                return esc_html__( 'Price', 'phox-host' );
            case 'currency_symbol_custom':
                return esc_html__( 'Currency Symbol', 'phox-host' );
            case 'features_items':
                return esc_html__( 'Features Items', 'phox-host' );
            case 'order_button':
                return esc_html__( 'Order Button', 'phox-host' );
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
            case 'title':
                return 'LINE';
            case 'price':
                return 'LINE';
            case 'currency_symbol_custom':
                return 'LINE';
            case 'features_items':
                return 'AREA';
            case 'order_button':
                return 'LINE';
            default:
                return '';
        }
    }

}