<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Testimonial Items Loop
 *
 * This will get all fields that in the loop and translate it in layout Tab only
 *
 * @link https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.4.9
 */
class Testimonial_Items_Loop extends \WPML_Elementor_Module_With_Items  {

    /**
     * Get Item Fields
     *
     * @since 1.4.9
     * @return string
     */
    public function get_items_field() {

        return 'item_list';
    }

    /**
     * Get Fields
     *
     * @return array
     */
    public function get_fields() {

        return array( 'item_title', 'item_comment','item_name', 'item_position');

    }

    /**
     * Get Title
     *
     * @since 1.4.9
     * @param string $field
     * @return string
     *
     */
    protected function get_title( $field ) {

        switch( $field ) {
            case 'item_title':
                return esc_html__( 'Title', 'phox-host' );
            case 'item_comment':
                return esc_html__( 'Comment', 'phox-host' );
            case 'item_name':
                return esc_html__( 'Name', 'phox-host' );
            case 'item_position':
                return esc_html__( 'Position', 'phox-host' );
            default:
                return '';
        }


    }

    /**
     * Get Editor Type
     *
     * @param string $field
     *
     * @since 1.4.9
     * @return string
     */
    protected function get_editor_type( $field ) {
        switch( $field ) {
            case 'item_title':
            case 'item_name':
            case 'item_position':
                return 'LINE';
            case 'item_comment':
                return 'AREA';
            default:
                return '';
        }
    }


}