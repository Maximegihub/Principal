<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Tabs Layouts Plans Loop
 * 
 * This will get all fields that in the loop and translate it in Plans Tab only
 * 
 * @link https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.2.0
 */
class Tabs_Layouts_Plans_Loop extends \WPML_Elementor_Module_With_Items  {

    /**
     * Get Item Fields
     * 
     * @since 1.2.0
     * @return string
     */
    public function get_items_field() {

        return 'the_plans_list';
    }
    
    /**
     * Get Fields
     * 
     * @return array
     */
    public function get_fields() {

	    return array( 'title_plan_list', 'features_items_plan_list', 'order_button_plan_list');

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
            case 'title_plan_list':
                return esc_html__( 'Title Plan List', 'phox-host' );
            case 'features_items_plan_list':
                return esc_html__( 'Features Items Plan List', 'phox-host' );
            case 'order_button_plan_list':
                return esc_html__( 'Order Button Plan List', 'phox-host' );
                
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
            case 'title_plan_list':
            case 'order_button_plan_list':
                return 'LINE';
            case 'features_items_plan_list':
                return 'AREA';

            default:
                return '';
        }

    }

}