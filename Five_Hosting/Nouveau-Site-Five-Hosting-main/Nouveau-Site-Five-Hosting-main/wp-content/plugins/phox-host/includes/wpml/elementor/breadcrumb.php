<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Breadcrumb
 * 
 * The class that is responsible for translating the fields of the element Breadcrumb
 * 
 * @since 1.2.0
*/

class Breadcrumb extends Widget_Type {

    /**
	 * Widget Name
	 *
	 * Set the widget name that will add fields to it
	 * 
	 * @var string
	 */
    public $widget_name = 'wdes-breadcrumb-widget';


    /**
	 * Widget fields
	 *
	 * The fildes that will translation.
	 * 
     * @since 1.2.0
	 * @param array $widgets
     * @return array $widgets
	 */
    public function widgets_fields ( $widgets ) {
		
		$widgets[ $this->widget_name ] = [
            'conditions' => [ 'widgetType' => $this->widget_name ],
            'fields'     => [
                [
                    'field'       => 'the_bread_title',
                    'type'        => __( 'Breadcrumb Title', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'the_bread_desc',
                    'type'        => __( 'Breadcrumb Description', 'phox-host' ),
                    'editor_type' => 'AREA'
                ]
            ],
            'integration-class' => '\Phox_Host\Breadcrumb_Loop',
        ];
 
        return $widgets;
		
    }

    
    
}