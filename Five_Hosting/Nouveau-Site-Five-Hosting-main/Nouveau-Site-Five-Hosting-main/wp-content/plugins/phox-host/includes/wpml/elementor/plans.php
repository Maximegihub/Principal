<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Plans 
 * 
 * The class that is responsible for translating the fields of the element plans
 * 
 * @since 1.2.0
*/

class Plans extends Widget_Type {

    /**
	 * Widget Name
	 *
	 * Set the widget name that will add fields to it
	 * 
	 * @var string
	 */
    public $widget_name = 'wdes-plan-widget';


    /**
	 * Widget fields
	 *
	 * The fields that will translation.
	 * 
     * @since 1.2.0
     * @see Plan_Layout_One_Loop
     * @see Plan_Layout_Two_Loop
     * @see Plan_Layout_Table_Head_Loop
     * @see Plan_Layout_Table_Body_Loop
     * @see Plan_Layout_Table_Foot_Loop
	 * @param array $widgets
     * @return array $widgets
	 */
    public function widgets_fields ( $widgets ) {
		
		$widgets[ $this->widget_name ] = [
            'conditions' => [ 'widgetType' => $this->widget_name ],
            'fields'     => [],
			'integration-class' => [
				'\Phox_Host\Plan_Layout_One_Loop',
				'\Phox_Host\Plan_Layout_Two_Loop',
				'\Phox_Host\Plan_Layout_Table_Head_Loop',
				'\Phox_Host\Plan_Layout_Table_Body_Loop',
				'\Phox_Host\Plan_Layout_Table_Foot_Loop'
			],

        ];
 
        return $widgets;
		
    }

    
    
}