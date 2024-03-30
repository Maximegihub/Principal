<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Price Table
 *
 * The class that is responsible for translating the fields of the element price table
 *
 * @since 1.4.9
 */

class Price_Table extends Widget_Type {

    /**
     * Widget Name
     *
     * Set the widget name that will add fields to it
     *
     * @var string
     */
    public $widget_name = 'wdes_price_table';


    /**
     * Widget fields
     *
     * The fildes that will translation.
     *
     * @param array $widgets
     * @since 1.4.9
     * @return array $widgets
     */
    public function widgets_fields ( $widgets ) {

        $widgets[ $this->widget_name ] = [
            'conditions' => [ 'widgetType' => $this->widget_name ],
            'fields'     => [
                [
                    'field'       => 'title',
                    'type'        => __( 'Title', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'subtitle',
                    'type'        => __( 'Subtitle', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'strip_default_title',
                    'type'        => __( 'Title', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'price',
                    'type'        => __( 'Price', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'original_price',
                    'type'        => __( 'Original Price', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'perfix',
                    'type'        => __( 'Perfix', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'suffix',
                    'type'        => __( 'Suffix', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'desc',
                    'type'        => __( 'Description', 'phox-host' ),
                    'editor_type' => 'AREA'
                ],
                [
                    'field'       => 'feature_header',
                    'type'        => __( 'Feature Header', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'button_before',
                    'type'        => __( 'Feature Header', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'button_text',
                    'type'        => __( 'Button Text', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'button_after',
                    'type'        => __( 'Text After Button', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
            ],
            'integration-class' => '\Phox_Host\Price_Table_Features_Loop'
        ];

        return $widgets;

    }



}