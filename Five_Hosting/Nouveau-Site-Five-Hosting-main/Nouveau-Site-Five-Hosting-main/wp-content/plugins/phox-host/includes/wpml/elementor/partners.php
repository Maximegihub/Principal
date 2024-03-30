<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Partners 
 * 
 * The class that is responsible for translating the fields of the element partners
 * 
 * @since 1.2s.0
*/

class Partners extends Widget_Type {

    /**
	 * Widget Name
	 *
	 * Set the widget name that will add fields to it
	 * 
	 * @var string
	 */
    public $widget_name = 'wdes-partner-widget';


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
            'fields'     => [],
			'integration-class' => '\Phox_Host\Partners_Loop', 
				
			
        ];
 
        return $widgets;
		
    }

    
    
}