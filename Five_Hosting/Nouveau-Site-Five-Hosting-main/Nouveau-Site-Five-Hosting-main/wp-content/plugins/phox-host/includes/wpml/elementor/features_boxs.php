<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Features Boxs
 * 
 * The class that is responsible for translating the fields of the element features boxs
 * 
 * @since 1.2.0
*/

class Features_Boxs extends Widget_Type {

    /**
	 * Widget Name
	 *
	 * Set the widget name that will add fields to it
	 * 
	 * @var string
	 */
    public $widget_name = 'wdes-features-boxs-widget';


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
					'field'       => 'the_side_feature_title',
					'type'        => __( 'Title', 'phox-host' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'the_side_feature_button_title',
					'type'        => __( 'Button Title', 'phox-host' ),
					'editor_type' => 'LINE'
				],

			],
			'integration-class' => [
				'\Phox_Host\Feature_Box_Layout_Loop',
				'\Phox_Host\Feature_Info_Box_Icon_Layout_Loop',
				'\Phox_Host\Feature_Info_Box_Layout_Loop',
				'\Phox_Host\Feature_Side_Layout_Loop'
			],
		];

        return $widgets;
		
    }


}