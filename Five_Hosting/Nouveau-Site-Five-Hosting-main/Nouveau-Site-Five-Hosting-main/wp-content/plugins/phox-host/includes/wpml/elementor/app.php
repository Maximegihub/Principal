<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * App
 * 
 * The class that is responsible for translating the fields of the element App
 * 
 * @since 1.2.0
*/

class App extends Widget_Type {

    /**
	 * Widget Name
	 *
	 * Set the widget name that will add fields to it
	 * 
	 * @var string
	 */
    public $widget_name = 'wdes-app-widget';


    /**
	 * Widget fields
	 *
	 * The fildes that will translation.
	 * 
	 * @param array $widgets
	 * @since 1.2.0
     * @return array $widgets
	 */
    public function widgets_fields ( $widgets ) {
		
		$widgets[ $this->widget_name ] = [
            'conditions' => [ 'widgetType' => $this->widget_name ],
            'fields'     => [
                [
                    'field'       => 'the_title',
                    'type'        => __( 'Title', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'the_desc',
                    'type'        => __( 'Description', 'phox-host' ),
                    'editor_type' => 'AREA'
                ],
            ],
        ];
 
        return $widgets;
		
    }

    
    
}