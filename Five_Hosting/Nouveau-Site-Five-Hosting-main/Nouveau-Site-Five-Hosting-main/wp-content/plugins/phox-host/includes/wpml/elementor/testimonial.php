<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Testimonial
 * 
 * The class that is responsible for translating the fields of the element testimonial
 * 
 * @since 1.4.9
*/

class Testimonial extends Widget_Type {

    /**
	 * Widget Name
	 *
	 * Set the widget name that will add fields to it
	 * 
	 * @var string
	 */
    public $widget_name = 'wdes_testimonials';


    /**
	 * Widget fields
	 *
	 * The fildes that will translation.
	 * 
     * @since 1.4.9
	 * @param array $widgets
     * @return array $widgets
	 */
    public function widgets_fields ( $widgets ) {
		
		$widgets[ $this->widget_name ] = [
            'conditions' => [ 'widgetType' => $this->widget_name ],
            'fields'     => [],
			'integration-class' => '\Phox_Host\Testimonial_Items_Loop',
        ];
 
        return $widgets;
		
    }

    
    
}