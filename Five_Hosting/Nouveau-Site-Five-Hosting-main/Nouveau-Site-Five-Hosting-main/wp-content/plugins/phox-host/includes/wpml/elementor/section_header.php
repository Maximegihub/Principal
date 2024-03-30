<?php

namespace Phox_Host;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Section Header
 * 
 * The class that is responsible for translating the fields of the element section header
 * 
 * @since 1.4.9
*/

class Section_Header extends Widget_Type {

    /**
	 * Widget Name
	 *
	 * Set the widget name that will add fields to it
	 * 
	 * @var string
	 */
    public $widget_name = 'wdes-section-header-widget';


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
                    'field'       => 'the_title',
                    'type'        => __( 'Title', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'the_description',
                    'type'        => __( 'Description', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'the_header_plans_one_controls',
                    'type'        => __( 'Heading', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'title',
                    'type'        => __( 'Title', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'title_secondary_before',
                    'type'        => __( 'Before Text', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'title_secondary_highlight',
                    'type'        => __( 'Highlight Text', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'title_secondary_after',
                    'type'        => __( 'After Text', 'phox-host' ),
                    'editor_type' => 'LINE'
                ],
                [
                    'field'       => 'description',
                    'type'        => __( 'Description', 'phox-host' ),
                    'editor_type' => 'AREA'
                ],
            ],
        ];
 
        return $widgets;
		
    }

    
    
}