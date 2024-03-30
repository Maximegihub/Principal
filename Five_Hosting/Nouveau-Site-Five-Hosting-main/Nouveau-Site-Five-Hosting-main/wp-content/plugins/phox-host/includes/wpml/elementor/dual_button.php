<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Dual Button
 *
 * The class that is responsible for translating the fields of the element dual button
 *
 * @since 1.4.9
 */

class Dual_Button extends Widget_Type {

    /**
     * Widget Name
     *
     * Set the widget name that will add fields to it
     *
     * @var string
     */
    public $widget_name = 'wdes_dual_button';


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
                    'field'       => 'dual_button_label_normal',
                    'type'        => __( 'Label Text', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'dual_button_label_hover',
                    'type'        => __( 'Label Text Hover', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
            ],
        ];

        return $widgets;

    }



}