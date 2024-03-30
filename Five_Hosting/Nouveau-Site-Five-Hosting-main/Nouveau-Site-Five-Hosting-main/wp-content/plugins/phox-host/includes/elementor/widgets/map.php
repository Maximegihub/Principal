<?php

namespace Phox_Host\Elementor\Widgets;

if (!defined('ABSPATH')) {
    exit; //Exit if assessed directly
}

use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Utils;
use Phox\helpers as Helper;
use Phox_Host\Elementor\Base\Base_Widget;
use Phox_Host\Elementor\Functions\Map_Styles;

/**
 * Map widget.
 *
 * Map widget that will display in Phox category
 *
 * @package Elementor\Widgets
 * @since 1.6.8
 */
class Map extends Base_Widget {

    /**
     * Map_Styles Trait
     * @since  1.6.8
     * @see Map_Styles
     */
    use Map_Styles;

    /**
     * Get Widget name
     *
     * Retrieve Map widget name
     *
     * @return string Widget name
     * @since  1.6.8
     * @access public
     *
     */
    public function get_name() {
        return 'wdes_map';
    }

    /**
     * Get Widget Title
     *
     * Retrieve Map widget title
     *
     * @return string Widget title
     * @since  1.6.8
     * @access public
     *
     */
    public function get_title() {
        return __( 'Map', 'phox-host' );
    }

    /**
     * Get Widget icon
     *
     * Retrieve Map widget icon
     *
     * @return string Widget icon
     * @since  1.6.8
     * @access public
     *
     */
    public function get_icon() {
        return 'wdes-widget-elementor wdes-widget-map';
    }


    /**
     * Get Widget keywords
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array widget keywords.
     * @since  1.6.8
     * @access public
     */
    public function get_keywords() {
        return [ 'map', 'google' ];
    }

    /**
     * Register Widget widget controls
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.6.8
     * @access protected
     */
    protected function register_controls() {

        $this->start_controls_section(
            'section_map_general_settings',
            [
                'label' => esc_html__( 'General Settings', 'phox-host' ),
            ]
        );

        $key = wdes_opts_get('google_maps_api_key');

        if ( ! $this->get_api_key() ) {

            $this->add_control(
                'set_key',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw'  => esc_html__( 'Please set Google maps API key on theme admin panel before using this widget. Paste created key ', 'phox-host' )
                ]
            );
        }

        $this->add_control(
            'section_map_general_settings_type_heading',
            [
                'label'	=> esc_html__('Map Type', 'phox-host'),
                'type'	=> Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'map_center_type',
            [
                'label'   => esc_html__( 'Map center type', 'phox-host' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'address',
                'options' => [
                    'coordinates' => esc_html__( 'Coordinates', 'phox-host' ),
                    'address' => esc_html__( 'Address', 'phox-host' )
                ],
            ]
        );

        $this->add_control(
            'map_center_lat_lng',
            array(
                'label'       => esc_html__( 'Map Center Coordinates', 'phox-host' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '35.658816, 139.745422',
                'default'     => '35.658816, 139.745422',
                'label_block' => true,
                'dynamic'     => array( 'active' => true ),
                'condition'   => array(
                    'map_center_type' => 'coordinates',
                ),
            )
        );

        $this->add_control(
            'map_center',
            array(
                'label'       => esc_html__( 'Map Center Address', 'phox-host' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => 'Shibakoen, 4 Chome−2−8 Tokyo Tower',
                'default'     => 'Shibakoen, 4 Chome−2−8 Tokyo Tower',
                'label_block' => true,
                'dynamic'     => array( 'active' => true ),
                'condition'   => array(
                    'map_center_type' => 'address',
                ),
            )
        );

        $this->add_control(
            'section_map_general_settings_zoom_heading',
            [
                'label'	=> esc_html__('Zoom', 'phox-host'),
                'type'	=> Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'zoom_start_value',
            [
                'label'      => esc_html__( 'Start', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'default'    => [
                    'unit' => 'zoom',
                    'size' => 12,
                ],
                'range'      => [
                    'zoom' => [
                        'min' => 1,
                        'max' => 18,
                    ],
                ]
            ]
        );

        $this->add_control(
            'zoom_scrollwheel',
            [
                'label'   => esc_html__( 'Scrollwheel', 'phox-host' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => '',
                'return_value' => 'true'
            ]
        );

        $this->add_control(
            'zoom_controls',
            [
                'label'   => esc_html__( 'Controls', 'phox-host' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'true',
                'return_value' => 'true'
            ]
        );

        $this->add_control(
            'section_map_general_settings_controls_heading',
            [
                'label'	=> esc_html__('Controls', 'phox-host'),
                'type'	=> Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'fullscreen_control',
            [
                'label'   => esc_html__( 'Fullscreen ', 'phox-host' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'true',
                'return_value' => 'true'
            ]
        );

        $this->add_control(
            'street_view',
            [
                'label'   => esc_html__( 'Street View', 'phox-host' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'true',
                'return_value' => 'true'
            ]
        );

        $this->add_control(
            'map_type',
            array(
                'label'   => esc_html__( 'Map Type Controls (Map/Satellite)', 'phox-host' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'true',
                'return_value' => 'true'
            )
        );

        $this->add_control(
            'drggable',
            array(
                'label'   => esc_html__( 'Draggable', 'phox-host' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'true',
                'return_value' => 'true'
            )
        );

        $this->add_control(
            'section_map_general_settings_style_heading',
            [
                'label'	=> esc_html__('Styles', 'phox-host'),
                'type'	=> Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'map_style',
            [
                'label'       => esc_html__( 'Map Style', 'phox-host' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'default',
                'options'     => [
                    'default'   => 'Default',
                    'silver'    => esc_html__( 'Silver', 'phox-host' ),
                    'retro'     => esc_html__( 'Retro', 'phox-host' ),
                    'dark'      => esc_html__( 'Dark', 'phox-host' ),
                    'night'     => esc_html__( 'Night', 'phox-host' ),
                    'aubergine' => esc_html__( 'Aubergine', 'phox-host' ),
                    'custom'    => 'Custom'
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'custom_map_style_json',
            [
                'label'     => esc_html__( 'Custom Style JSON', 'phox-host' ),
                'type'      => Controls_Manager::TEXTAREA,
                'rows'      => 10,
                'condition' => [
                    'map_style' => 'custom',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_map_markers',
            [
                'label' => esc_html__( 'Markers', 'phox-host' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'marker_address_type',
            [
                'label'   => esc_html__( 'marker Address Type', 'phox-host' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'address',
                'options' => [
                    'coordinates' => esc_html__( 'Coordinates', 'phox-host' ),
                    'address' => esc_html__( 'Address', 'phox-host' )
                ],
            ]
        );

        $repeater->add_control(
            'marker_address_lat_lng',
            [
                'label'       => esc_html__( 'marker Coordinates', 'phox-host' ),
                'description' => esc_html__( 'To get marker Address from latitude and longitude coordinates from one meta field, combine coordinates names with the ";" sign. For example: lat;lng. Where latitude always goes first. The latitude value range is from -90 to 90. The longitude value outside range is from -180 to 180.', 'phox-host' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => '35.658816, 139.745422',
                'default'     => '35.658816, 139.745422',
                'label_block' => true,
                'dynamic'     => ['active' => true],
                'condition'   => [
                    'marker_address_type' => 'coordinates',
                ],
            ]
        );


        $repeater->add_control(
            'marker_address',
            [
                'label'       => esc_html__( 'marker Address', 'phox-host' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => 'Shibakoen, 4 Chome−2−8 Tokyo Tower',
                'default'     => 'Shibakoen, 4 Chome−2−8 Tokyo Tower',
                'label_block' => true,
                'dynamic'     => ['active' => true],
                'condition'   => [
                    'marker_address_type' => 'address',
                ],
            ]
        );

        $repeater->add_control(
            'marker_state',
            [
                'label'   => esc_html__( 'Description State', 'phox-host' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'visible',
                'return_value' => 'visible'
            ]
        );

        $repeater->add_control(
            'marker_desc',
            [
                'label'   => esc_html__( 'marker Description', 'phox-host' ),
                'type'    => Controls_Manager::WYSIWYG,
                'default' => 'Shibakoen, 4 Chome−2−8 Tokyo Tower',
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'marker_image',
            [
                'label' => esc_html__( 'marker Icon', 'phox-host' ),
                'type'  => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'marker_custom_size',
            [
                'label'        => esc_html__( 'marker Icon Custom Size', 'phox-host' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'phox-host' ),
                'label_off'    => esc_html__( 'No', 'phox-host' ),
                'return_value' => 'true',
                'default'      => false,
                'condition'    => [
                    'marker_image[url]!' => '',
                ],
            ]
        );

        $repeater->add_control(
            'marker_icon_width',
            [
                'label'      => esc_html__( 'Width', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default'    => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'range'      => [
                    'px' => [
                        'min'  => 1,
                        'max'  => 200,
                        'step' => 1,
                    ],
                ],
                'condition'   => [
                    'marker_custom_size' => 'true',
                    'marker_image[url]!' => '',
                ],
            ]
        );

        $repeater->add_control(
            'marker_icon_height',
            [
                'label'      => esc_html__( 'Height', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'default'    => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'condition'   => [
                    'marker_custom_size' => 'true',
                    'marker_image[url]!' => '',
                ],
                'separator' => 'after',
            ]
        );


        $this->add_control(
            'markers',
            array(
                'type'    => Controls_Manager::REPEATER,
                'fields'  => $repeater->get_controls(),
                'default' => array(
                    array(
                        'marker_address'         => 'Shibakoen, 4 Chome−2−8 Tokyo Tower',
                        'marker_address_lat_lng' => '35.658816, 139.745422',
                        'marker_desc'            => esc_html__( 'Shibakoen, 4 Chome−2−8 Tokyo Tower', 'phox-host' ),
                        'marker_state'           => 'visible',
                    ),
                ),
                'title_field' => '<# if ( "address" === marker_address_type ){ #> {{{ marker_address }}} <# } else if ( "coordinates" === marker_address_type) { #> {{{ marker_address_lat_lng }}} <# } #>',
            )
        );

        $this->end_controls_section();

        /**
         * Style Section
         */

        $this->start_controls_section(
            'section_general_style',
            array(
                'label'      => esc_html__( 'marker', 'phox-host' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_responsive_control(
            'map_height',
            array(
                'label'       => esc_html__( 'Map Height', 'phox-host' ),
                'type'        => Controls_Manager::NUMBER,
                'min'         => 50,
                'default'     => 300,
                'render_type' => 'template',
                'selectors' => array(
                    '{{WRAPPER}} .wdes-map' => 'height: {{VALUE}}px',
                ),
            )
        );

        $this->add_control(
            'marker_width',
            array(
                'label'      => esc_html__( 'Marker Width', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 400,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .gm-style .gm-style-iw-c' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
                ),
                'dynamic'   => array( 'active' => true ),
            )
        );

        $this->end_controls_section();

    }

    /**
     * Render button widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.6.8
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        $map_center_type = $settings['map_center_type'] ?? 'coordinates';

        $api_key = $this->get_api_key();

        if( $api_key ){

            if ( $map_center_type === 'address' ) {

                $map_center = $settings['map_center'];

                if ( empty( $map_center ) ) {
                    return;
                }

                $coordinates = $this->convert_address( $map_center, $api_key );

                if ( ! $coordinates ) {
                    return;
                }
            }else{

                $center_lat_lng = $settings['map_center_lat_lng'];

                if ( empty( $center_lat_lng  ) ) {

                    echo $this->map_error_message( 1 );
                    return;
                }

                $coordinates = $this->split_coordinate( $center_lat_lng );

            }

        }else{

            echo $this->map_error_message( 2, '' );
            return;
        }

        $scroll_ctrl     = $settings['zoom_scrollwheel'] ?? '';
        $zoom_ctrl       = $settings['zoom_controls'] ?? '';
        $fullscreen_ctrl = $settings['fullscreen_control'] ?? '';
        $streetview_ctrl = $settings['street_view'] ?? '';
        $map_type = $settings['map_type'] ?? '';



        $init = [
            'center'     => $coordinates,
            'zoom'  => isset( $settings['zoom_start_value']['size'] ) ? intval( $settings['zoom_start_value']['size'] ) : 11,
            'scrollwheel'       => Helper::check_var_true($scroll_ctrl),
            'zoomControl'       => Helper::check_var_true($zoom_ctrl),
            'fullscreenControl' => Helper::check_var_true($fullscreen_ctrl),
            'streetViewControl' => Helper::check_var_true($streetview_ctrl),
            'mapTypeControl'    =>  Helper::check_var_true($map_type),
        ];

	    if ( 'true' !== $settings['drggable'] ) {
		    $init['gestureHandling'] = 'none';
	    }

        if ( ! in_array( $settings['map_style'], array( 'default', 'custom' ) ) ) {
            $init['styles'] = json_decode( $this->get_map_style( $settings['map_style'] ) );
        }

        if ( 'custom' === $settings['map_style'] && ! empty( $settings['custom_map_style_json'] ) ) {
            $init['styles'] = json_decode( $settings['custom_map_style_json'] );
        }

        $option_json = json_encode( $init ) ;

        $data_options = 'data-map-options='.esc_attr( $option_json );

        //Marker
        $markers = [];

        if ( ! empty( $settings['markers'] ) ) {

            foreach ( $settings['markers'] as $marker ) {

                $marker_center_type = $marker['marker_address_type'] ?? 'coordinates';

                if ( $marker_center_type === 'address' ) {

                    $marker_address = $marker['marker_address'];

                    if ( empty( $marker_address ) ) {
                        return;
                    }

                    $position = $this->convert_address( $marker_address, $api_key );

                    if ( ! $position ) {
                        return;
                    }

                }else{

                    $marker_lat_lng = $marker['marker_address_lat_lng'];

                    if ( empty( $marker_lat_lng  ) ) {

                        echo $this->map_error_message( 1 );
                        return;
                    }

                    $position = $this->split_coordinate( $marker_lat_lng );

                    if ( ! $position ) {
                        return;
                    }

                }

                $current_marker = array(
                    'position' => $position,
                    'desc'     => $marker['marker_desc'],
                    'state'    => $marker['marker_state'],
                );

                if ( ! empty( $marker['marker_image']['url'] ) ) {
                    $current_marker['image'] = esc_url( $marker['marker_image']['url'] );

                    if ( 'true' === $marker['marker_custom_size'] && ! empty( $marker['marker_icon_width']['size'] ) && ! empty( $marker['marker_icon_height']['size'] ) ) {
                        $current_marker['image_width']  = $marker['marker_icon_width']['size'];
                        $current_marker['image_height'] = $marker['marker_icon_height']['size'];
                    }
                }

                $markers[] = $current_marker;

            }
        }

        $markers_json = json_encode( $markers );

        $data_markers = 'data-map-markers="'.esc_attr($markers_json) .'"' ;

        printf( '<div class="wdes-map" %1$s %2$s></div>', $data_options, $data_markers );


    }


    /**
     * Convert address to latitude & longitude
     *
     * @since 1.6.8
     * @param $location
     * @param $api_key
     * @return mixed|void
     */
    public function convert_address( $location, $api_key ){

        $google_url = 'https://maps.googleapis.com/maps/api/geocode/json';

        $key = md5( $location );

        $coord = get_transient( $key );

        if ( ! empty( $coord ) ) {
            return $coord;
        }

        $location = esc_attr( $location );
        $api_key  = esc_attr( $api_key );

        $reques_url = esc_url( add_query_arg(
            [
                'address' => urlencode( $location ),
                'key'     => urlencode( $api_key )
            ],
            $google_url
        ) );

        $reques_url = str_replace( '&#038;', '&', $reques_url );

        $response = wp_remote_get( $reques_url );
        $json     = wp_remote_retrieve_body( $response );
        $data     = json_decode( $json, true );

        $coord = $data['results'][0]['geometry']['location'] ?? false;

        if ( ! $coord ) {

            echo $this->map_error_message( 1, 'Coordinates of this location not found' );

            return;

        } else {

            set_transient( $key, $coord, WEEK_IN_SECONDS );

            return $coord;

        }

    }

    /**
     * Split coordinate to latitude & longitude
     *
     * @since 1.6.8
     * @param $raw_lat_lng
     * @return array|void
     */
    public function split_coordinate( $raw_lat_lng ){

        $lat_lng = explode( ',', $raw_lat_lng );

        if ( isset( $lat_lng[0] ) && $lat_lng[0] !== '' && !ctype_space( $lat_lng[0] ) && isset( $lat_lng[1] ) && $lat_lng[1] !== '' && !ctype_space( $lat_lng[1] ) ) {
            $lat = floatval( str_replace( ',', '.', preg_replace('/\s+/', '', $lat_lng[0] ) ) );
            $lng = floatval( str_replace( ',', '.', preg_replace('/\s+/', '', $lat_lng[1] ) ) );

            if ( $lat > 90 || $lat < -90 ) {

                echo $this->map_error_message( 3 );
                return;

            }

            if ( $lng > 180 || $lng < -180 ) {

                echo $this->map_error_message( 3 );
                return;

            }

            return array( 'lat' => $lat, 'lng' => $lng );

        } else {
            $message = esc_html__( 'Location not found', 'phox-host' );

            echo $this->map_error_message( 1 );
            return;
        }

    }

    /**
     * Get Google map api from admin panel
     *
     * @since 1.6.8
     * @return bool
     */
    public function get_api_key(){

        $key = wdes_opts_get('google_maps_api_key');

        return ( empty( $key ) ) ?  : $key;

    }

    /**
     * Error Message
     *
     * @since 1.6.8
     * @param int $error_number
     * @param string $message
     * @return string
     */
    public function map_error_message( $error_number = 1 ,$message = '' ) {

        if( empty( $message ) ) {

            switch ( $error_number ){
                case 1:
                    $message = esc_html__( 'Location not found', 'phox-host' );
                case 2:
                    $message = esc_html__( 'Please set Google maps API key before using this widget.', 'phox-host' );
                case 3:
                    $message = 'Map Center latitude value outside range';
            }

        }


        return sprintf( '<div class="wdes-map-message"><div class="wdes-map-message-random-map"></div><span class="wdes-map-message-text">%s</span></div>', $message );
    }
}