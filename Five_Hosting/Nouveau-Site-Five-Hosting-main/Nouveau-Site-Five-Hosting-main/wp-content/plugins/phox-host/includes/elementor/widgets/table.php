<?php

namespace Phox_Host\Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
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
use Phox_Host\Elementor\Libs\Table\CSV_Parser;

/**
 * Table widget.
 *
 * Table widget that will display in Phox category
 *
 * @package Elementor\Widgets
 * @since 1.5.0
 */
class Table extends Base_Widget {

	/**
	 * Table Sort option
	 *
	 * @var bool Sort option is turn on or off
	 * @since  1.5.1
	 * @access private
	 */
	private $sort;

	/**
	 * Get Widget Title
	 *
	 * Retrieve Table widget title
	 *
	 * @return string Widget title
	 * @since  1.5.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Table', 'phox-host' );
	}

	/**
	 * Get Widget icon
	 *
	 * Retrieve Table widget icon
	 *
	 * @return string Widget icon
	 * @since  1.5.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'wdes-widget-elementor wdes-widget-table';
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
		return [ 'wdes-jquery-tablesorter', 'wdes-jquery-tablesorter-filter' ];
	}

	/**
	 * Get Widget keywords
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array widget keywords.
	 * @since  1.5.0
	 * @access public
	 *
	 */
	public function get_keywords() {
		return [ 'table' ];
	}

	/**
	 * Register Widget widget controls
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.5.0
	 * @access protected
	 */
	protected function register_controls() {

		$css_scheme = [
			'wrapper'                 => '.wdes-table-wrapper',
			'table'                   => '.wdes-table',
			'table_search'            => '.wdes-table-search',
			'table_cell'              => '.wdes-table-cell',
			'table_head'              => '.wdes-table-head',
			'table_head_row'          => '.wdes-table-head-row',
			'table_head_cell'         => '.wdes-table-head-cell',
			'table_head_cell_inner'   => '.wdes-table-head-cell .wdes-table-cell-inner',
			'table_head_cell_content' => '.wdes-table-head-cell .wdes-table-cell-content',
			'table_head_icon'         => '.wdes-table-head-cell .wdes-table-cell-icon',
			'table_head_icon_before'  => '.wdes-table-head-cell .wdes-table-cell-icon-before',
			'table_head_icon_after'   => '.wdes-table-head-cell .wdes-table-cell-icon-after',
			'table_head_img'          => '.wdes-table-head-cell .wdes-table-cell-img',
			'table_head_img_before'   => '.wdes-table-head-cell .wdes-table-cell-img-before',
			'table_head_img_after'    => '.wdes-table-head-cell .wdes-table-cell-img-after',
			'sorting_icon'            => '.wdes-table-sort-icon',
			'table_body'              => '.wdes-table-body',
			'table_body_row'          => '.wdes-table-body-row',
			'table_body_cell'         => '.wdes-table-body-cell',
			'table_body_cell_inner'   => '.wdes-table-body-cell .wdes-table-cell-inner',
			'table_body_cell_content' => '.wdes-table-body-cell .wdes-table-cell-content',
			'table_body_icon'         => '.wdes-table-body-cell .wdes-table-cell-icon',
			'table_body_icon_before'  => '.wdes-table-body-cell .wdes-table-cell-icon-before',
			'table_body_icon_after'   => '.wdes-table-body-cell .wdes-table-cell-icon-after',
			'table_body_img'          => '.wdes-table-body-cell .wdes-table-cell-img',
			'table_body_img_before'   => '.wdes-table-body-cell .wdes-table-cell-img-before',
			'table_body_img_after'    => '.wdes-table-body-cell .wdes-table-cell-img-after',
			'table_body_cell_link'    => '.wdes-table-cell-link',
		];

		$this->start_controls_section(
			'table_header_source',
			[
				'label' => esc_html__( 'Date Source', 'phox-host' ),
			]
		);

		$this->add_control(
			'data_source_type',
			[
				'label'   => esc_html__( 'Data Type', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'csv'    => esc_html__( 'CSV', 'phox-host' ),
					'custom' => esc_html__( 'Custom', 'phox-host' )
				]
			]
		);

		$this->add_control(
			'csv_file',
			[
				'label'     => esc_html__( 'Upload CSV File', 'phox-host' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'data_source_type' => 'csv'
				]
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'table_header_section',
			[
				'label'     => esc_html__( 'Header Section', 'phox-host' ),
				'condition' => [
					'data_source_type' => 'custom'
				]
			]
		);

		$header_repeater = new Repeater();

		$header_repeater->add_control(
			'header_content',
			[
				'label' => esc_html__( 'Content', 'phox-host' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$header_repeater->add_control(
			'cell_text',
			[
				'label'   => esc_html__( 'Text', 'phox-host' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
			]
		);

		$header_repeater->add_control(
			'add_icon_or_image',
			[
				'label'   => esc_html__( 'Add icon/image', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''      => esc_html__( 'None', 'phox-host' ),
					'icon'  => esc_html__( 'Icon', 'phox-host' ),
					'image' => esc_html__( 'Image', 'phox-host' ),
				],
			]
		);

		$header_repeater->add_control(
			'cell_icon',
			[
				'label'       => esc_html__( 'Icon', 'phox-host' ),
				'label_block' => true,
				'type'        => Controls_Manager::ICONS,
				'condition'   => [
					'add_icon_or_image' => 'icon',
				],
			]
		);

		$header_repeater->add_control(
			'cell_image',
			[
				'label'     => esc_html__( 'Image', 'phox-host' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'add_icon_or_image' => 'image',
				],
			]
		);

		$header_repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'cell_image_size',
				'default'   => 'thumbnail',
				'condition' => [
					'add_icon_or_image' => 'image',
				],
			]
		);

		$header_repeater->add_control(
			'additional_elem_position',
			[
				'label'     => esc_html__( 'Position', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'before',
				'options'   => [
					'before' => esc_html__( 'Before', 'phox-host' ),
					'after'  => esc_html__( 'After', 'phox-host' ),
				],
				'condition' => [
					'add_icon_or_image!' => '',
				],
			]
		);

		$header_repeater->add_control(
			'header_settings',
			[
				'label'     => esc_html__( 'Settings', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$header_repeater->add_control(
			'col_span',
			[
				'label' => esc_html__( 'Column Span', 'phox-host' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 1,
				'step'  => 1,
			]
		);

		$header_repeater->add_responsive_control(
			'col_width',
			[
				'label'      => esc_html__( 'Column Width', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' . $css_scheme['table_head_cell'] => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$header_repeater->add_control(
			'header_style',
			[
				'label'     => esc_html__( 'Style', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$header_repeater->add_control(
			'cell_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' . $css_scheme['table_head_cell'] => 'color: {{VALUE}};',
				],
			]
		);

		$header_repeater->add_control(
			'cell_bg_color',
			[
				'label'     => esc_html__( 'Background color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' . $css_scheme['table_head_cell'] => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_header',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $header_repeater->get_controls(),
				'default'     => [
					[
						'cell_text' => esc_html__( 'Heading #1', 'phox-host' ),
					],
					[
						'cell_text' => esc_html__( 'Heading #2', 'phox-host' ),
					],
					[
						'cell_text' => esc_html__( 'Heading #3', 'phox-host' ),
					],
				],
				'title_field' => esc_html__( 'Column: ', 'phox-host' ) . '{{ cell_text }}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'table_body_section',
			[
				'label'     => esc_html__( 'Body Section', 'phox-host' ),
				'condition' => [
					'data_source_type' => 'custom'
				]
			]
		);

		$body_repeater = new Repeater();

		$body_repeater->add_control(
			'action',
			[
				'label'   => esc_html__( 'Action', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cell',
				'options' => [
					'row'  => esc_html__( 'Start New Row', 'phox-host' ),
					'cell' => esc_html__( 'Add New Cell', 'phox-host' ),
				],
			]
		);

		$body_repeater->add_control(
			'row_custom_style',
			[
				'label'     => esc_html__( 'Add Custom Style', 'phox-host' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'action' => 'row',
				],
			]
		);

		$body_repeater->add_control(
			'row_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_row'] . '{{CURRENT_ITEM}} ' . $css_scheme['table_body_cell'] => 'color: {{VALUE}};',
				],
				'condition' => [
					'action'           => 'row',
					'row_custom_style' => 'yes',
				],
			]
		);

		$body_repeater->add_control(
			'row_bg_color',
			[
				'label'     => esc_html__( 'Background color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_row'] . '{{CURRENT_ITEM}} ' . $css_scheme['table_body_cell'] => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'action'           => 'row',
					'row_custom_style' => 'yes',
				],
			]
		);

		$body_repeater->add_control(
			'body_content',
			[
				'label'     => esc_html__( 'Content', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'action' => 'cell',
				],
			]
		);

		$body_repeater->add_control(
			'cell_text',
			[
				'label'     => esc_html__( 'Text', 'phox-host' ),
				'type'      => Controls_Manager::TEXTAREA,
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'action' => 'cell',
				],
			]
		);

		$body_repeater->add_control(
			'cell_link',
			[
				'label'       => esc_html__( 'Link', 'phox-host' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => esc_html__( 'https://your-link.com', 'phox-host' ),
				'condition'   => [
					'action' => 'cell',
				],
			]
		);

		$body_repeater->add_control(
			'add_icon_or_image',
			[
				'label'     => esc_html__( 'Add icon/image', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''      => esc_html__( 'None', 'phox-host' ),
					'icon'  => esc_html__( 'Icon', 'phox-host' ),
					'image' => esc_html__( 'Image', 'phox-host' ),
				],
				'condition' => [
					'action' => 'cell',
				],
			]
		);

		$body_repeater->add_control(
			'cell_icon',
			[
				'label'       => esc_html__( 'Icon', 'phox-host' ),
				'label_block' => true,
				'type'        => Controls_Manager::ICONS,
				'condition'   => [
					'action'            => 'cell',
					'add_icon_or_image' => 'icon',
				],
			]
		);

		$body_repeater->add_control(
			'cell_image',
			[
				'label'     => esc_html__( 'Image', 'phox-host' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [ 'active' => true ],
				'condition' => [
					'action'            => 'cell',
					'add_icon_or_image' => 'image',
				],
			]
		);

		$body_repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'cell_image_size',
				'default'   => 'thumbnail',
				'condition' => [
					'action'            => 'cell',
					'add_icon_or_image' => 'image',
				],
			]
		);

		$body_repeater->add_control(
			'additional_elem_position',
			[
				'label'     => esc_html__( 'Position', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'before',
				'options'   => [
					'before' => esc_html__( 'Before', 'phox-host' ),
					'after'  => esc_html__( 'After', 'phox-host' ),
				],
				'condition' => [
					'action'             => 'cell',
					'add_icon_or_image!' => '',
				],
			]
		);

		$body_repeater->add_control(
			'body_settings',
			[
				'label'     => esc_html__( 'Settings', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'action' => 'cell',
				],
			]
		);

		$body_repeater->add_control(
			'col_span',
			[
				'label'     => esc_html__( 'Column Span', 'phox-host' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'step'      => 1,
				'condition' => [
					'action' => 'cell',
				],
			]
		);

		$body_repeater->add_control(
			'row_span',
			[
				'label'     => esc_html__( 'Row Span', 'phox-host' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'step'      => 1,
				'condition' => [
					'action' => 'cell',
				],
			]
		);

		$body_repeater->add_control(
			'cell_is_th',
			[
				'label'     => esc_html__( 'This cell is Table Heading?', 'phox-host' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'action' => 'cell',
				],
			]
		);

		$body_repeater->add_control(
			'cell_is_th_desc',
			[
				'raw'             => esc_html__( 'For this cell are applied table heading cell style', 'phox-host' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
				'condition'       => [
					'action'     => 'cell',
					'cell_is_th' => 'yes',
				],
			]
		);

		$body_repeater->add_control(
			'body_style',
			[
				'label'     => esc_html__( 'Style', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'action' => 'cell',
				],
			]
		);

		$body_repeater->add_control(
			'cell_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_row'] . ' ' . $css_scheme['table_cell'] . '{{CURRENT_ITEM}}' => 'color: {{VALUE}};',
				],
				'condition' => [
					'action' => 'cell',
				],
			]
		);

		$body_repeater->add_control(
			'cell_bg_color',
			[
				'label'     => esc_html__( 'Background color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_row'] . ' ' . $css_scheme['table_cell'] . '{{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'action' => 'cell',
				],
			]
		);

		$this->add_control(
			'table_body',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $body_repeater->get_controls(),
				'default'     => [
					[
						'action' => 'row',
					],
					[
						'action'    => 'cell',
						'cell_text' => esc_html__( 'Simple content', 'phox-host' ),
					],
					[
						'action'    => 'cell',
						'cell_text' => esc_html__( 'Simple content', 'phox-host' ),
					],
					[
						'action'    => 'cell',
						'cell_text' => esc_html__( 'Simple content', 'phox-host' ),
					]
				],
				'title_field' => '{{ action === "row" ? "' . esc_html__( 'Start Row:', 'phox-host' ) . '" : "' . esc_html__( 'Cell:', 'phox-host' ) . ' " + cell_text }}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_table_display',
			[
				'label' => esc_html__( 'Display Options', 'phox-host' ),
			]
		);

		$this->add_control(
			'sorting_table',
			[
				'label'   => esc_html__( 'Sorting Table', 'phox-host' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => ''
			]
		);

		$this->add_control(
			'search_table',
			[
				'label'   => esc_html__( 'Search Table', 'phox-host' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => ''
			]
		);

		$this->add_control(
			'search_table_placeholder',
			[
				'label'     => esc_html__( 'Placeholder', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Search ...',
				'condition' => [
					'search_table' => 'yes',
				]
			]
		);

		$this->add_control(
			'responsive_table',
			[
				'label'   => esc_html__( 'Responsive Table', 'phox-host' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => ''
			]
		);

		$this->start_controls_tabs( 'tabs_responsive_devices' );

		$this->start_controls_tab(
			'tab_responsive_mobile',
			[
				'label'     => '<i class="fas fa-mobile-alt"></i>',
				'condition' => [
					'responsive_table' => 'yes'
				]
			]
		);

		$this->add_control(
			'responsive_mobile',
			[
				'label'     => esc_html__( 'Mobile', 'phox-host' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'responsive_table' => 'yes'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_responsive_tablet',
			[
				'label'     => '<i class="fas fa-tablet-alt"></i>',
				'condition' => [
					'responsive_table' => 'yes'
				]
			]
		);

		$this->add_control(
			'responsive_tablet',
			[
				'label'     => esc_html__( 'Tablet', 'phox-host' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'responsive_table' => 'yes'
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_responsive_desktop',
			[
				'label'     => '<i class="fas fa-desktop"></i>',
				'condition' => [
					'responsive_table' => 'yes'
				]
			]
		);

		$this->add_control(
			'responsive_desktop',
			[
				'label'     => esc_html__( 'Desktop', 'phox-host' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'responsive_table' => 'yes'
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		//Style: Table

		$this->start_controls_section(
			'section_table_search_style',
			[
				'label'     => esc_html__( 'Search in Table ', 'phox-host' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'search_table' => 'yes',
				]
			]
		);
		$this->start_controls_tabs( 'tabs_style_search' );

		$this->start_controls_tab(
			'tab_style_search_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host)' )
			]
		);

		$this->add_control(
			'tab_style_search_normal_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_search'] => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'tab_style_search_normal_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['table_search'],
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
					],
					'color'  => [
						'scheme'  => [
							'type'  => Color::get_type(),
							'value' => Color::COLOR_3,
						],
						'default' => '#e7e7e7',
					],
				],
			]
		);

		$this->add_responsive_control(
			'tab_style_search_normal_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_search'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_style_search_normal_margin',
			[
				'label'       => esc_html__( 'Margin', 'phox-host' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px' ],
				'render_type' => 'template',
				'selectors'   => [
					' {{WRAPPER}} ' . $css_scheme['table_search'] => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_style_search_normal_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_search'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'tab_style_search_normal_typography',
				'scheme'         => Typography::TYPOGRAPHY_1,
				'selector'       => '{{WRAPPER}} ' . $css_scheme['table_search'],
				'fields_options' => [
					'typography'  => [
						'default' => 'yes'
					],
					'font_weight' => [
						'default' => '400',
					],
					'font_family' => [
						'default' => 'Karla',
					],
				]
			]
		);

		$this->add_control(
			'tab_style_search_normal_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_search'] . '::placeholder' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'tab_style_search_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' )
			]
		);

		$this->add_control(
			'tab_style_search_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_search'] . ':hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'tab_style_search_hover_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['table_search'] . ':hover',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
					],
					'color'  => [
						'scheme'  => [
							'type'  => Color::get_type(),
							'value' => Color::COLOR_3,
						],
						'default' => '#1b3q4e',
					],
				],
			]
		);

		$this->add_responsive_control(
			'tab_style_search_hover_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_search'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_style_search_hover_margin',
			[
				'label'       => esc_html__( 'Margin', 'phox-host' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px' ],
				'render_type' => 'template',
				'selectors'   => [
					' {{WRAPPER}} ' . $css_scheme['table_search'] . ':hover' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_style_search_hover_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_search'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_style_search_focus',
			[
				'label' => esc_html__( 'Focus', 'phox-host' )
			]
		);

		$this->add_control(
			'tab_style_search_focus_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_search'] . ':focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'tab_style_search_focus_border',
				'label'          => esc_html__( 'Border', 'phox-host' ),
				'placeholder'    => '1px',
				'selector'       => '{{WRAPPER}} ' . $css_scheme['table_search'] . ':focus',
				'fields_options' => [
					'border' => [
						'default' => 'solid',
					],
					'width'  => [
						'default' => [
							'top'      => '1',
							'right'    => '1',
							'bottom'   => '1',
							'left'     => '1',
							'isLinked' => true,
						],
					],
					'color'  => [
						'scheme'  => [
							'type'  => Color::get_type(),
							'value' => Color::COLOR_3,
						],
						'default' => '#1b3q4e',
					],
				],
			]
		);

		$this->add_responsive_control(
			'tab_style_search_focus_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_search'] . ':focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_style_search_focus_margin',
			[
				'label'       => esc_html__( 'Margin', 'phox-host' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px' ],
				'render_type' => 'template',
				'selectors'   => [
					' {{WRAPPER}} ' . $css_scheme['table_search'] . ':focus' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tab_style_search_focus_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_search'] . ':focus' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tab_style_search_focus_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_search'] . ':focus' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_table_style',
			[
				'label' => esc_html__( 'Table', 'phox-host' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'table_width',
			[
				'label'      => esc_html__( 'Table Width', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1200,
					],
				],
				'default'    => [
					'unit' => '%',
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['wrapper'] => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'table_column_width',
			[
				'label'     => esc_html__( 'Column Width', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'auto'  => esc_html__( 'Auto', 'phox-host' ),
					'fixed' => esc_html__( 'Fixed (Equal width)', 'phox-host' ),
				],
				'default'   => 'auto',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table'] => 'table-layout: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_align',
			[
				'label'                => esc_html__( 'Table Alignment', 'phox-host' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [
					'left'   => 'margin-left: 0; margin-right: auto;',
					'center' => 'margin-left: auto; margin-right: auto;',
					'right'  => 'margin-left: auto; margin-right: 0;',
				],
				'selectors'            => [
					'{{WRAPPER}} ' . $css_scheme['wrapper'] => '{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'table_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['wrapper']                                                                       => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['table_head_row'] . ':first-child ' . $css_scheme['table_cell'] . ':first-child' => 'border-top-left-radius: {{TOP}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['table_head_row'] . ':first-child ' . $css_scheme['table_cell'] . ':last-child'  => 'border-top-right-radius: {{RIGHT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['table_body_row'] . ':last-child ' . $css_scheme['table_cell'] . ':last-child'   => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['table_body_row'] . ':last-child ' . $css_scheme['table_cell'] . ':first-child'  => 'border-bottom-left-radius: {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'table_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['wrapper'],
				'exclude'  => [
					'box_shadow_position',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_table_header_style',
			[
				'label' => esc_html__( 'Table Header', 'phox-host' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'table_head_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['table_head_cell'],
			]
		);

		$this->start_controls_tabs( 'table_head_tabs' );

		$this->start_controls_tab(
			'table_head_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'table_head_cell_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_head_cell'] => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_head_cell_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_head_cell'] => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'table_head_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'table_head_cell_color_hover',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_head_cell'] . ':hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_head_cell_bg_color_hover',
			[
				'label'     => esc_html__( 'Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_head_cell'] . ':hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'table_head_cell_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_head_cell_inner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'table_head_cell_border',
				'selector' => '{{WRAPPER}} ' . $css_scheme['table_head_cell'],
			]
		);

		$this->add_control(
			'table_head_hidden_border',
			[
				'label'     => esc_html__( 'Hidden border for header container', 'phox-host' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_head'] => 'border-style: hidden;',
				],
			]
		);

		$this->add_responsive_control(
			'table_head_cell_align',
			[
				'label'                => esc_html__( 'Alignment', 'phox-host' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					],
				],
				'selectors_dictionary' => [
					'left'   => 'margin-left: 0; margin-right: auto; text-align: left;',
					'center' => 'margin-left: auto; margin-right: auto; text-align: center;',
					'right'  => 'margin-left: auto; margin-right: 0; text-align: right;',
				],
				'selectors'            => [
					'{{WRAPPER}} ' . $css_scheme['table_head_cell_content'] => '{{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'table_head_cell_vert_align',
			[
				'label'   => esc_html__( 'Vertical Alignment', 'phox-host' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'top'    => [
						'title' => esc_html__( 'Top', 'phox-host' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'phox-host' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'phox-host' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],

				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_head_cell'] => 'vertical-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_head_cell_icon_style',
			[
				'label'     => '<b>' . esc_html__( 'Icon', 'phox-host' ) . '</b>',
				'type'      => Controls_Manager::POPOVER_TOGGLE,
				'separator' => 'before',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'table_head_cell_icon_size',
			[
				'label'      => esc_html__( 'Font Size', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'em',
					'rem',
				],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_head_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'table_head_cell_icon_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_head_cell_icon_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_head_icon'] => 'color: {{VALUE}};',
				],
				'condition' => [
					'table_head_cell_icon_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_head_cell_icon_gap',
			[
				'label'     => esc_html__( 'Gap', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} ' . $css_scheme['table_head_icon_before'] . ':not(:only-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} ' . $css_scheme['table_head_icon_before'] . ':not(:only-child)'       => 'margin-left: {{SIZE}}{{UNIT}};',
					'body:not(.rtl) {{WRAPPER}} ' . $css_scheme['table_head_icon_after'] . ':not(:only-child)'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} ' . $css_scheme['table_head_icon_after'] . ':not(:only-child)'        => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'table_head_cell_icon_style' => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'table_head_cell_img_style',
			[
				'label'     => '<b>' . esc_html__( 'Image', 'phox-host' ) . '</b>',
				'type'      => Controls_Manager::POPOVER_TOGGLE,
				'separator' => 'before',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'table_head_cell_img_width',
			[
				'label'     => esc_html__( 'Width', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_head_img'] . ' img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'table_head_cell_img_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_head_cell_img_gap',
			[
				'label'     => esc_html__( 'Gap', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} ' . $css_scheme['table_head_img_before'] . ':not(:only-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} ' . $css_scheme['table_head_img_before'] . ':not(:only-child)'       => 'margin-left: {{SIZE}}{{UNIT}};',
					'body:not(.rtl) {{WRAPPER}} ' . $css_scheme['table_head_img_after'] . ':not(:only-child)'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} ' . $css_scheme['table_head_img_after'] . ':not(:only-child)'        => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'table_head_cell_img_style' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'table_head_cell_img_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_head_img'] . ' img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'table_head_cell_img_style' => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'sorting_icon_style',
			[
				'label'     => '<b>' . esc_html__( 'Sorting Icon', 'phox-host' ) . '</b>',
				'type'      => Controls_Manager::POPOVER_TOGGLE,
				'separator' => 'before',
				'condition' => [
					'sorting_table' => 'yes',
				],
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'sorting_icon_size',
			[
				'label'      => esc_html__( 'Font Size', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'em',
					'rem',
				],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['sorting_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'sorting_icon_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'sorting_icon_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['sorting_icon'] => 'color: {{VALUE}};',
				],
				'condition' => [
					'sorting_icon_style' => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_section();

		//Style: Body

		$this->start_controls_section(
			'section_table_body_style',
			[
				'label' => esc_html__( 'Table Body', 'phox-host' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'table_body_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['table_body_cell'],
			]
		);

		$this->start_controls_tabs( 'table_body_tabs' );

		$this->start_controls_tab(
			'table_body_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'table_body_row_color',
			[
				'label'     => esc_html__( 'Row Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_cell'] => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_body_row_bg_color',
			[
				'label'     => esc_html__( 'Row Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_cell'] => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_body_striped_row',
			[
				'label' => esc_html__( 'Striped rows', 'phox-host' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'table_body_even_row_color',
			[
				'label'     => esc_html__( 'Even Row Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tr:nth-child(even) ' . $css_scheme['table_body_cell'] => 'color: {{VALUE}};',
				],
				'condition' => [
					'table_body_striped_row' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_body_even_row_bg_color',
			[
				'label'     => esc_html__( 'Even Row Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} tr:nth-child(even) ' . $css_scheme['table_body_cell'] => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'table_body_striped_row' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_body_link_color',
			[
				'label'     => esc_html__( 'Link Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_cell_link'] => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'table_body_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'table_body_row_color_hover',
			[
				'label'     => esc_html__( 'Row Hover Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_row'] . ':hover ' . $css_scheme['table_body_cell'] => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_body_row_bg_color_hover',
			[
				'label'     => esc_html__( 'Row Hover Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_row'] . ':hover ' . $css_scheme['table_body_cell'] => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_body_even_row_color_hover',
			[
				'label'     => esc_html__( 'Even Row Hover Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_row'] . ':nth-child(even):hover ' . $css_scheme['table_body_cell'] => 'color: {{VALUE}};',
				],
				'condition' => [
					'table_body_striped_row' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_body_even_row_bg_color_hover',
			[
				'label'     => esc_html__( 'Even Row Hover Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_row'] . ':nth-child(even):hover ' . $css_scheme['table_body_cell'] => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'table_body_striped_row' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_body_cell_color_hover',
			[
				'label'     => esc_html__( 'Cell Hover Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_row'] . ':hover ' . $css_scheme['table_body_cell'] . ':hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_body_cell_bg_color_hover',
			[
				'label'     => esc_html__( 'Cell Hover Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_row'] . ':hover ' . $css_scheme['table_body_cell'] . ':hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_body_link_color_hover',
			[
				'label'     => esc_html__( 'Link Hover Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_cell_link'] . ':hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'table_body_cell_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_body_cell_inner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'table_body_cell_border',
				'selector' => '{{WRAPPER}} ' . $css_scheme['table_body_cell'],
			]
		);

		$this->add_control(
			'table_body_hidden_border',
			[
				'label'     => esc_html__( 'Hidden border for body container', 'phox-host' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body'] => 'border-style: hidden;',
				],
			]
		);

		$this->add_responsive_control(
			'table_body_cell_align',
			[
				'label'                => esc_html__( 'Alignment', 'phox-host' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					],
				],
				'selectors_dictionary' => [
					'left'   => 'margin-left: 0; margin-right: auto; text-align: left;',
					'center' => 'margin-left: auto; margin-right: auto; text-align: center;',
					'right'  => 'margin-left: auto; margin-right: 0; text-align: right;',
				],
				'selectors'            => [
					'{{WRAPPER}} ' . $css_scheme['table_body_cell_content'] => '{{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'table_body_cell_vert_align',
			[
				'label'     => esc_html__( 'Vertical Alignment', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'top'    => [
						'title' => esc_html__( 'Top', 'phox-host' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'phox-host' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'phox-host' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_cell'] => 'vertical-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'table_body_cell_icon_style',
			[
				'label'     => '<b>' . esc_html__( 'Icon', 'phox-host' ) . '</b>',
				'type'      => Controls_Manager::POPOVER_TOGGLE,
				'separator' => 'before',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'table_body_cell_icon_size',
			[
				'label'      => esc_html__( 'Font Size', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [
					'px',
					'em',
					'rem',
				],
				'range'      => [
					'px' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_body_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'table_body_cell_icon_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_body_cell_icon_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_icon'] => 'color: {{VALUE}};',
				],
				'condition' => [
					'table_body_cell_icon_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_body_cell_icon_gap',
			[
				'label'     => esc_html__( 'Gap', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} ' . $css_scheme['table_body_icon_before'] . ':not(:only-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} ' . $css_scheme['table_body_icon_before'] . ':not(:only-child)'       => 'margin-left: {{SIZE}}{{UNIT}};',
					'body:not(.rtl) {{WRAPPER}} ' . $css_scheme['table_body_icon_after'] . ':not(:only-child)'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} ' . $css_scheme['table_body_icon_after'] . ':not(:only-child)'        => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'table_body_cell_icon_style' => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'table_body_cell_img_style',
			[
				'label'     => '<b>' . esc_html__( 'Image', 'phox-host' ) . '</b>',
				'type'      => Controls_Manager::POPOVER_TOGGLE,
				'separator' => 'before',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'table_body_cell_img_width',
			[
				'label'     => esc_html__( 'Width', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['table_body_img'] . ' img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'table_body_cell_img_style' => 'yes',
				],
			]
		);

		$this->add_control(
			'table_body_cell_img_gap',
			[
				'label'     => esc_html__( 'Gap', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} ' . $css_scheme['table_body_img_before'] . ':not(:only-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} ' . $css_scheme['table_body_img_before'] . ':not(:only-child)'       => 'margin-left: {{SIZE}}{{UNIT}};',
					'body:not(.rtl) {{WRAPPER}} ' . $css_scheme['table_body_img_after'] . ':not(:only-child)'  => 'margin-left: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} ' . $css_scheme['table_body_img_after'] . ':not(:only-child)'        => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'table_body_cell_img_style' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'table_body_cell_img_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['table_body_img'] . ' img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'table_body_cell_img_style' => 'yes',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_section();

	}

	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function render() {
		$settings   = $this->get_settings_for_display();
		$this->sort = isset( $settings['sorting_table'] ) && Helper::check_var_true( $settings['sorting_table'] );
		$error      = 0;

		$data_source_type = $settings['data_source_type'];
		$data_source_url  = ( isset( $settings['csv_file']['url'] ) ) ? $settings['csv_file']['url'] : '';
		$data_file_csv    = ( strpos( $data_source_url, '.csv' ) ) ? true : false;

		$table_head = $settings['table_header'];
		$table_body = $settings['table_body'];

		if ( $data_source_type === 'csv' && $data_file_csv ) {

			$csv_parser  = new CSV_Parser();
			$import_data = file_get_contents( $data_source_url );
			$csv_parser->load_data( $import_data );
			$delimiter = $csv_parser->find_delimiter();
			$data      = $csv_parser->parse( $delimiter );
			$error     = $csv_parser->error;

			$data_count = count( $data );
			$table_head = $data[0];
			$table_body = $data;

		}

		$error = ( ! empty( $data_source_url ) && $data_file_csv ) ? 0 : 1;

		$this->add_render_attribute( 'wrapper', 'class', 'wdes-table-wrapper' );
		if ( ! empty( $settings['responsive_table'] ) ) {
			if ( ! empty( $settings['responsive_mobile'] ) ) {
				$this->add_render_attribute( 'wrapper', 'class', 'wdes-table-responsive-mobile' );
			}

			if ( ! empty( $settings['responsive_tablet'] ) ) {
				$this->add_render_attribute( 'wrapper', 'class', 'wdes-table-responsive-tablet' );
			}

			if ( ! empty( $settings['responsive_desktop'] ) ) {
				$this->add_render_attribute( 'wrapper', 'class', 'wdes-table-responsive-desktop' );
			}
		}

		$this->add_render_attribute( 'table', 'class', 'wdes-table' );

		if ( $this->sort ) {
			$this->add_render_attribute( 'table', 'class', 'wdes-table-sorting' );
		}

		if ( $error == 0 || $data_source_type === 'custom' ) {
			printf( '<div class="elementor-%s wdes-elements">', $this->get_name() );
			printf( '<div %s>', $this->get_render_attribute_string( 'wrapper' ) );
			if ( $settings['search_table'] === 'yes' ) {
				printf( '<input placeholder="%s" class="wdes-table-search" type="search" data-column="all" />', $settings['search_table_placeholder'] );
			}
			printf( '<table %s>', $this->get_render_attribute_string( 'table' ) );

			print ( '<thead class="wdes-table-head">' );
			echo $this->get_table_header( $table_head );
			print ( '</thead>' );

			print ( '<tbody class="wdes-table-body">' );
			if ( $data_source_type === 'csv' ) {
				for ( $i = 1; $i < $data_count; $i ++ ) {
					echo $this->get_table_body( $data[ $i ] );
				}
			} else {
				echo $this->get_table_body( $table_body );
			}

			print ( '</tbody>' );

			print ( '</table>' );
			print ( '</div>' );
			print ( '</div>' );
		} else {

			printf( '<p>%s</p>', esc_html__( 'Please make sure the file is correct' ) );

		}
	}

	/**
	 * Get Widget name
	 *
	 * Retrieve Table widget name
	 *
	 * @return string Widget name
	 * @since  1.5.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'wdes_table';
	}

	/**
	 * Get table header html.
	 *
	 * @param array $data header data.
	 *
	 * @return string
	 * @since 1.5.0
	 * @access public
	 */
	public function get_table_header( $data = [] ) {
		$html = '';

		$html .= '<tr class="wdes-table-head-row">';

		foreach ( $data as $index => $item ) {

			//add id to csv case
			if ( ! isset( $item['_id'] ) ) {
				$id = uniqid();
			} else {
				$id = $item['_id'];
			}


			$additional_content = '';
			$additional_element = isset( $item['add_icon_or_image'] ) ? $item['add_icon_or_image'] : '';
			$position           = isset( $item['additional_elem_position'] ) ? $item['additional_elem_position'] : 'before';

			if ( 'icon' === $additional_element ) {
				$icon_format        = '<span class="wdes-elements-icon wdes-table-cell-icon wdes-table-cell-icon-' . esc_attr( $position ) . '">%s</span>';
				$icon               = sprintf( '<i class="%s"></i>', $item['cell_icon']['value'] );
				$additional_content = sprintf( $icon_format, $icon );
			}

			if ( 'image' === $additional_element && ! empty ( $item['cell_image']['url'] ) ) {
				$image_html = Group_Control_Image_Size::get_attachment_image_html( $item, 'cell_image_size', 'cell_image' );

				$additional_content = sprintf( '<div class="wdes-table-cell-img wdes-table-cell-img-%2$s">%1$s</div>', $image_html, esc_attr( $position ) );
			}

			// add text to cell for csv
			if ( ! isset( $item['cell_text'] ) ) {
				$cell_text = ( ! empty( $item ) ) ? sprintf( '<div class="wdes-table-cell-text">%s</div>', $this->parse_text_editor( $item ) ) : '';
			} else {
				$cell_text = ( ! empty( $item['cell_text'] ) || '0' === $item['cell_text'] ) ? sprintf( '<div class="wdes-table-cell-text">%s</div>', $this->parse_text_editor( $item['cell_text'] ) ) : '';
			}


			$cell_content = sprintf( '<div class="wdes-table-cell-content">%1$s%2$s</div>', $additional_content, $cell_text );

			$this->add_render_attribute( 'cell-' . $id, 'class', 'wdes-table-cell' );
			$this->add_render_attribute( 'cell-' . $id, 'class', sprintf( 'elementor-repeater-item-%s', esc_attr( $id ) ) );

			if ( ! empty( $item['col_span'] ) ) {
				$this->add_render_attribute( 'cell-' . $id, 'colspan', esc_attr( $item['col_span'] ) );
			}

			if ( ! empty( $item['row_span'] ) ) {
				$this->add_render_attribute( 'cell-' . $id, 'rowspan', esc_attr( $item['row_span'] ) );
			}

			$this->add_render_attribute( 'cell-' . $id, 'class', 'wdes-table-head-cell' );
			$this->add_render_attribute( 'cell-' . $id, 'scope', 'col' );

			$sorting_icon = $this->sort ? '<i class="wdes-table-sort-icon"></i>' : '';

			$html .= sprintf( '<th %3$s><div class="wdes-table-cell-inner">%1$s%2$s</div></th>', $cell_content, $sorting_icon, $this->get_render_attribute_string( 'cell-' . $id ) );

		}

		$html .= '</tr>';

		return $html;

	}

	/**
	 * Get table body html.
	 *
	 * @param array $data body data.
	 *
	 * @return string
	 * @since 1.5.0
	 * @access public
	 */
	public function get_table_body( $data = [] ) {
		$html         = '';
		$is_first_row = true;

		foreach ( $data as $index => $item ) {

			//add id to csv case
			if ( ! isset( $item['_id'] ) ) {
				$id = uniqid();
			} else {
				$id = $item['_id'];
			}

			if ( isset( $item['action'] ) && 'row' === $item['action'] ) {
				if ( $is_first_row ) {
					$html         .= sprintf( '<tr class="wdes-table-body-row elementor-repeater-item-%s">', esc_attr( $id ) );
					$is_first_row = false;
				} else {
					$html .= sprintf( '</tr><tr class="wdes-table-body-row elementor-repeater-item-%s">', esc_attr( $id ) );
				}
			} else {

				$additional_content = '';
				$additional_element = isset( $item['add_icon_or_image'] ) ? $item['add_icon_or_image'] : '';
				$position           = isset( $item['additional_elem_position'] ) ? $item['additional_elem_position'] : 'before';

				if ( 'icon' === $additional_element ) {
					$icon_format        = '<span class="wdes-elements-icon wdes-table-cell-icon wdes-table-cell-icon-' . esc_attr( $position ) . '">%s</span>';
					$icon               = sprintf( '<i class="%s"></i>', $item['cell_icon']['value'] );
					$additional_content = sprintf( $icon_format, $icon );
				}

				if ( 'image' === $additional_element && ! empty ( $item['cell_image']['url'] ) ) {
					$image_html = Group_Control_Image_Size::get_attachment_image_html( $item, 'cell_image_size', 'cell_image' );

					$additional_content = sprintf( '<div class="wdes-table-cell-img wdes-table-cell-img-%2$s">%1$s</div>', $image_html, esc_attr( $position ) );
				}

				// add text to cell for csv
				if ( ! isset( $item['cell_text'] ) ) {
					$cell_text = ( ! empty( $item ) ) ? sprintf( '<div class="wdes-table-cell-text">%s</div>', $this->parse_text_editor( $item ) ) : '';
				} else {
					$cell_text = ( ! empty( $item['cell_text'] ) || '0' === $item['cell_text'] ) ? sprintf( '<div class="wdes-table-cell-text">%s</div>', $this->parse_text_editor( $item['cell_text'] ) ) : '';
				}


				$cell_content = sprintf( '<div class="wdes-table-cell-content">%1$s%2$s</div>', $additional_content, $cell_text );

				$this->add_render_attribute( 'cell-' . $id, 'class', 'wdes-table-cell' );
				$this->add_render_attribute( 'cell-' . $id, 'class', sprintf( 'elementor-repeater-item-%s', esc_attr( $id ) ) );

				if ( ! empty( $item['col_span'] ) ) {
					$this->add_render_attribute( 'cell-' . $id, 'colspan', esc_attr( $item['col_span'] ) );
				}

				if ( ! empty( $item['row_span'] ) ) {
					$this->add_render_attribute( 'cell-' . $id, 'rowspan', esc_attr( $item['row_span'] ) );
				}

				//Render cells in the tbody tag
				$cell_tag = ( isset( $item['cell_is_th'] ) && Helper::check_var_true( $item['cell_is_th'] ) ) ? 'th' : 'td';

				if ( 'th' === $cell_tag ) {
					$this->add_render_attribute( 'cell-' . $id, 'class', 'wdes-table-head-cell' );
					$this->add_render_attribute( 'cell-' . $id, 'scope', 'row' );
				} else {
					$this->add_render_attribute( 'cell-' . $id, 'class', 'wdes-table-body-cell' );
				}

				$cell_inner_tag = 'div';
				$this->add_render_attribute( 'cell-inner-' . $id, 'class', 'wdes-table-cell-inner' );

				if ( ! empty( $item['cell_link']['url'] ) ) {
					$cell_inner_tag = 'a';
					$this->add_render_attribute( 'cell-inner-' . $id, 'class', 'wdes-table-cell-link' );
					$this->add_render_attribute( 'cell-inner-' . $id, 'href', esc_url( $item['cell_link']['url'] ) );

					if ( $item['cell_link']['is_external'] ) {
						$this->add_render_attribute( 'cell-inner-' . $id, 'target', '_blank' );
					}

					if ( $item['cell_link']['nofollow'] ) {
						$this->add_render_attribute( 'cell-inner-' . $id, 'rel', 'nofollow' );
					}
				}

				$html .= sprintf( '<%2$s %3$s><%4$s %5$s>%1$s</%4$s></%2$s>',
					$cell_content,
					$cell_tag,
					$this->get_render_attribute_string( 'cell-' . $id ),
					$cell_inner_tag,
					$this->get_render_attribute_string( 'cell-inner-' . $id )
				);
			}
		}

		$html .= '</tr>';

		return $html;
	}

}
