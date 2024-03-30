<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Price Table Features Loop
 *
 * This will get all fields that in the loop and translate it in layout Tab only
 *
 * @link https://wpml.org/documentation/plugins-compatibility/elementor/how-to-add-wpml-support-to-custom-elementor-widgets/
 * @since 1.4.9
 */
class Price_Table_Features_Loop extends \WPML_Elementor_Module_With_Items  {

    /**
     * Get Item Fields
     *
     * @since 1.4.9
     * @return string
     */
    public function get_items_field() {

        return 'feature_items';
    }

    /**
     * Get Fields
     *
     * @since 1.4.9
     * @return array
     */
    public function get_fields() {

        return array( 'item_title');

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
                return 'LINE';
            default:
                return '';
        }
    }


}