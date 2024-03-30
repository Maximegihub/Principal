<?php

namespace Phox_Host\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use \Elementor\Core\Schemes\Color;
use \Elementor\Group_Control_Background;
use Phox_Host\Elementor\Base\Base_Widget;

/**
 * World Map widget.
 *
 * World Map widget that will display in Phox category
 *
 * @package Elementor\Widgets
 * @since 1.5.2
 */
class World_Map extends Base_Widget {

	/**
	 * Get Widget name
	 *
	 * Retrieve World Map widget name
	 *
	 * @since  1.4.6
	 * @access public
	 *
	 * @return string Widget name
	 */
	public function get_name() {
		return 'wdes_world_map';
	}

	/**
	 * Get Widget Title
	 *
	 * Retrieve World Map widget title
	 *
	 * @return string Widget title
	 * @since  1.5.2
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'World Map', 'phox-host' );
	}

	/**
	 * Get Widget icon
	 *
	 * Retrieve World Map widget icon
	 *
	 * @return string Widget icon
	 * @since  1.5.2
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'wdes-widget-elementor wdes-widget-world-map';
	}

	/**
	 * Get script dependencies.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @return array Widget scripts dependencies.
	 * @since 1.5.1
	 * @access public
	 *
	 */
	public function get_script_depends() {
		return [ 'wdes-ammap', 'wdes-ammap-worldlow' ];
	}

	/**
	 * Get Widget keywords
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array widget keywords.
	 * @since  1.5.2
	 * @access public
	 *
	 */
	public function get_keywords() {
		return [ 'chart', 'map' ];
	}

	/**
	 * Register Widget widget controls
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.5.2
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'world_map_location',
			[
				'label' => esc_html__( 'Locations', 'phox-host' ),
			]
		);

		$location_repeater = new Repeater();

		$location_repeater->add_control(
			'world_map_name',
			[
				'label'   => esc_html__( 'Country Name', 'phox-host' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Paris',
			]
		);

		$location_repeater->add_control(
			'world_map_latitude',
			[
				'label'   => esc_html__( 'Latitude', 'phox-host' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 48.85,
			]
		);

		$location_repeater->add_control(
			'world_map_longitude',
			[
				'label'   => esc_html__( 'Longitude', 'phox-host' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2.351,
			]
		);

		$this->add_control(
			'world_map_countries',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $location_repeater->get_controls(),
				'default'     => [
					[
						'world_map_name' => esc_html__( 'Paris', 'phox-host' ),
						'world_map_latitude' => 48.8567,
						'world_map_longitude' => 2.3510,
					],
					[
						'world_map_name' => esc_html__( 'Toronto', 'phox-host' ),
						'world_map_latitude' => 43.8163,
						'world_map_longitude' => -79.4287,
					],
					[
						'world_map_name' => esc_html__( 'Los Angeles', 'phox-host' ),
						'world_map_latitude' => 34.3,
						'world_map_longitude' => -118.15,
					],
					[
						'world_map_name' => esc_html__( 'Havana', 'phox-host' ),
						'world_map_latitude' => 23,
						'world_map_longitude' => -82,
					]
				],
				'title_field' => '{{ world_map_name }}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'world_map_general_style',
			[
				'label'      => esc_html__( 'Map', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'world_map_general_background',
			[
				'label' => esc_html__( 'Background', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#e3e3e3'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'world_map_spots_style',
			[
				'label'      => esc_html__( 'Spots', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'world_map_spot_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#c51e3a'
			]
		);

		$this->add_control(
			'world_map_spot_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'world_map_line_style',
			[
				'label'      => esc_html__( 'Line', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'world_map_line_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#c51e3a'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'world_map_moving_object_style',
			[
				'label'      => esc_html__( 'Moving Object', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'world_map_moving_object_color',
			[
				'label' => esc_html__( 'Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#c51e3a'
			]
		);

		$this->add_control(
			'world_map_moving_object_shadow_color',
			[
				'label' => esc_html__( 'Shadow Color', 'phox-host' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000'
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.5.2
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$countries = [];

		$map_setting = [];

		$map_setting ['areasSettings'] = ['unlistedAreasColor' => $settings['world_map_general_background']];

		$map_setting ['imagesSettings'] = [
			'color' => $settings['world_map_spot_color'],
			'rollOverColor' => $settings['world_map_spot_hover_color'],
		];

		$map_setting ['movingObject'] = [
			'color' => $settings['world_map_moving_object_color'],
			'shadowColor' => $settings['world_map_moving_object_shadow_color'],
		];

		$map_setting ['line'] = [
			'linesSettings' => $settings['world_map_line_color']
		];


		foreach ( $settings['world_map_countries'] as $country ){

			$pre_json_data = ['title' => $country['world_map_name'], 'latitude' => $country['world_map_latitude'], 'longitude' => $country['world_map_longitude'] ];

			$countries []= $pre_json_data ;

		}
		echo "<div id='wdes-world-map' data-countries='".json_encode($countries)."' data-settings='".json_encode($map_setting)."' >";
			print '<div id="chartdiv"></div>';
		print ('</div>');
	}

}
