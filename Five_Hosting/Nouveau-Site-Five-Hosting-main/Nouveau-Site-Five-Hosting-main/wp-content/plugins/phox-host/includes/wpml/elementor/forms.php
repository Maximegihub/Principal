<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Forms
 * 
 * The class that is responsible for translating the fields of the element Forms
 * 
 * @since 1.2.0
*/

class Forms extends Widget_Type {

    /**
	 * Widget Name
	 *
	 * Set the widget name that will add fields to it
	 * 
	 * @var string
	 */
    public $widget_name = 'wdes-forms-widget';


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
                    'field'       => 'the_placeholder_input',
                    'type'        => __( 'Placeholder Input', 'phox-host' ),
                    'editor_type' => 'LINE'
                ]
            ],
            'integration-class' => '\Phox_Host\Forms_Loop',
        ];
 
        return $widgets;
		
    }

    
    
}