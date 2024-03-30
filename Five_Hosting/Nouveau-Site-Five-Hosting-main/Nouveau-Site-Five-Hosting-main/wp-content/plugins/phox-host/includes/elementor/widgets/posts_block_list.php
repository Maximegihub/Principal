<?php

namespace Phox_Host\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography;
use Phox_Host\Elementor\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; //Exit if assessed directly
}

/**
 * Post Block List widget.
 *
 * Post Block List widget that will display in Phox category
 *
 * @package Elementor\Widgets
 * @since 1.4.2
 */
class Posts_Block_list extends Base_Widget {

	protected $query = [];
	private $settings;

	/**
	 * Get Widget name
	 *
	 * Retrieve Posts Block List widget name
	 *
	 * @return string Widget name
	 * @since  1.4.2
	 * @access public
	 *
	 */
	public function get_name() {
		return 'wdes_posts_list';
	}

	/**
	 * Get Widget title
	 *
	 * Retrieve Posts Block List widget title
	 *
	 * @return string Widget title
	 * @since  1.4.2
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Posts Block List', 'phox-host' );
	}

	/**
	 * Get Widget icon
	 *
	 * Retrieve Posts Block List widget icon
	 *
	 * @return string Widget icon
	 * @since  1.4.2
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'wdes-widget-elementor wdes-widget-blog';
	}

	/**
	 * Get Widget keywords
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array widget keywords.
	 * @since  1.4.2
	 * @access public
	 *
	 */
	public function get_keywords() {
		return [ 'posts', 'cpt', 'item', 'loop', 'query', 'cards' ];
	}


	/**
	 * Register Tabs widget controls
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.4.2
	 * @access protected
	 */
	protected function register_controls() {

		$css_scheme = [
			'featured_post'         => '.wdes-posts-block-list-featured',
			'featured_post_image'   => '.wdes-posts-block-list-post-thumbnail.post-thumbnail-featured',
			'featured_post_title'   => '.wdes-posts-list .wdes-posts-block-list-featured .wdes-posts-block-list-featured-content .post-title-featured',
			'featured_post_text'    => '.wdes-posts-list .wdes-posts-block-list-featured .wdes-posts-block-list-featured-content .post-excerpt-featured',
			'featured_post_button'  => '.wdes-posts-list .wdes-posts-block-list-featured .wdes-posts-block-list-featured-content .wdes-posts-block-list-more-wrap .wdes-posts-block-list-more',
			'featured_post_content' => '.wdes-posts-block-list-featured-content',
			'posts_list'            => '.wdes-posts-block-list-posts',
			'post'                  => '.wdes-posts-block-list-wrap .wdes-posts-list .wdes-posts-block-list-posts .wdes-posts-block-list-post',
			'post_image'            => '.wdes-posts-block-list-post-thumbnail.post-thumbnail-simple',
			'post_title'            => '.wdes-posts-block-list-wrap .wdes-posts-list .wdes-posts-block-list-posts .wdes-posts-block-list-post .wdes-posts-block-list-post-content .post-title-simple',
			'post_text'             => '.wdes-posts-block-list-wrap .wdes-posts-list .wdes-posts-block-list-posts .wdes-posts-block-list-post .wdes-posts-block-list-post-content .post-excerpt-simple',
			'post_button'           => '.wdes-posts-block-list-wrap .wdes-posts-list .wdes-posts-block-list-posts .wdes-posts-block-list-post .wdes-posts-block-list-post-content .wdes-posts-block-list-more-wrap a.wdes-posts-block-list-more',
			'post_content'          => '.wdes-posts-block-list-post-content',
			'heading'               => '.wdes-posts-block-list-heading',
			'heading_title'         => '.wdes-posts-block-list-title',
			'filter'                => '.wdes-posts-block-list-filter',
			'filter_item'           => '.wdes-posts-block-list-filter > .wdes-posts-block-list-filter-item',
			'hidden_item'           => '.wdes-posts-block-list-filter-more',
			'hidden_wrap'           => '.wdes-posts-block-list-filter-hidden-items',
			'meta_item'             => '.wdes-posts-block-list-meta-item',
			'meta'                  => '.wdes-posts-block-list-meta',
			'meta_wrap'             => '.wdes-posts-block-list-wrap .wdes-posts-block-list-featured .wdes-posts-block-list-featured-content .wdes-posts-block-list-meta',
			'terms_link'            => '.wdes-posts-block-list-wrap .wdes-posts-list .wdes-posts-block-list-posts .wdes-posts-block-list-post a.wdes-posts-block-list-terms-link',
			'featured_terms_link'   => '.wdes-posts-block-list-wrap .wdes-posts-block-list-featured .wdes-posts-block-list-terms .wdes-posts-block-list-terms-link',
		];

		$this->start_controls_section(
			'display_section',
			[
				'label' => esc_html__( 'Display Control', 'phox-host' ),
			]
		);

		$this->add_control(
			'featured_post',
			[
				'label'        => esc_html__( 'Mark First Post as Feature', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'list_post',
			[
				'label'        => esc_html__( 'Show List Post', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'featured_section',
			[
				'label' => esc_html__( 'Featured Post', 'phox-host' ),
				'condition'   => [
					'featured_post' => 'yes'
				]
			]
		);

		$this->add_control(
			'featured_position',
			[
				'label'       => esc_html__( 'Featured Post Position', 'phox-host' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default'     => 'left',
				'options'     => [
					'top'   => esc_html__( 'Top', 'phox-host' ),
					'left'  => esc_html__( 'Left', 'phox-host' ),
					'right' => esc_html__( 'Right', 'phox-host' ),
				],
				'condition'   => [
					'featured_post' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'featured_width',
			[
				'label'       => esc_html__( 'Featured Post Max Width', 'phox-host' ),
				'label_block' => true,
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'default'     => [
					'unit' => '%',
					'size' => 50,
				],
				'range'       => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'condition'   => [
					'featured_post'     => 'yes',
					'featured_position' => [
						'left',
						'right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .wdes-posts-block-list-wrap ' . $css_scheme['featured_post'] => 'max-width: {{SIZE}}%; flex: 0 0 {{SIZE}}%;',
					'{{WRAPPER}} .featured-position-left + ' . $css_scheme['posts_list'] => 'max-width: calc( 100% - {{SIZE}}% ); flex-basis: calc( 100% - {{SIZE}}% );',
					'{{WRAPPER}} .featured-position-right + ' . $css_scheme['posts_list'] => 'max-width: calc( 100% - {{SIZE}}% ); flex-basis: calc( 100% - {{SIZE}}% );',
				],
			]

		);

		$this->add_control(
			'featured_layout',
			[
				'label'       => esc_html__( 'Featured Post Layout', 'phox-host' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default'     => 'boxed',
				'options'     => [
					'simple' => esc_html__( 'Simple', 'phox-host' ),
					'boxed'  => esc_html__( 'Boxed', 'phox-host' ),
				],
				'condition'   => [
					'featured_post' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_image_size',
			[
				'label'       => esc_html__( 'Featured Post Image Size', 'phox-host' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default'     => 'full',
				'options'     => $this->get_image_sizes(),
				'condition'   => [
					'featured_post' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_image_position',
			[
				'label'       => esc_html__( 'Featured Post Image Position', 'phox-host' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default'     => 'top',
				'options'     => [
					'top'   => esc_html__( 'Top', 'phox-host' ),
					'left'  => esc_html__( 'Left', 'phox-host' ),
					'right' => esc_html__( 'Right', 'phox-host' ),
				],
				'condition'   => [
					'featured_post'   => 'yes',
					'featured_layout' => 'simple',
				],
			]
		);

		$this->add_responsive_control(
			'featured_image_width',
			[
				'label'       => esc_html__( 'Featured Post Image Max Width', 'phox-host' ),
				'label_block' => true,
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'default'     => [
					'unit' => '%',
					'size' => 50,
				],
				'range'       => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'condition'   => [
					'featured_post'           => 'yes',
					'featured_layout'         => 'simple',
					'featured_image_position' => [
						'left',
						'right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}}  .featured-img-left ' . $css_scheme['featured_post_image'] => 'max-width: {{SIZE}}%; flex: 0 0 {{SIZE}}% !important;',
					'{{WRAPPER}}  .featured-img-right ' . $css_scheme['featured_post_image'] => 'max-width: {{SIZE}}%; flex: 0 0 {{SIZE}}% !important;',
				],
			]
		);

		$this->add_control(
			'featured_title_length',
			[
				'label'       => esc_html__( 'Featured Post Title Max Length (Words)', 'phox-host' ),
				'description' => esc_html__( 'Set 0 to show full title', 'phox-host' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 0,
				'min'         => 0,
				'max'         => 15,
				'step'        => 1,
				'label_block' => true,
				'separator'   => 'before',
				'condition'   => [
					'featured_post' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_excerpt_length',
			[
				'label'       => esc_html__( 'Featured Post Excerpt Length', 'phox-host' ),
				'label_block' => true,
				'description' => esc_html__( 'Set 0 to hide excerpt or -1 to show full excerpt', 'phox-host' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 20,
				'min'         => - 1,
				'max'         => 200,
				'step'        => 1,
				'condition'   => [
					'featured_post' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_excerpt_trimmed_ending',
			[
				'label'     => esc_html__( 'Featured Excerpt Trimmed Ending', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '...',
				'condition' => [
					'featured_post' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_read_more',
			[
				'label'        => esc_html__( 'Featured Post Read More Button', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'phox-host' ),
				'label_off'    => esc_html__( 'Hide', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'featured_post' => 'yes'
				],
			]
		);

		$this->add_control(
			'featured_read_more_text',
			[
				'label'     => esc_html__( 'Read More Button Label', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read More', 'phox-host' ),
				'condition' => [
					'featured_post'      => 'yes',
					'featured_read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'add_button_icon',
			[
				'label'        => esc_html__( 'Read More Button Icon', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition' => [
					'featured_post'      => 'yes',
					'featured_read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_icon',
			[
				'type'      => Controls_Manager::ICONS,
				'label'     => esc_html__( 'Read More Button Icon', 'phox-host' ),
				'condition' => [
					'add_button_icon' => 'yes',
					'featured_post'      => 'yes',
					'featured_read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_show_meta',
			[
				'label'        => esc_html__( 'Featured Post Meta', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'phox-host' ),
				'label_off'    => esc_html__( 'Hide', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'featured_post' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_meta_position',
			[
				'label'       => esc_html__( 'Featured Meta Position', 'phox-host' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default'     => 'before',
				'options'     => [
					'before'        => esc_html__( 'Before Title', 'phox-host' ),
					'after'         => esc_html__( 'After Title', 'phox-host' ),
					'after-excerpt' => esc_html__( 'After Excerpt', 'phox-host' ),
				],
				'condition'   => [
					'featured_post'      => 'yes',
					'featured_show_meta' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_show_author',
			[
				'label'        => esc_html__( 'Show Post Author', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'phox-host' ),
				'label_off'    => esc_html__( 'Hide', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'featured_post'      => 'yes',
					'featured_show_meta' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_show_author_icon',
			[
				'type'      => Controls_Manager::ICONS,
				'label'     => esc_html__( 'Author Icon', 'phox-host' ),
				'default'   => [
					'value' => 'fas fa-user'
				],
				'condition' => [
					'featured_post'        => 'yes',
					'featured_show_meta'   => 'yes',
					'featured_show_author' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_show_date',
			[
				'label'        => esc_html__( 'Show Post Date', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'phox-host' ),
				'label_off'    => esc_html__( 'Hide', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'featured_post'      => 'yes',
					'featured_show_meta' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_show_date_icon',
			[
				'type'      => Controls_Manager::ICONS,
				'label'     => esc_html__( 'Date Icon', 'phox-host' ),
				'default'   => [
					'value' =>'fas fa-calendar'
				],
				'condition' => [
					'featured_post'      => 'yes',
					'featured_show_meta' => 'yes',
					'featured_show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_show_comments',
			[
				'label'        => esc_html__( 'Show Post Comments', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'phox-host' ),
				'label_off'    => esc_html__( 'Hide', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'featured_post'      => 'yes',
					'featured_show_meta' => 'yes',
				],
			]
		);

		$this->add_control(
			'featured_show_comments_icon',
			[
				'type'      => Controls_Manager::ICONS,
				'label'     => esc_html__( 'Comments Icon', 'phox-host' ),
				'default'   => [
					'value' =>'fas fa-comments'
				],
				'condition' => [
					'featured_post'          => 'yes',
					'featured_show_meta'     => 'yes',
					'featured_show_comments' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_featured_terms',
			[
				'label'        => esc_html__( 'Show Post Terms', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'featured_post' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_featured_terms_tax',
			[
				'label'     => esc_html__( 'Show Terms From', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'category',
				'options'   => $this->get_post_taxonomies(),
				'condition' => [
					'featured_post'       => 'yes',
					'show_featured_terms' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'general_section',
			[
				'label' => esc_html__( 'Single Post', 'phox-host' ),
				'condition'   => [
					'list_post' => 'yes'
				]
			]
		);


		$this->add_responsive_control(
			'posts_columns',
			[
				'label'     => esc_html__( 'Columns Number', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => ['1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4'],
				'separator' => 'before',
				'condition' => [
					'list_post' => 'yes'
				]
			]
		);

		$this->add_control(
			'posts_rows',
			[
				'label'     => esc_html__( 'Rows Number', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => ['1' => '1', '2' => '2', '3' =>'3', '4'=> '4', '5' =>'5', '6' => '6' ],
				'condition' => [
					'list_post' => 'yes'
				]
			]
		);

		$this->add_control(
			'show_image',
			[
				'label'        => esc_html__( 'Post Thumbnail', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'phox-host' ),
				'label_off'    => esc_html__( 'Hide', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'list_post' => 'yes'
				]
			]
		);

		$this->add_control(
			'image_size',
			[
				'label'     => esc_html__( 'Post Image Size', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'full',
				'options'   => $this->get_image_sizes(),
				'condition' => [
					'show_image' => 'yes',
					'list_post'  => 'yes'
				],
			]
		);

		$this->add_control(
			'custom_image_size',
			[
				'label'       => esc_html__( 'Post Custom Image Size', 'phox-host' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => esc_html__( 'You can Change the original image size to any custom size.', 'phox-host' ),
				'condition' => [
					'show_image' => 'yes',
					'list_post'  => 'yes',
                    'image_size' => 'custom'
				],
			]
		);

		$this->add_control(
			'image_position',
			[
				'label'     => esc_html__( 'Post Image Position', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => [
					'top'   => esc_html__( 'Top', 'phox-host' ),
					'left'  => esc_html__( 'Left', 'phox-host' ),
					'right' => esc_html__( 'Right', 'phox-host' ),
				],
				'condition' => [
					'show_image' => 'yes',
					'list_post'  => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'      => esc_html__( 'Post Image Max Width', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default'    => [
					'unit' => '%',
					'size' => 50,
				],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'condition'  => [
					'show_image'     => 'yes',
					'image_position' => [
						'left',
						'right',
					],
					'list_post'      => 'yes'

				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post_image'] => 'max-width: {{SIZE}}{{UNIT}} ! important;'
				],
			]
		);

		$this->add_control(
			'title_length',
			[
				'label'       => esc_html__( 'Title Max Length (Words)', 'phox-host' ),
				'description' => esc_html__( 'Set 0 to show full title', 'phox-host' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 0,
				'min'         => 0,
				'max'         => 15,
				'step'        => 1,
				'label_block' => true,
				'separator'   => 'before',
				'condition'   => [
					'list_post' => 'yes'
				]
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'       => esc_html__( 'Excerpt Length', 'phox-host' ),
				'description' => esc_html__( 'Set 0 to hide excerpt or -1 to show full excerpt', 'phox-host' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 5,
				'min'         => - 1,
				'max'         => 200,
				'step'        => 1,
				'condition'   => [
					'list_post' => 'yes'
				]
			]
		);

		$this->add_control(
			'excerpt_trimmed_ending',
			[
				'label'     => esc_html__( 'Excerpt Trimmed Ending', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '...',
				'condition' => [
					'list_post' => 'yes'
				]
			]
		);

		$this->add_control(
			'read_more',
			[
				'label'        => esc_html__( 'Read More Button', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'phox-host' ),
				'label_off'    => esc_html__( 'Hide', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'list_post' => 'yes'
				]
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label'     => esc_html__( 'Read More Button Label', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read More', 'phox-host' ),
				'condition' => [
					'read_more' => 'yes',
					'list_post' => 'yes'
				],
			]
		);


		$this->add_control(
			'show_meta',
			[
				'label'        => esc_html__( 'Post Meta', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'phox-host' ),
				'label_off'    => esc_html__( 'Hide', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'list_post' => 'yes'
				]
			]
		);

		$this->add_control(
			'post_add_button_icon',
			[
				'label'        => esc_html__( 'Read More Button Icon', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => '',
				'condition'    => [
					'list_post' => 'yes'
				]
			]
		);

		$this->add_control(
			'post_button_icon',
			[
				'type'      => Controls_Manager::ICONS,
				'label'     => esc_html__( 'Read More Button Icon', 'phox-host' ),
				'condition' => [
					'post_add_button_icon' => 'yes',
					'list_post' => 'yes'
				],
			]
		);

		$this->add_control(
			'meta_position',
			[
				'label'       => esc_html__( 'Meta Position', 'phox-host' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'default'     => 'before',
				'options'     => [
					'before'        => esc_html__( 'Before Title', 'phox-host' ),
					'after'         => esc_html__( 'After Title', 'phox-host' ),
					'after-excerpt' => esc_html__( 'After Excerpt', 'phox-host' ),
				],
				'condition'   => [
					'show_meta' => 'yes',
					'list_post' => 'yes'
				],
			]
		);

		$this->add_control(
			'show_author',
			[
				'label'        => esc_html__( 'Show Post Author', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'phox-host' ),
				'label_off'    => esc_html__( 'Hide', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_meta' => 'yes',
					'list_post' => 'yes'
				],
			]
		);

		$this->add_control(
			'show_author_icon',
			[
				'type'      => Controls_Manager::ICONS,
				'label'     => esc_html__( 'Author Icon', 'phox-host' ),
				'default'   => [
				        'value' =>'fas fa-user'
                ],
				'condition' => [
					'show_meta'   => 'yes',
					'show_author' => 'yes',
					'list_post'   => 'yes'
				],
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'        => esc_html__( 'Show Post Date', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'phox-host' ),
				'label_off'    => esc_html__( 'Hide', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_meta' => 'yes',
					'list_post' => 'yes'
				],
			]
		);

		$this->add_control(
			'show_date_icon',
			[
				'type'      => Controls_Manager::ICONS,
				'label'     => esc_html__( 'Date Icon', 'phox-host' ),
				'default'   => [
				        'value' =>'fas fa-calendar'
                ],
				'condition' => [
					'show_meta' => 'yes',
					'show_date' => 'yes',
					'list_post' => 'yes'

				],
			]
		);

		$this->add_control(
			'show_comments',
			[
				'label'        => esc_html__( 'Show Post Comments', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'phox-host' ),
				'label_off'    => esc_html__( 'Hide', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'show_meta' => 'yes',
					'list_post' => 'yes'

				],
			]
		);

		$this->add_control(
			'show_comments_icon',
			[
				'type'      => Controls_Manager::ICONS,
				'label'     => esc_html__( 'Comments Icon', 'phox-host' ),
				'default'   => [
				        'value' =>'fas fa-comments'
                ],
				'condition' => [
					'show_meta'     => 'yes',
					'show_comments' => 'yes',
					'list_post' => 'yes'
				],
			]
		);

		$this->add_control(
			'show_terms',
			[
				'label'        => esc_html__( 'Show Post Terms', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
				'condition'    => [
					'list_post' => 'yes'
				]
			]
		);

		$this->add_control(
			'show_terms_tax',
			[
				'label'     => esc_html__( 'Show Terms From', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'category',
				'options'   => $this->get_post_taxonomies(),
				'condition' => [
					'show_terms' => 'yes',
					'list_post'  => 'yes'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'filter_section',
			[
				'label' => esc_html__( 'Filter', 'phox-host' ),
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'   => esc_html__( 'Post Type', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => $this->get_post_types(),
			]
		);

		$this->add_control(
			'filter_by',
			[
				'label'     => esc_html__( 'Filter Posts By', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'category',
				'options'   => [
					'all'      => esc_html__( 'All', 'phox-host' ),
					'category' => esc_html__( 'Category', 'phox-host' ),
					'post_tag' => esc_html__( 'Tags', 'phox-host' ),
					'ids'      => esc_html__( 'IDs', 'phox-host' ),
				],
				'condition' => [
					'post_type' => 'post'
				]
			]
		);

		$this->add_control(
			'category_ids',
			[
				'label'       => esc_html__( 'Categories', 'phox-host' ),
				'description' => esc_html__( 'Get posts from specifies categories', 'phox-host' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => [ ' ' ],
				'options'     => $this->get_terms( 'category' ),
				'condition'   => [
					'post_type' => 'post',
					'filter_by' => 'category',
				],
			]
		);

		$this->add_control(
			'post_tag_ids',
			[
				'label'       => esc_html__( 'Tags', 'phox-host' ),
				'description' => esc_html__( 'Get posts from specifies Tags', 'phox-host' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'default'     => [ ' ' ],
				'options'     => $this->get_terms( 'post_tag' ),
				'condition'   => [
					'post_type' => 'post',
					'filter_by' => 'post_tag',
				],
			]
		);

		$this->add_control(
			'include_ids',
			[
				'type'        => 'text',
				'label'       => esc_html__( 'Set comma separated IDs list (10, 22, 19 etc.)', 'phox-host' ),
				'default'     => '',
				'label_block' => true,
				'condition'   => [
					'post_type' => 'post',
					'filter_by' => 'ids',
				],
			]
		);

		$this->add_control(
			'posts_ids',
			[
				'label'       => esc_html__( 'Posts IDs', 'phox-host' ),
				'description' => esc_html__( 'Sets comma separated IDs list (10, 20 etc.)', 'phox-host' ),
				'type'        => Controls_Manager::TEXT,
				'multiple'    => true,
				'default'     => '',
				'condition'   => [
					'filter_by' => 'ids',
				],
			]
		);

		$this->add_control(
			'custom_query_by',
			[
				'label'     => esc_html__( 'Query Custom Posts By', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'all',
				'options'   => [
					'all' => esc_html__( 'All', 'phox-host' ),
					'ids' => esc_html__( 'IDs', 'phox-host' ),
				],
				'condition' => [
					'post_type' => 'page',
				],
			]
		);

		$this->add_control(
			'post_ids',
			[
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__( 'Set comma separated IDs list (10, 22, 19 etc.)', 'phox-host' ),
				'default'     => '',
				'label_block' => true,
				'condition'   => [
					'post_type!'      => 'post',
					'custom_query_by' => 'ids',
				],
			]
		);

		$this->add_control(
			'exclude_ids',
			[
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => esc_html__( 'If this is used with query posts by ID, it will be ignored', 'phox-host' ),
				'label'       => esc_html__( 'Exclude posts by IDs (eg. 10, 22, 19 etc.)', 'phox-host' ),
				'default'     => '',
			]
		);

		$this->add_control(
			'meta_query',
			array(
				'label'        => esc_html__( 'Filter by Custom Field', 'phox-host' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'phox-host' ),
				'label_off'    => esc_html__( 'No', 'phox-host' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'meta_key',
			array(
				'type'        => 'text',
				'label_block' => true,
				'label'       => esc_html__( 'Custom Field Key', 'phox-host' ),
				'default'     => '',
				'condition'   => array(
					'meta_query'           => 'yes',
				),
			)
		);

		$this->add_control(
			'meta_value',
			array(
				'type'        => 'text',
				'label_block' => true,
				'label'       => esc_html__( 'Custom Field Value', 'phox-host' ),
				'default'     => '',
				'condition'   => array(
					'meta_query'           => 'yes',
				),
			)
		);
		
		$this->add_control(
			'order_by',
			[
				'label'   => esc_html__( 'Order by', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'            => esc_html__( 'Date', 'phox-host' ),
					'menu_order'      => esc_html__( 'Menu Order', 'phox-host' ),
					'title'           => esc_html__( 'Title', 'phox-host' ),
					'ID'              => esc_html__( 'ID', 'phox-host' ),
					'rand'            => esc_html__( 'Random', 'phox-host' ),
					'comment_count'   => esc_html__( 'Comments', 'phox-host' ),
					'modified'        => esc_html__( 'Date Modified', 'phox-host' ),
					'author'          => esc_html__( 'Author', 'phox-host' ),
				],
                'separator' => 'before'
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'phox-host' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => esc_html__( 'Descending', 'phox-host' ),
					'ASC'  => esc_html__( 'Ascending', 'phox-host' ),
				],

			]
		);

		$this->end_controls_section();

		//Style

		$this->start_controls_section(
			'section_posts_wrapper_style',
			[
				'label'      => esc_html__( 'Posts Wrapper', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'posts_wrapper_margin',
			[
				'label'      => esc_html__( 'Global Wrapper Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .wdes-posts-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'featured_post_margin',
			[
				'label'      => esc_html__( 'Featured Post Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .wdes-posts-list ' . $css_scheme['featured_post'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'posts_list_margin',
			[
				'label'      => esc_html__( 'Posts List Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .wdes-posts-list ' . $css_scheme['posts_list'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_featured_style',
			[
				'label'      => esc_html__( 'Featured', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'featured_post_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'featured_post_content_margin',
			[
				'label'      => esc_html__( 'Inner Content Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_content'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'featured_post_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['featured_post'],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'featured_post_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['featured_post'],
			]
		);

		$this->add_responsive_control(
			'featured_post_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'featured_post_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['featured_post'],
			]
		);

		$this->add_control(
			'featured_post_thumb_styles',
			[
				'label'     => esc_html__( 'Post Image', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'featured_post_thumb_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_image'] . ' a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'featured_post_thumb_overlay_styles',
			[
				'label'     => esc_html__( 'Post Image Overlay', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_overlay_style' );

		$this->start_controls_tab(
			'tab_overlay_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'overlay_background_normal',
				'selector' => '{{WRAPPER}} ' . $css_scheme['featured_post'] . ' .wdes-posts-block-list-featured-box-link:before, {{WRAPPER}} ' . $css_scheme['featured_post'] . ' .wdes-posts-block-list-post-thumbnail a:before'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_overlay_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'overlay_background_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['featured_post'] . ' .wdes-posts-block-list-featured-box-link:hover:before, {{WRAPPER}} ' . $css_scheme['featured_post'] . ' .wdes-posts-block-list-post-thumbnail a:hover:before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'featured_post_title_style',
			[
				'label'     => esc_html__( 'Post Title', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'featured_post_title_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_title'] . ' a' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['featured_post_title']        => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'featured_post_title_color_hover',
			[
				'label'     => esc_html__( 'Color Hover', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_title'] . ':hover a' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['featured_post_title'] . ':hover'   => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_post_title_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['featured_post_title'],
			]
		);

		$this->add_control(
			'featured_post_title_text_decoration_hover',
			[
				'label'       => esc_html__( 'Text Decoration Hover', 'phox-host' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'label_block' => true,
				'options'     => [
					''             => esc_html__( 'Default', 'phox-host' ),
					'underline'    => esc_html__( 'Underline', 'phox-host' ),
					'overline'     => esc_html__( 'Overline', 'phox-host' ),
					'line-through' => esc_html__( 'Line Through', 'phox-host' ),
					'none'         => esc_html__( 'None', 'phox-host' ),
				],
				'selectors'   => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_title'] . ':hover a' => 'text-decoration: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['featured_post_title'] . ':hover'   => 'text-decoration: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'featured_post_title_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'featured_post_title_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justify', 'phox-host' ),
						'icon'  => 'eicon-text-align-center',
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_title'] => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_post_text_style',
			[
				'label'     => esc_html__( 'Post Text', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'featured_post_text_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_text'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_post_text_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['featured_post_text'],
			]
		);

		$this->add_responsive_control(
			'featured_post_text_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_text'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'featured_post_text_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justify', 'phox-host' ),
						'icon'  => 'eicon-text-align-center',
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_text'] => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_featured_meta_style',
			[
				'label'      => esc_html__( 'Featured Post Meta', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'featured_meta_icon_size',
			[
				'label'      => esc_html__( 'Meta Icon Size', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 12,
						'max' => 90,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wdes-posts-block-list-wrap ' . $css_scheme['featured_post'] . ' .wdes-posts-block-list-featured-content .wdes-posts-block-list-meta ' . $css_scheme['meta_item'] . ' ' . '.wdes-posts-block-list-meta-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'featured_meta_icon_gap',
			[
				'label'      => esc_html__( 'Meta Icon Gap', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 90,
					],
				],
				'selectors'  => [
					'body:not(.rtl) {{WRAPPER}} ' . $css_scheme['featured_post'] . ' .wdes-posts-block-list-featured-content .wdes-posts-block-list-meta ' . $css_scheme['meta_item'] . ' .wdes-posts-block-list-meta-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} ' . $css_scheme['featured_post'] . ' .wdes-posts-block-list-featured-content .wdes-posts-block-list-meta ' . $css_scheme['meta_item'] . ' .wdes-posts-block-list-meta-icon'       => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'featured_meta_bg',
			[
				'label'     => esc_html__( 'Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . ' ' . $css_scheme['meta_wrap'] => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'featured_meta_color',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} ' . ' ' . $css_scheme['meta_wrap'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'featured_meta_link_color',
			[
				'label'     => esc_html__( 'Links Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'featured_layout!' => 'boxed',
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-posts-block-list-wrap .wdes-posts-list ' . $css_scheme['featured_post'] . ' .wdes-posts-block-list-featured-content ' . $css_scheme['meta'] . ' a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'featured_meta_link_color_hover',
			[
				'label'     => esc_html__( 'Links Hover Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'featured_layout!' => 'boxed',
				],
				'selectors' => [
					'{{WRAPPER}} .wdes-posts-block-list-wrap .wdes-posts-list ' . $css_scheme['featured_post'] . ' .wdes-posts-block-list-featured-content ' . $css_scheme['meta'] . ' a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_meta_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . ' ' . $css_scheme['meta_wrap'],
			]
		);

		$this->add_responsive_control(
			'featured_meta_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . ' ' . $css_scheme['meta_wrap'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'featured_meta_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . ' ' . $css_scheme['meta_wrap'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'featured_meta_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => [
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
				'selectors' => [
					'{{WRAPPER}} ' . ' ' . $css_scheme['meta_wrap'] => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_meta_divider',
			[
				'label'     => esc_html__( 'Meta Divider', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wdes-posts-block-list-wrap .wdes-posts-list ' . $css_scheme['featured_post'] . ' .wdes-posts-block-list-featured-content .wdes-posts-block-list-meta ' . $css_scheme['meta_item'] . ':not(:first-child):before' => 'content: "{{VALUE}}";',
				],
			]
		);

		$this->add_responsive_control(
			'featured_meta_divider_gap',
			[
				'label'      => esc_html__( 'Divider Gap', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 90,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wdes-posts-block-list-wrap .wdes-posts-list ' . $css_scheme['featured_post'] . ' .wdes-posts-block-list-featured-content .wdes-posts-block-list-meta ' . $css_scheme['meta_item'] . ':not(:first-child):before' => 'margin-left: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_featured_button_style',
			[
				'label'      => esc_html__( 'Featured Read More Button', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);


		$this->add_control(
			'button_icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 7,
						'max' => 90,
					],
				],
				'condition' => [
					'add_button_icon' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ' .wdes-posts-block-list-more-icon:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'add_button_icon' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ' .wdes-posts-block-list-more-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'button_icon_margin',
			[
				'label'      => esc_html__( 'Icon Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ' .wdes-posts-block-list-more-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'add_button_icon' => 'yes',
				]
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'button_bg',
			[
				'label'       => esc_html__( 'Background Type', 'phox-host' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'color'    => [
						'title' => esc_html__( 'Classic', 'phox-host' ),
						'icon'  => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'phox-host' ),
						'icon'  => 'eicon-barcode',
					],
				],
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'title'     => esc_html__( 'Background Color', 'phox-host' ),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color_stop',
			[
				'label'       => _x( 'Location', 'Background Control', 'phox-host' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'default'     => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition'   => [
					'button_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'button_bg_color_b',
			[
				'label'       => _x( 'Second Color', 'Background Control', 'phox-host' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => [
					'button_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'button_bg_color_b_stop',
			[
				'label'       => _x( 'Location', 'Background Control', 'phox-host' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'default'     => [
					'unit' => '%',
					'size' => 100,
				],
				'render_type' => 'ui',
				'condition'   => [
					'button_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'button_bg_gradient_type',
			[
				'label'       => _x( 'Type', 'Background Control', 'phox-host' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'linear' => esc_html__( 'Linear', 'phox-host' ),
					'radial' => esc_html__( 'Radial', 'phox-host' ),
				],
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => [
					'button_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'button_bg_gradient_angle',
			[
				'label'      => _x( 'Angle', 'Background Control', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default'    => [
					'unit' => 'deg',
					'size' => 180,
				],
				'range'      => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{button_bg_color.VALUE}} {{button_bg_color_stop.SIZE}}{{button_bg_color_stop.UNIT}}, {{button_bg_color_b.VALUE}} {{button_bg_color_b_stop.SIZE}}{{button_bg_color_b_stop.UNIT}})',
				],
				'condition'  => [
					'button_bg'               => [ 'gradient' ],
					'button_bg_gradient_type' => 'linear',
				],
				'of_type'    => 'gradient',
			]
		);

		$this->add_control(
			'button_bg_gradient_position',
			[
				'label'     => _x( 'Position', 'Background Control', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'center center' => esc_html__( 'Center Center', 'phox-host' ),
					'center left'   => esc_html__( 'Center Left', 'phox-host' ),
					'center right'  => esc_html__( 'Center Right', 'phox-host' ),
					'top center'    => esc_html__( 'Top Center', 'phox-host' ),
					'top left'      => esc_html__( 'Top Left', 'phox-host' ),
					'top right'     => esc_html__( 'Top Right', 'phox-host' ),
					'bottom center' => esc_html__( 'Bottom Center', 'phox-host' ),
					'bottom left'   => esc_html__( 'Bottom Left', 'phox-host' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'phox-host' ),
				],
				'default'   => 'center center',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{button_bg_color.VALUE}} {{button_bg_color_stop.SIZE}}{{button_bg_color_stop.UNIT}}, {{button_bg_color_b.VALUE}} {{button_bg_color_b_stop.SIZE}}{{button_bg_color_b_stop.UNIT}})',
				],
				'condition' => [
					'button_bg'               => [ 'gradient' ],
					'button_bg_gradient_type' => 'radial',
				],
				'of_type'   => 'gradient',
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['featured_post_button'],
			]
		);

		$this->add_control(
			'button_text_decor',
			[
				'label'     => esc_html__( 'Text Decoration', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'      => esc_html__( 'None', 'phox-host' ),
					'underline' => esc_html__( 'Underline', 'phox-host' ),
				],
				'default'   => 'none',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ' .wdes-posts-block-list-more-text' => 'text-decoration: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['featured_post_button'],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['featured_post_button'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'button_hover_bg',
			[
				'label'       => _x( 'Background Type', 'Background Control', 'phox-host' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'color'    => [
						'title' => esc_html__( 'Classic', 'phox-host' ),
						'icon'  => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'phox-host' ),
						'icon'  => 'eicon-barcode',
					],
				],
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			]
		);

		$this->add_control(
			'button_hover_bg_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'title'     => esc_html__( 'Background Color', 'phox-host' ),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ':hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_bg_color_stop',
			[
				'label'       => esc_html__( 'Location', 'phox-host' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'default'     => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition'   => [
					'button_hover_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'button_hover_bg_color_b',
			[
				'label'       => esc_html__( 'Second Color', 'phox-host' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => [
					'button_hover_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'button_hover_bg_color_b_stop',
			[
				'label'       => esc_html__( 'Location', 'phox-host' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'default'     => [
					'unit' => '%',
					'size' => 100,
				],
				'render_type' => 'ui',
				'condition'   => [
					'button_hover_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'button_hover_bg_gradient_type',
			[
				'label'       => esc_html__( 'Type', 'phox-host' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'linear' => esc_html__( 'Linear', 'phox-host' ),
					'radial' => esc_html__( 'Radial', 'phox-host' ),
				],
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => [
					'button_hover_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'button_hover_bg_gradient_angle',
			[
				'label'      => esc_html__( 'Angle', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default'    => [
					'unit' => 'deg',
					'size' => 180,
				],
				'range'      => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ':hover' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{button_hover_bg_color.VALUE}} {{button_hover_bg_color_stop.SIZE}}{{button_hover_bg_color_stop.UNIT}}, {{button_hover_bg_color_b.VALUE}} {{button_hover_bg_color_b_stop.SIZE}}{{button_hover_bg_color_b_stop.UNIT}})',
				],
				'condition'  => [
					'button_hover_bg'               => [ 'gradient' ],
					'button_hover_bg_gradient_type' => 'linear',
				],
				'of_type'    => 'gradient',
			]
		);

		$this->add_control(
			'button_hover_bg_gradient_position',
			[
				'label'     => esc_html__( 'Position', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'center center' => esc_html__( 'Center Center', 'phox-host' ),
					'center left'   => esc_html__( 'Center Left', 'phox-host' ),
					'center right'  => esc_html__( 'Center Right', 'phox-host' ),
					'top center'    => esc_html__( 'Top Center', 'phox-host' ),
					'top left'      => esc_html__( 'Top Left', 'phox-host' ),
					'top right'     => esc_html__( 'Top Right', 'phox-host' ),
					'bottom center' => esc_html__( 'Bottom Center', 'phox-host' ),
					'bottom left'   => esc_html__( 'Bottom Left', 'phox-host' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'phox-host' ),
				],
				'default'   => 'center center',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ':hover' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{button_hover_bg_color.VALUE}} {{button_hover_bg_color_stop.SIZE}}{{button_hover_bg_color_stop.UNIT}}, {{button_hover_bg_color_b.VALUE}} {{button_hover_bg_color_b_stop.SIZE}}{{button_hover_bg_color_b_stop.UNIT}})',
				],
				'condition' => [
					'button_hover_bg'               => [ 'gradient' ],
					'button_hover_bg_gradient_type' => 'radial',
				],
				'of_type'   => 'gradient',
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ':hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_hover_typography',
				'label'    => esc_html__( 'Typography', 'phox-host' ),
				'selector' => '{{WRAPPER}}  ' . $css_scheme['featured_post_button'] . ':hover',
			]
		);

		$this->add_control(
			'button_hover_text_decor',
			[
				'label'     => esc_html__( 'Text Decoration', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'      => esc_html__( 'None', 'phox-host' ),
					'underline' => esc_html__( 'Underline', 'phox-host' ),
				],
				'default'   => 'none',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ':hover .wdes-posts-block-list-more-text' => 'text-decoration: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'button_hover_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_hover_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'button_hover_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ':hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['featured_post_button'] . ':hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'flex-start',
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_post'] . ' .wdes-posts-block-list-more-wrap' => 'justify-content: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_featured_terms_link_style',
			[
				'label'      => esc_html__( 'Featured Terms Links', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'featured_terms_link_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_terms_link'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_featured_terms_link_style' );

		$this->start_controls_tab(
			'tab_featured_terms_link_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'featured_terms_link_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'title'     => esc_html__( 'Background Color', 'phox-host' ),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_terms_link'] => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_terms_link_color',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_terms_link'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_terms_link_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['featured_terms_link'],
			]
		);

		$this->add_control(
			'featured_terms_link_text_decor',
			[
				'label'     => esc_html__( 'Text Decoration', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'      => esc_html__( 'None', 'phox-host' ),
					'underline' => esc_html__( 'Underline', 'phox-host' ),
				],
				'default'   => 'none',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_terms_link'] . '' => 'text-decoration: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'featured_terms_link_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_terms_link'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'featured_terms_link_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['featured_terms_link'],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'featured_terms_link_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['featured_terms_link'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_featured_terms_link_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'featured_terms_link_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'title'     => esc_html__( 'Background Color', 'phox-host' ),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_terms_link'] . ':hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_terms_link_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_terms_link'] . ':hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'featured_terms_link_hover_typography',
				'label'    => esc_html__( 'Typography', 'phox-host' ),
				'selector' => '{{WRAPPER}}  ' . $css_scheme['featured_terms_link'] . ':hover',
			]
		);

		$this->add_control(
			'featured_terms_link_hover_text_decor',
			[
				'label'     => esc_html__( 'Text Decoration', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'      => esc_html__( 'None', 'phox-host' ),
					'underline' => esc_html__( 'Underline', 'phox-host' ),
				],
				'default'   => 'none',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['featured_terms_link'] . ':hover' => 'text-decoration: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'featured_terms_link_hover_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_terms_link'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'featured_terms_link_hover_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['featured_terms_link'] . ':hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'featured_terms_link_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['featured_terms_link'] . ':hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'featured_terms_link_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['featured_terms_link'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_style',
			[
				'label'      => esc_html__( 'Post', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'post_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_margin',
			[
				'label'       => esc_html__( 'Margin', 'phox-host' ),
				'type'        => Controls_Manager::DIMENSIONS,
				'size_units'  => [ 'px', '%', 'em' ],
				'device_args' => [
					Controls_Stack::RESPONSIVE_DESKTOP => [
						'selectors' => [
							'{{WRAPPER}} ' . $css_scheme['post']         => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; max-width: calc( 100%/{{posts_columns.VALUE}} - {{RIGHT}}{{UNIT}} - {{LEFT}}{{UNIT}} );',
							'(tablet){{WRAPPER}} ' . $css_scheme['post'] => 'max-width: calc( 100%/{{posts_columns_tablet.VALUE}} - {{RIGHT}}{{UNIT}} - {{LEFT}}{{UNIT}} );',
							'(mobile){{WRAPPER}} ' . $css_scheme['post'] => 'max-width: calc( 100%/{{posts_columns_mobile.VALUE}} - {{RIGHT}}{{UNIT}} - {{LEFT}}{{UNIT}} );',
						],
					],
					Controls_Stack::RESPONSIVE_TABLET  => [
						'selectors' => [
							'{{WRAPPER}} ' . $css_scheme['post']                                    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; max-width: calc( 100%/{{posts_columns.VALUE}} - {{RIGHT}}{{UNIT}} - {{LEFT}}{{UNIT}} );',
							'{{WRAPPER}} [class*="columns-tablet-"] ' . $css_scheme['post']         => 'max-width: calc( 100%/{{posts_columns_tablet.VALUE}} - {{RIGHT}}{{UNIT}} - {{LEFT}}{{UNIT}} );',
							'(mobile){{WRAPPER}} [class*="columns-tablet-"] ' . $css_scheme['post'] => 'max-width: calc( 100%/{{posts_columns_mobile.VALUE}} - {{RIGHT}}{{UNIT}} - {{LEFT}}{{UNIT}} );',
						],
					],
					Controls_Stack::RESPONSIVE_MOBILE  => [
						'selectors' => [
							'{{WRAPPER}} ' . $css_scheme['post']                            => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; max-width: calc( 100%/{{posts_columns.VALUE}} - {{RIGHT}}{{UNIT}} - {{LEFT}}{{UNIT}} );',
							'{{WRAPPER}} [class*="columns-tablet-"] ' . $css_scheme['post'] => 'max-width: calc( 100%/{{posts_columns_tablet.VALUE}} - {{RIGHT}}{{UNIT}} - {{LEFT}}{{UNIT}} );',
							'{{WRAPPER}} [class*="columns-mobile-"] ' . $css_scheme['post'] => 'max-width: calc( 100%/{{posts_columns_mobile.VALUE}} - {{RIGHT}}{{UNIT}} - {{LEFT}}{{UNIT}} );',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'post_content_margin',
			[
				'label'      => esc_html__( 'Inner Content Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post_content'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'post_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['post'],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'post_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['post'],
			]
		);

		$this->add_responsive_control(
			'post_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'post_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['post'],
			]
		);

		$this->add_control(
			'post_thumb_styles',
			[
				'label'     => esc_html__( 'Post Image', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'post_thumb_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post_image'] . ' a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'post_thumb_overlay_styles',
			[
				'label'     => esc_html__( 'Post Image Overlay', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_post_overlay_style' );

		$this->start_controls_tab(
			'tab_post_overlay_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'post_overlay_background_normal',
				'selector' => '{{WRAPPER}} ' . $css_scheme['post'] . ' .wdes-posts-block-list-post-thumbnail a:before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_post_overlay_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'post_overlay_background_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['post'] . ' .posts-block-list-post-thumbnail a:hover:before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'post_title_style',
			[
				'label'     => esc_html__( 'Post Title', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'post_title_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_title'] . ' a' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['post_title']        => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'post_title_color_hover',
			[
				'label'     => esc_html__( 'Color Hover', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_title'] . ':hover a' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['post_title'] . ':hover'   => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_title_typography',
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['post_title'],
			]
		);

		$this->add_control(
			'post_title_text_decoration_hover',
			[
				'label'       => esc_html__( 'Text Decoration Hover', 'phox-host' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '',
				'label_block' => true,
				'options'     => [
					''             => esc_html__( 'Default', 'phox-host' ),
					'underline'    => esc_html__( 'Underline', 'phox-host' ),
					'overline'     => esc_html__( 'Overline', 'phox-host' ),
					'line-through' => esc_html__( 'Line Through', 'phox-host' ),
					'none'         => esc_html__( 'None', 'phox-host' ),
				],
				'selectors'   => [
					'{{WRAPPER}} ' . $css_scheme['post_title'] . ':hover a' => 'text-decoration: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['post_title'] . ':hover'   => 'text-decoration: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'post_title_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post_title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_title_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justify', 'phox-host' ),
						'icon'  => 'eicon-text-align-center',
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_title'] => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'post_text_style',
			[
				'label'     => esc_html__( 'Post Text', 'phox-host' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'post_text_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_text'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_text_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['post_text'],
			]
		);

		$this->add_responsive_control(
			'post_text_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post_text'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_text_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'center'  => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'right'   => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justify', 'phox-host' ),
						'icon'  => 'eicon-text-align-center',
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_text'] => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_meta_style',
			[
				'label'      => esc_html__( 'Post Meta', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'meta_icon_size',
			[
				'label'      => esc_html__( 'Meta Icon Size', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 12,
						'max' => 90,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta_item'] . ' .wdes-posts-block-list-meta-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'meta_icon_gap',
			[
				'label'      => esc_html__( 'Meta Icon Gap', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 90,
					],
				],
				'selectors'  => [
					'body:not(.rtl) {{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta_item'] . ' .wdes-posts-block-list-meta-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta_item'] . ' .wdes-posts-block-list-meta-icon'       => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'meta_bg',
			[
				'label'     => esc_html__( 'Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta'] => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'meta_link_color',
			[
				'label'     => esc_html__( 'Links Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta'] . ' a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'meta_link_color_hover',
			[
				'label'     => esc_html__( 'Links Hover Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta'] . ' a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'meta_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta'],
			]
		);

		$this->add_responsive_control(
			'meta_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'meta_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'meta_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'options'   => [
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
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta'] => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_divider',
			[
				'label'     => esc_html__( 'Meta Divider', 'phox-host' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta_item'] . ':not(:first-child):before' => 'content: "{{VALUE}}";',
				],
			]
		);

		$this->add_responsive_control(
			'meta_divider_gap',
			[
				'label'      => esc_html__( 'Divider Gap', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 90,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post'] . ' ' . $css_scheme['meta_item'] . ':not(:first-child):before' => 'margin-left: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_post_button_style',
			[
				'label'      => esc_html__( 'Post Read More Button', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);



		$this->add_control(
			'post_button_icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'phox-host' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 7,
						'max' => 90,
					],
				],
				'condition' => [
					'post_add_button_icon' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] . ' .wdes-posts-block-list-more-icon:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'post_button_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'post_add_button_icon' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] . ' .wdes-posts-block-list-more-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'post_button_icon_margin',
			[
				'label'      => esc_html__( 'Icon Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] . ' .wdes-posts-block-list-more-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
                'condition' => [
					'post_add_button_icon' => 'yes',
				]
			]
		);

		$this->start_controls_tabs( 'tabs_post_button_style' );

		$this->start_controls_tab(
			'tab_post_button_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'post_button_bg',
			[
				'label'       => esc_html__( 'Background Type', 'phox-host' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'color'    => [
						'title' => esc_html__( 'Classic', 'phox-host' ),
						'icon'  => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'phox-host' ),
						'icon'  => 'eicon-barcode',
					],
				],
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			]
		);

		$this->add_control(
			'post_button_bg_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'title'     => esc_html__( 'Background Color', 'phox-host' ),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'post_button_bg_color_stop',
			[
				'label'       => esc_html__( 'Location', 'phox-host' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'default'     => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition'   => [
					'post_button_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'post_button_bg_color_b',
			[
				'label'       => esc_html__( 'Second Color', 'phox-host' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => [
					'post_button_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'post_button_bg_color_b_stop',
			[
				'label'       => esc_html__( 'Location', 'phox-host' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'default'     => [
					'unit' => '%',
					'size' => 100,
				],
				'render_type' => 'ui',
				'condition'   => [
					'post_button_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'post_button_bg_gradient_type',
			[
				'label'       => esc_html__( 'Type', 'phox-host' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'linear' => esc_html__( 'Linear', 'phox-host' ),
					'radial' => esc_html__( 'Radial', 'phox-host' ),
				],
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => [
					'post_button_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'post_button_bg_gradient_angle',
			[
				'label'      => esc_html__( 'Angle', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default'    => [
					'unit' => 'deg',
					'size' => 180,
				],
				'range'      => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{post_button_bg_color.VALUE}} {{post_button_bg_color_stop.SIZE}}{{post_button_bg_color_stop.UNIT}}, {{post_button_bg_color_b.VALUE}} {{post_button_bg_color_b_stop.SIZE}}{{post_button_bg_color_b_stop.UNIT}})',
				],
				'condition'  => [
					'post_button_bg'               => [ 'gradient' ],
					'post_button_bg_gradient_type' => 'linear',
				],
				'of_type'    => 'gradient',
			]
		);

		$this->add_control(
			'post_button_bg_gradient_position',
			[
				'label'     => esc_html__( 'Position', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'center center' => esc_html__( 'Center Center', 'phox-host' ),
					'center left'   => esc_html__( 'Center Left', 'phox-host' ),
					'center right'  => esc_html__( 'Center Right', 'phox-host' ),
					'top center'    => esc_html__( 'Top Center', 'phox-host' ),
					'top left'      => esc_html__( 'Top Left', 'phox-host' ),
					'top right'     => esc_html__( 'Top Right', 'phox-host' ),
					'bottom center' => esc_html__( 'Bottom Center', 'phox-host' ),
					'bottom left'   => esc_html__( 'Bottom Left', 'phox-host' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'phox-host' ),
				],
				'default'   => 'center center',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{post_button_bg_color.VALUE}} {{post_button_bg_color_stop.SIZE}}{{post_button_bg_color_stop.UNIT}}, {{post_button_bg_color_b.VALUE}} {{post_button_bg_color_b_stop.SIZE}}{{post_button_bg_color_b_stop.UNIT}})',
				],
				'condition' => [
					'post_button_bg'               => [ 'gradient' ],
					'post_button_bg_gradient_type' => 'radial',
				],
				'of_type'   => 'gradient',
			]
		);

		$this->add_control(
			'post_button_color',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_button_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['post_button'],
			]
		);

		$this->add_control(
			'post_button_text_decor',
			[
				'label'     => esc_html__( 'Text Decoration', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'      => esc_html__( 'None', 'phox-host' ),
					'underline' => esc_html__( 'Underline', 'phox-host' ),
				],
				'default'   => 'none',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] . ' .wdes-posts-block-list-more-text' => 'text-decoration: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'post_button_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'post_button_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['post_button'],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'post_button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['post_button'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_post_button_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'post_button_hover_bg',
			[
				'label'       => _x( 'Background Type', 'Background Control', 'phox-host' ),
				'type'        => Controls_Manager::CHOOSE,
				'options'     => [
					'color'    => [
						'title' => esc_html__( 'Classic', 'phox-host' ),
						'icon'  => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'phox-host' ),
						'icon'  => 'eicon-barcode',
					],
				],
				'default'     => 'color',
				'label_block' => false,
				'render_type' => 'ui',
			]
		);

		$this->add_control(
			'post_button_hover_bg_color',
			[
				'label'     => esc_html__( 'Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'title'     => esc_html__( 'Background Color', 'phox-host' ),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] . ':hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'post_button_hover_bg_color_stop',
			[
				'label'       => esc_html__( 'Location', 'phox-host' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'default'     => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition'   => [
					'post_button_hover_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'post_button_hover_bg_color_b',
			[
				'label'       => esc_html__( 'Second Color', 'phox-host' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => [
					'post_button_hover_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'post_button_hover_bg_color_b_stop',
			[
				'label'       => esc_html__( 'Location', 'phox-host' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%' ],
				'default'     => [
					'unit' => '%',
					'size' => 100,
				],
				'render_type' => 'ui',
				'condition'   => [
					'post_button_hover_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'post_button_hover_bg_gradient_type',
			[
				'label'       => esc_html__( 'Type', 'phox-host' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'linear' => esc_html__( 'Linear', 'phox-host' ),
					'radial' => esc_html__( 'Radial', 'phox-host' ),
				],
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => [
					'post_button_hover_bg' => [ 'gradient' ],
				],
				'of_type'     => 'gradient',
			]
		);

		$this->add_control(
			'post_button_hover_bg_gradient_angle',
			[
				'label'      => esc_html__( 'Angle', 'phox-host' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default'    => [
					'unit' => 'deg',
					'size' => 180,
				],
				'range'      => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] . ':hover' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{post_button_hover_bg_color.VALUE}} {{post_button_hover_bg_color_stop.SIZE}}{{post_button_hover_bg_color_stop.UNIT}}, {{post_button_hover_bg_color_b.VALUE}} {{post_button_hover_bg_color_b_stop.SIZE}}{{post_button_hover_bg_color_b_stop.UNIT}})',
				],
				'condition'  => [
					'post_button_hover_bg'               => [ 'gradient' ],
					'post_button_hover_bg_gradient_type' => 'linear',
				],
				'of_type'    => 'gradient',
			]
		);

		$this->add_control(
			'post_button_hover_bg_gradient_position',
			[
				'label'     => _x( 'Position', 'Background Control', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'center center' => esc_html__( 'Center Center', 'phox-host' ),
					'center left'   => esc_html__( 'Center Left', 'phox-host' ),
					'center right'  => esc_html__( 'Center Right', 'phox-host' ),
					'top center'    => esc_html__( 'Top Center', 'phox-host' ),
					'top left'      => esc_html__( 'Top Left', 'phox-host' ),
					'top right'     => esc_html__( 'Top Right', 'phox-host' ),
					'bottom center' => esc_html__( 'Bottom Center', 'phox-host' ),
					'bottom left'   => esc_html__( 'Bottom Left', 'phox-host' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'phox-host' ),
				],
				'default'   => 'center center',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] . ':hover' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{post_button_hover_bg_color.VALUE}} {{post_button_hover_bg_color_stop.SIZE}}{{post_button_hover_bg_color_stop.UNIT}}, {{post_button_hover_bg_color_b.VALUE}} {{post_button_hover_bg_color_b_stop.SIZE}}{{post_button_hover_bg_color_b_stop.UNIT}})',
				],
				'condition' => [
					'post_button_hover_bg'               => [ 'gradient' ],
					'post_button_hover_bg_gradient_type' => 'radial',
				],
				'of_type'   => 'gradient',
			]
		);

		$this->add_control(
			'post_button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] . ':hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'post_button_hover_typography',
				'label'    => esc_html__( 'Typography', 'phox-host' ),
				'selector' => '{{WRAPPER}}  ' . $css_scheme['post_button'] . ':hover',
			]
		);

		$this->add_control(
			'post_button_hover_text_decor',
			[
				'label'     => esc_html__( 'Text Decoration', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'      => esc_html__( 'None', 'phox-host' ),
					'underline' => esc_html__( 'Underline', 'phox-host' ),
				],
				'default'   => 'none',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] . ':hover ..wdes-posts-block-list-more-text' => 'text-decoration: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'post_button_hover_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'post_button_hover_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['post_button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'post_button_hover_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['post_button'] . ':hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'post_button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['post_button'] . ':hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'post_button_alignment',
			[
				'label'     => esc_html__( 'Alignment', 'phox-host' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'flex-start',
				'options'   => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'phox-host' ),
						'icon'  => 'eicon-arrow-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'phox-host' ),
						'icon'  => 'eicon-text-align-justify',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'phox-host' ),
						'icon'  => 'eicon-arrow-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['post'] . ' .wdes-posts-block-list-more-wrap' => 'justify-content: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_terms_link_style',
			[
				'label'      => esc_html__( 'Terms Links', 'phox-host' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_responsive_control(
			'terms_link_padding',
			[
				'label'      => esc_html__( 'Padding', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['terms_link'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_terms_link_style' );

		$this->start_controls_tab(
			'tab_terms_link_normal',
			[
				'label' => esc_html__( 'Normal', 'phox-host' ),
			]
		);

		$this->add_control(
			'terms_link_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'title'     => esc_html__( 'Background Color', 'phox-host' ),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['terms_link'] => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'terms_link_color',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['terms_link'] => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'terms_link_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['terms_link'],
			]
		);

		$this->add_control(
			'terms_link_text_decor',
			[
				'label'     => esc_html__( 'Text Decoration', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'      => esc_html__( 'None', 'phox-host' ),
					'underline' => esc_html__( 'Underline', 'phox-host' ),
				],
				'default'   => 'none',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['terms_link'] . '' => 'text-decoration: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'terms_link_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['terms_link'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'terms_link_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['terms_link'],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'terms_link_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['terms_link'],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_terms_link_hover',
			[
				'label' => esc_html__( 'Hover', 'phox-host' ),
			]
		);

		$this->add_control(
			'terms_link_hover_bg_color',
			[
				'label'     => esc_html__( 'Background Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'scheme'    => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'title'     => esc_html__( 'Background Color', 'phox-host' ),
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['terms_link'] . ':hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'terms_link_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'phox-host' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['terms_link'] . ':hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'terms_link_hover_typography',
				'label'    => esc_html__( 'Typography', 'phox-host' ),
				'selector' => '{{WRAPPER}}  ' . $css_scheme['terms_link'] . ':hover',
			]
		);

		$this->add_control(
			'terms_link_hover_text_decor',
			[
				'label'     => esc_html__( 'Text Decoration', 'phox-host' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'none'      => esc_html__( 'None', 'phox-host' ),
					'underline' => esc_html__( 'Underline', 'phox-host' ),
				],
				'default'   => 'none',
				'selectors' => [
					'{{WRAPPER}} ' . $css_scheme['terms_link'] . ':hover' => 'text-decoration: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'terms_link_hover_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['terms_link'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'terms_link_hover_border',
				'label'       => esc_html__( 'Border', 'phox-host' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['terms_link'] . ':hover',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'terms_link_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['terms_link'] . ':hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'terms_link_margin',
			[
				'label'      => esc_html__( 'Margin', 'phox-host' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} ' . $css_scheme['terms_link'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
     * Load All Image Sizes
     *
	 * @return array
	 */
	public function get_image_sizes() {

		global $_wp_additional_image_sizes;

		$sizes  = get_intermediate_image_sizes();
		$result = [];

		foreach ( $sizes as $size ) {
			if ( in_array( $size, [ 'thumbnail', 'medium', 'medium_large', 'large' ] ) ) {
				$result[ $size ] = ucwords( trim( str_replace( [ '-', '_' ], [ ' ', ' ' ], $size ) ) );
			} else {
				$result[ $size ] = sprintf(
					'%1$s (%2$sx%3$s)',
					ucwords( trim( str_replace( [ '-', '_' ], [ ' ', ' ' ], $size ) ) ),
					$_wp_additional_image_sizes[ $size ]['width'],
					$_wp_additional_image_sizes[ $size ]['width']
				);
			}
		}

		return array_merge( [ 'full' => esc_html__( 'Full', 'phox-host' ), 'custom' => esc_html__( 'Custom', 'phox-host' ) ], $result );
	}


	/**
     * Get Post Taxonomies
     *
	 * @return array
	 */
	public function get_post_taxonomies() {

		$post_types = $this->get_post_types();
		$result     = [];

		$deprecated = [ 'product_shipping_class' ];

		foreach ( $post_types as $type => $label ) {

			$taxonomies = get_object_taxonomies( $type, 'objects' );

			if ( ! empty( $taxonomies ) ) {
				foreach ( $taxonomies as $tax ) {

					if ( $tax->public && ! in_array( $tax->name, $deprecated ) ) {
						$result[ $tax->name ] = $tax->label;
					}
				}
			}

		}

		return $result;

	}

	/**
     * Get Post Types
     *
	 * @return array
	 */
	public function get_post_types() {

		$post_types = get_post_types( [ 'public' => true ], 'objects' );

		$deprecated = [ 'attachment', 'elementor_library' ];

		$result = [];

		if ( empty( $post_types ) ) {
			return $result;
		}

		foreach ( $post_types as $slug => $post_type ) {

			if ( in_array( $slug, $deprecated ) ) {
				continue;
			}

			$result[ $slug ] = $post_type->label;

		}

		return $result;
	}

	/**
	 * Get Terms
	 *
	 * Select the term and get all posts that this terms is having
	 *
	 * @param string $taxonomy (category, tags, id)
	 *
	 * @return array All Posts
	 */
	public function get_terms( $taxonomy = 'category' ) {

		$query = [
			'taxonomy'   => $taxonomy,
			'orderby'    => 'count',
			'hide_empty' => true,
		];

		$terms = get_terms( $query );

		$all_label = '';

		switch ( $taxonomy ) {
			case 'category':
				$all_label = esc_html__( 'All Category', 'phox-host' );
				break;
			case 'post_tag':
				$all_label = esc_html__( 'All Tags', 'phox-host' );
				break;
		}

		$list = [ ' ' => $all_label ];

		foreach ( $terms as $key => $value ) {
			$list[ $value->term_id ] = $value->name;
		}

		return $list;

	}

	/**
	 * Return taxonomies list for filter
	 *
	 * @return array
	 */
	public function get_filter_taxonomies() {

		$allowed_types = [ 'post' ];
		$result        = [];

		foreach ( $allowed_types as $type ) {

			$taxonomies = get_object_taxonomies( $type, 'objects' );

			if ( ! empty( $taxonomies ) ) {
				foreach ( $taxonomies as $tax ) {
					if ( $tax->public ) {
						$result[ $tax->name ] = $tax->label;
					}
				}
			}

		}

		if ( isset( $result['product_shipping_class'] ) ) {
			unset( $result['product_shipping_class'] );
		}

		return $result;

	}

	protected function render() {
		$this->settings = $this->get_settings();
		$this->get_posts();


		?>
        <div class="wdes-posts-block-list-wrap">
            <div class="<?php $this->posts_list_classes(); ?>">
				<?php
				$this->render_posts();
				?>
            </div>
        </div>
		<?php
	}

	/**
	 * Get Post
	 */
	public function get_posts() {

		$query_args = $this->get_query_args( $this->settings );

		$query = new \WP_Query( $query_args );
		$posts = ! empty( $query->posts ) ? $query->posts : [];
		$paged = isset( $query_args['paged'] ) ? absint( $query_args['paged'] ) : 1;

		$this->query_data['max_pages']    = $query->max_num_pages;
		$this->query_data['current_page'] = $paged;

		$this->set_query( $posts );

	}

	/**
     * Query Argument
     *
	 * @param $settings
	 *
	 * @return array
	 */
	public function get_query_args( $settings ) {

		$cols      = isset( $settings['posts_columns'] ) ? absint( $settings['posts_columns'] ) : 1;
		$rows      = ! empty( $settings['posts_rows'] ) ? absint( $settings['posts_rows'] ) : 3;
		$num       = $cols * $rows;
		$featured  = ! empty( $settings['featured_post'] ) ? true : false;
		$post_type = ! empty( $settings['post_type'] ) ? $settings['post_type'] : 'post';
		$exclude   = ! empty( $settings['exclude_ids'] ) ? $settings['exclude_ids'] : '';
		$include   = ! empty( $settings['include_ids'] ) ? $settings['include_ids'] : '';
		$order_by  = isset( $settings['order_by'] )  ? $settings['order_by'] : 'date' ;
		$order = isset( $settings['order'] ) ? $settings['order'] : 'DESC';

		if ( $featured ) {
			$num ++;
		}

		$query_args = [
			'posts_per_page'      => $num,
			'ignore_sticky_posts' => true,
			'post_status'         => 'publish',
			'paged'               => 1,
			'post_type'           => $post_type,
			'orderby'             => $order_by,
			'order'               => $order
		];

		$tax = $settings['filter_by'];

		if ( isset( $settings[ $tax . '_ids' ] ) && is_array( $settings[ $tax . '_ids' ] ) ) {
			$ids = array_filter( $settings[ $tax . '_ids' ] );
		} else {
			$ids = [];
		}

		if ( 'all' !== $tax && ! empty( $ids ) && 'post' === $post_type ) {
			$query_args['tax_query'] = [
				[
					'taxonomy' => $tax,
					'field'    => 'term_id',
					'terms'    => $settings[ $tax . '_ids' ],
				],
			];
		}

		if ( 'post' !== $post_type && ! empty( $settings['post_ids'] ) ) {
			$post_ids               = explode( ',', str_replace( ' ', '', $settings['post_ids'] ) );
			$query_args['post__in'] = $post_ids;
		}

		if ( 'post' === $post_type && 'ids' === $tax && ! empty( $include ) ) {
			$include_ids            = explode( ',', str_replace( ' ', '', $include ) );
			$query_args['post__in'] = $include_ids;
		}

		if ( ! empty( $exclude ) && empty( $query_args['post__in'] ) ) {
			$exclude_ids                = explode( ',', str_replace( ' ', '', $exclude ) );
			$query_args['post__not_in'] = $exclude_ids;
		}

		if ( isset( $settings['meta_query'] ) && 'yes' === $settings['meta_query'] ) {

			$meta_key   = ! empty( $settings['meta_key'] ) ? esc_attr( $settings['meta_key'] ) : false;
			$meta_value = ! empty( $settings['meta_value'] ) ? esc_attr( $settings['meta_value'] ) : '';

			if ( ! empty( $meta_key ) ) {
				$query_args['meta_key']   = $meta_key;
				$query_args['meta_value'] = $meta_value;
			}

		}

		return $query_args;

	}

	/**
	 * Show filters by categories or tags
	 *
	 * @return void
	 */
	public function get_filters() {

		$post_type = ! empty( $this->settings['post_type'] ) ? $this->settings['post_type'] : 'post';


		if ( 'post' === $post_type ) {

			$query_by = $this->settings['filter_by'];
			$args     = [ 'taxonomy' => $query_by ];

			if ( in_array( $query_by, [ 'all', 'ids' ] ) ) {
				$args['taxonomy'] = $this->settings['filter_by'];
			} elseif ( ! empty( $this->settings[ $query_by . '_ids' ] ) ) {
				$args['include'] = $this->settings[ $query_by . '_ids' ];
			}
		} else {
			$args = [ 'taxonomy' => $this->settings['filter_by'] ];

		}

		$terms = get_terms( $args );

		$items    = '';

		$item_format = '<div class="wdes-posts-block-list-filter-item"><a href="#" data-term="%1$s">%2$s</a></div>';


		foreach ( $terms as $term ) {
			$items .= sprintf( $item_format, $term->term_id, $term->name );
		}

	}

	/**
	 * Print string of posts wrapper classes
	 */
	public function posts_list_classes() {

		$classes = [ ' wdes-posts-list ' ];

		$columns    = $this->settings['posts_columns'];
		$classes [] = 'columns-' . $columns;
		$featured   = $this->settings['featured_post'];
		$rows       = ! empty( $this->settings['posts_rows'] ) ? absint( $this->settings['posts_rows'] ) : 3;
		$classes[]  = 'rows-' . $rows;

		if ( ! empty( $this->settings['posts_columns_tablet'] ) ) {
			$classes[] = 'columns-tablet-' . $this->settings['posts_columns_tablet'];
		}

		if ( ! empty( $this->settings['posts_columns_mobile'] ) ) {
			$classes[] = 'columns-mobile-' . $this->settings['posts_columns_mobile'];
		}

		if ( 'yes' === $featured ) {
			$classes[] = 'has-featured-position-' . $this->settings['featured_position'];
		} else {
			$classes[] = 'no-featured';
		}

		echo implode( ' ', $classes );

	}

	/**
	 * Render the Normal posts
	 */
	public function render_posts() {
		global $post;

		$meta_pos = isset( $this->settings['meta_position'] ) ? $this->settings['meta_position'] : 'after';

		//Load feature Post
		$this->adjust_query();

		//rebuild posts without feature post
		$query = $this->get_query();

		if ( empty( $query ) ) {
			wp_reset_postdata();

			return;
		}
		?>
		<?php if ( $this->settings['list_post'] === 'yes' ): ?>
            <div class="wdes-posts-block-list-posts">
				<?php
				foreach ( $query as $post ):
					setup_postdata( $post );
					$is_featured = false;
					?>
                    <div class="<?php $this->post_classes(); ?>">
						<?php $this->post_terms( $is_featured ); ?>
						<?php $this->featured_image( 'simple' ) ?>
                        <div class="wdes-posts-block-list-post-content">
							<?php $this->multi_post_content( 'simple', $meta_pos, $is_featured ); ?>
                        </div>
                    </div>
				<?php
				endforeach;
				wp_reset_postdata();
				?>
            </div>
		<?php endif; ?>
		<?php
	}

	/**
	 * Post adjust query
	 */
	public function adjust_query() {
		global $post;

		$query    = $this->get_query();
		$featured = $this->settings['featured_post'];
		if ( 'yes' === $featured && isset( $query[0] ) ):
			$this->set_query( [ $query[0] ] );
			foreach ( $this->get_query() as $post ):
				setup_postdata( $post );

				$layout            = $this->settings['featured_layout'];
				$featured_meta_pos = isset( $this->settings['featured_meta_position'] ) ? $this->settings['featured_meta_position'] : 'after';
				?>
                <div class="<?php $this->featured_post_classes(); ?>" <?php $this->get_item_thumbnail_bg(); ?> >
					<?php

					$is_featured = true;

					$this->post_terms( $is_featured );

					if ( 'simple' === $layout ) {
						$this->featured_image( 'featured' );
					} else {
						echo '<div class = "wdes-posts-block-list-featured-box-wrap">';
						printf( '<a href="%s" class="wdes-posts-block-list-featured-box-link" >', get_permalink() );
					}

					echo '<div class="wdes-posts-block-list-featured-content" >';
					$this->multi_post_content( 'featured', $featured_meta_pos, $is_featured );
					echo '</div>';

					if ( 'simple' !== $layout ) {
						echo '</a>';
						echo '</div>';
					}
					?>
                </div>
			<?php
			endforeach;
			unset( $query[0] );
			$this->set_query( $query );
		endif;
	}

	/**
     * Get Query
     *
	 * @return array
	 */
	public function get_query() {
		return $this->query;
	}

	/**
	 * Set posts query results
	 */
	public function set_query( $posts ) {
		$this->query = $posts;
	}

	/**
	 * Print string of featured post item classes
	 */
	public function featured_post_classes() {

		$classes  = [];
		$layout   = $this->settings['featured_layout'];
		$position = $this->settings['featured_position'];
		$img_pos  = $this->settings['featured_image_position'];

		$classes = array_merge(
			[
				'wdes-posts-block-list-featured',
				'featured-layout-' . $layout,
				'featured-position-' . $position,
			],
			$classes
		);

		if ( 'simple' === $layout ) {
			$classes[] = 'featured-img-' . $img_pos;
		}

		if ( has_post_thumbnail() ) {
			$classes[] = 'has-post-thumb';
		}

		echo esc_attr( implode( ' ', $classes ) );

	}

	/**
     * Get Item thumbnail background
     *
	 * Returns post thumbnail as backgroud if boxed layout was selected
	 */
	public function get_item_thumbnail_bg() {

		$layout = $this->settings['featured_layout'];
		$size   = $this->settings['featured_image_size'];


		if ( 'boxed' !== $layout ) {
			return;
		}

		if ( ! has_post_thumbnail() ) {
			return;
		}

		$url = wp_get_attachment_image_url( get_post_thumbnail_id(), $size );

		printf( ' style="background-image: url(\'%s\')"', $url );

	}

	/**
	 * Show post categories depends on settings
	 *
	 * @param boolean
	 *
	 * @return void|null
	 */
	public function post_terms( $is_featured = false ) {

		if ( $is_featured ) {
			$show_key = 'show_featured_terms';
			$tax_key  = 'show_featured_terms_tax';
		} else {
			$show_key = 'show_terms';
			$tax_key  = 'show_terms_tax';
		}

		$show = isset( $this->settings[ $show_key ] ) ? $this->settings[ $show_key ] : '';
		$tax  = isset( $this->settings[ $tax_key ] ) ? $this->settings[ $tax_key ] : '';

		if ( 'yes' !== $show ) {
			return;
		}

		$terms = wp_get_post_terms( get_the_ID(), esc_attr( $tax ) );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			return;
		}

		$num   = 1;
		$terms = array_slice( $terms, 0, $num );

		$format = '<a href="%2$s" class="wdes-posts-block-list-terms-link">%1$s</a>';

		$result = '';

		foreach ( $terms as $term ) {
			$result .= sprintf( $format, $term->name, get_term_link( (int) $term->term_id, $tax ) );
		}

		printf( '<div class="wdes-posts-block-list-terms">%s</div>', $result );

	}

	/**
	 * Featured image
	 *
	 * @param string $context Where image will be shown.
	 *
	 * @return void
	 */
	public function featured_image( $context = 'simple' ) {

		if ( ! has_post_thumbnail() ) {
			return;
		}

		switch ( $context ) {
			case 'featured':
				$size = $this->settings['featured_image_size'];
				break;

			default:
				$size = $this->settings['image_size'];
				if($size === 'custom'){
				   $size = [$this->settings['custom_image_size']['width'], $this->settings['custom_image_size']['height']];
                }
				break;
		}

		$show_image = isset( $this->settings['show_image'] ) ? $this->settings['show_image'] : '';

		if ( 'simple' === $context && 'yes' !== $show_image ) {
			return;
		}

		$class = 'wdes-posts-block-list-post-thumbnail-img post-thumbnail-img-' . $context;
		$img   = get_the_post_thumbnail(
			get_the_ID(),
			$size,
			[
				'class' => $class,
				'alt'   => esc_attr( get_the_title() ),
				'title' => esc_attr( get_the_title() ),
			]
		);

		$format = '<div class="wdes-posts-block-list-post-thumbnail post-thumbnail-%2$s"><a href="%3$s">%1$s</a></div>';


		printf( $format, $img, $context, get_permalink() );

	}

	/**
     * Multi Post Content
     *
	 * @param $context
	 * @param $featured_meta_pos
	 * @param $is_featured
	 */
	public function multi_post_content( $context, $featured_meta_pos, $is_featured ) {

		if ( 'before' === $featured_meta_pos ) {
			$this->post_meta_template( $is_featured );
		}

		$this->post_title( $context );

		if ( 'after' === $featured_meta_pos ) {
			$this->post_meta_template( $is_featured );
		}

		$this->post_excerpt( $context );

		if ( 'after-excerpt' === $featured_meta_pos ) {
			$this->post_meta_template( $is_featured );
		}

		$this->read_more( $context );
	}

	/**
	 * Post Meta (author, date, comment) Template
	 *
	 * @param bool $is_featured
	 */
	public function post_meta_template( $is_featured = false ) {

		$allowed = ( true === $is_featured ) ? 'featured_show_meta' : 'show_meta';

		if ( 'yes' !== $this->settings[ $allowed ] ) {
			return;
		}

		$meta_data = $this->get_meta( $is_featured );

		print ( '<div class="wdes-posts-block-list-meta" >' );

		$this->get_author( [
			'visible' => $meta_data['author']['visible'],
			'class'   => 'posted-by-author',
			'prefix'  => $meta_data['author']['prefix'],
			'html'    => $meta_data['author']['html'],
			'echo'    => true
		] );

		$this->get_date( [
			'visible' => $meta_data['date']['visible'],
			'class'   => 'posted-date-link',
			'icon'    => '',
			'prefix'  => $meta_data['date']['prefix'],
			'html'    => $meta_data['date']['html'],
			'echo'    => true
		] );

		$this->get_comment_count( [
			'visible' => $meta_data['comments']['visible'],
			'class'   => 'posted-comments-link',
			'icon'    => '',
			'prefix'  => $meta_data['comments']['prefix'],
			'html'    => $meta_data['comments']['html'],
			'echo'    => true
		] );

		print( '</div>' );
	}

	/**
	 * Get meta data array
	 *
	 * @param bool $is_featured
	 *
	 * @return array $result
	 */
	public function get_meta( $is_featured = false ) {

		$show = [
			'author'   => ( true === $is_featured ) ? 'featured_show_author' : 'show_author',
			'date'     => ( true === $is_featured ) ? 'featured_show_date' : 'show_date',
			'comments' => ( true === $is_featured ) ? 'featured_show_comments' : 'show_comments',
		];

		$html = [
			'author'   => [
				'featured_boxed' => '<span class="posted-by post-meta-item wdes-posts-block-list-meta-item">%1$s<span %3$s %4$s>%5$s%6$s</span></span>',
				'simple'         => '<span class="posted-by post-meta-item wdes-posts-block-list-meta-item">%1$s<a href="%2$s" %3$s %4$s rel="author">%5$s%6$s</a></span>',
			],
			'date'     => [
				'featured_boxed' => '<span class="post-date post-meta-item wdes-posts-block-list-meta-item">%1$s<span %3$s %4$s ><time datetime="%5$s" title="%5$s">%6$s%7$s</time></span></span>',
				'simple'         => '<span class="post-date post-meta-item wdes-posts-block-list-meta-item">%1$s<a href="%2$s" %3$s %4$s ><time datetime="%5$s" title="%5$s">%6$s%7$s</time></a></span>',
			],
			'comments' => [
				'featured_boxed' => '<span class="post-comments post-meta-item wdes-posts-block-list-meta-item">%1$s<span %3$s %4$s>%5$s%6$s</span></span>',
				'simple'         => '<span class="post-comments post-meta-item wdes-posts-block-list-meta-item">%1$s<a href="%2$s" %3$s %4$s>%5$s%6$s</a></span>',
			],
		];

		$icon_format     = '<i class="wdes-posts-block-list-meta-icon %s"></i>';
		$is_featured_box = false;
		$result          = [];

		if ( true === $is_featured && 'boxed' === $this->settings['featured_layout'] ) {
			$is_featured_box = true;
		}

		foreach ( $show as $key => $setting ) {

			$prefix = ( ! empty( $this->settings[ $setting . '_icon' ] ) ) ? sprintf( $icon_format, $this->settings[ $setting . '_icon' ]['value'] ) : '';

			if ( $is_featured_box ) {
				$current_html = $html[ $key ]['featured_boxed'];
			} else {
				$current_html = $html[ $key ]['simple'];
			}

			$current = [
				'visible' => $this->settings[ $setting ],
				'prefix'  => $prefix,
				'html'    => $current_html,
			];

			$result[ $key ] = $current;

		}

		return $result;

	}

	/**
	 * Get post author
	 *
	 * @return string
	 */
	public function get_author( $args = [], $id = 0 ) {
		$object = $this->get_post_object( $id );

		if ( empty( $object->ID ) ) {
			return false;
		}

		$default_args = [
			'visible' => 'true',
			'icon'    => '',
			'prefix'  => '',
			'html'    => '%1$s<a href="%2$s" %3$s %4$s rel="author">%5$s%6$s</a>',
			'title'   => '',
			'class'   => 'post-author',
			'echo'    => false,
		];
		$args         = wp_parse_args( $args, $default_args );
		$html         = '';

		if ( filter_var( $args['visible'], FILTER_VALIDATE_BOOLEAN ) ) {
			$html_class = ( $args['class'] ) ? 'class="' . $args['class'] . '"' : '';
			$title      = ( $args['title'] ) ? 'title="' . $args['title'] . '"' : '';
			$author     = get_the_author();
			$link       = get_author_posts_url( $object->post_author );

			$html = sprintf( $args['html'], $args['prefix'], $link, $title, $html_class, $args['icon'], $author );
		}

		return $this->output_method( $html, $args['echo'] );
	}

	/**
	 * Get post
	 *
	 * @return object
	 */
	public function get_post_object( $id = 0 ) {
		return get_post( $id );
	}

	/**
	 * Output content method.
	 *
	 * @return string
	 */
	public function output_method( $content = '', $echo = false ) {
		if ( ! filter_var( $echo, FILTER_VALIDATE_BOOLEAN ) ) {
			return $content;
		} else {
			echo $content;
		}
	}

	/**
	 * Get post date.
	 *
	 * @return string
	 * @since  1.0.0
	 */
	public function get_date( $args = [], $id = 0 ) {
		$object = $this->get_post_object( $id );

		if ( empty( $object->ID ) ) {
			return false;
		}

		$default_args = [
			'visible'     => true,
			'icon'        => '',
			'prefix'      => '',
			'html'        => '%1$s<a href="%2$s" %3$s %4$s ><time datetime="%5$s" title="%5$s">%6$s%7$s</time></a>',
			'title'       => '',
			'class'       => 'post-date',
			'date_format' => '',
			'human_time'  => false,
			'echo'        => false,
		];
		$args         = wp_parse_args( $args, $default_args );
		$html         = '';

		if ( filter_var( $args['visible'], FILTER_VALIDATE_BOOLEAN ) ) {
			$html_class       = ( $args['class'] ) ? 'class="' . esc_attr( $args['class'] ) . '"' : '';
			$title            = ( $args['title'] ) ? 'title="' . esc_attr( $args['title'] ) . '"' : '';
			$date_post_format = ( $args['date_format'] ) ? esc_attr( $args['date_format'] ) : get_option( 'date_format' );
			$date             = ( $args['human_time'] ) ? human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) : get_the_date( $date_post_format );
			$time             = get_the_time( 'Y-m-d\TH:i:sP' );

			preg_match_all( '/(\d+)/mi', $time, $date_array );
			$link = get_day_link( (int) $date_array[0][0], (int) $date_array[0][1], (int) $date_array[0][2] );

			$html = sprintf( $args['html'], $args['prefix'], $link, $title, $html_class, $time, $args['icon'], $date );
		}

		return $this->output_method( $html, $args['echo'] );
	}

	/**
	 * Get comment count
	 *
	 * @return string
	 */
	public function get_comment_count( $args = [], $id = 0 ) {
		$object = $this->get_post_object( $id );

		if ( empty( $object->ID ) ) {
			return false;
		}

		$default_args = [
			'visible' => true,
			'icon'    => '',
			'prefix'  => '',
			'suffix'  => '%s',
			'html'    => '%1$s<a href="%2$s" %3$s %4$s>%5$s%6$s</a>',
			'title'   => '',
			'class'   => 'post-comments-count',
			'echo'    => false,
		];

		$args = wp_parse_args( $args, $default_args );

		$args['suffix'] = ( isset( $args['sufix'] ) ) ? $args['sufix'] : $args['suffix'];

		$html  = '';
		$count = '';

		if ( filter_var( $args['visible'], FILTER_VALIDATE_BOOLEAN ) ) {
			$post_type = get_post_type( $object->ID );
			if ( post_type_supports( $post_type, 'comments' ) ) {
				$suffix = is_string( $args['suffix'] ) ? $args['suffix'] : translate_nooped_plural( $args['suffix'], $object->comment_count, 'phox-host' );
				$count  = sprintf( $suffix, $object->comment_count );
			}

			$html_class = ( $args['class'] ) ? 'class="' . $args['class'] . '"' : '';
			$title      = ( $args['title'] ) ? 'title="' . $args['title'] . '"' : '';
			$link       = get_comments_link();

			$html = sprintf( $args['html'], $args['prefix'], $link, $title, $html_class, $args['icon'], $count );
		}

		return $this->output_method( $html, $args['echo'] );
	}

	/**
	 * Post title.
	 *
	 * @param string $context Context.
	 *
	 * @return string
	 */
	public function post_title( $context = 'simple' ) {

		$layout = $this->settings['featured_layout'];

		$format = '<div class="wdes-posts-block-list-post-title post-title-%2$s">%1$s</div>';

		$title_text = $this->trim_title( get_the_title(), $context );

		switch ( $context ) {
			case 'featured':

				if ( 'boxed' === $layout ) {
					$title = sprintf( '%1$s', $title_text, get_permalink() );
				} else {
					$title = sprintf( '<a href="%2$s">%1$s</a>', $title_text, get_permalink() );
				}

				break;

			default:
				$title = sprintf( '<a href="%2$s">%1$s</a>', $title_text, get_permalink() );
				break;
		}

		$this->render_meta( 'title_related', 'wdes-title-fields', [ 'before' ], $this->settings );

		printf( $format, $title, $context );

		$this->render_meta( 'title_related', 'wdes-title-fields', [ 'after' ], $this->settings );

	}

	/**
	 * Trim post title.
	 *
	 * @param string $title Post title.
	 * @param string $context Context.
	 *
	 * @return string
	 */
	public function trim_title( $title, $context ) {

		switch ( $context ) {
			case 'featured':

				if ( ! isset( $this->settings['featured_title_length'] ) ) {
					return $title;
				}

				$length = absint( $this->settings['featured_title_length'] );

				break;

			default:
				if ( ! isset( $this->settings['title_length'] ) ) {
					return $title;
				}

				$length = absint( $this->settings['title_length'] );

				break;
		}

		if ( 0 === $length ) {
			return $title;
		}

		return wp_trim_words( $title, $length, '...' );

	}

	/**
	 * Render meta for passed position
	 *
	 * @param string $position
	 * @param string $base
	 * @param array $context
	 * @param array $settings
	 *
	 * @return void
	 */
	public function render_meta( $position = '', $base = '', $context = [ 'before' ], $settings = [] ) {

		$settings      = ! empty( $settings ) ? $settings : $this->get_settings();
		$config_key    = $position . '_meta';
		$show_key      = 'show_' . $position . '_meta';
		$position_key  = 'meta_' . $position . '_position';
		$meta_show     = ! empty( $settings[ $show_key ] ) ? $settings[ $show_key ] : false;
		$meta_position = ! empty( $settings[ $position_key ] ) ? $settings[ $position_key ] : false;
		$meta_config   = ! empty( $settings[ $config_key ] ) ? $settings[ $config_key ] : false;

		if ( 'yes' !== $meta_show ) {
			return;
		}

		if ( ! $meta_position || ! in_array( $meta_position, $context ) ) {
			return;
		}

		if ( empty( $meta_config ) ) {
			return;
		}

		$result = '';

		foreach ( $meta_config as $meta ) {

			if ( empty( $meta['meta_key'] ) ) {
				continue;
			}

			$key      = $meta['meta_key'];
			$callback = ! empty( $meta['meta_callback'] ) ? $meta['meta_callback'] : false;
			$value    = get_post_meta( get_the_ID(), $key, false );

			if ( ! $value ) {
				continue;
			}

			$callback_args = [ $value[0] ];

			if ( $callback && 'wp_get_attachment_image' === $callback ) {
				$callback_args[] = 'full';
			}

			if ( ! empty( $callback ) && is_callable( $callback ) ) {
				$meta_val = call_user_func_array( $callback, $callback_args );
			} else {
				$meta_val = $value[0];
			}

			$meta_val = sprintf( $meta['meta_format'], $meta_val );

			$label = ! empty( $meta['meta_label'] )
				? sprintf( '<div class="%1$s-item-label">%2$s</div>', $base, $meta['meta_label'] )
				: '';

			$result .= sprintf(
				'<div class="%1$s-item">%2$s<div class="%1$s-item-value">%3$s</div></div>',
				$base, $label, $meta_val
			);

		}

		if ( empty( $result ) ) {
			return;
		}

		printf( '<div class="%1$s">%2$s</div>', $base, $result );

	}

	/**
	 * Show post excerpt.
	 *
	 * @param string $context Context.
	 */
	public function post_excerpt( $context = 'simple' ) {

		$excerpt = has_excerpt( get_the_ID() ) ? apply_filters( 'the_excerpt', get_the_excerpt() ) : '';

		switch ( $context ) {
			case 'featured':
				$length  = $this->settings['featured_excerpt_length'];
				$trimmed = $this->settings['featured_excerpt_trimmed_ending'];
				break;

			default:
				$length  = $this->settings['excerpt_length'];
				$trimmed = $this->settings['excerpt_trimmed_ending'];
				break;
		}

		if ( ! $length ) {
			$this->render_meta( 'content_related', 'wdes-content-fields', [ 'before', 'after' ], $this->settings );

			return;
		}

		if ( ! $excerpt ) {

			$content = get_the_content();
			$excerpt = strip_shortcodes( $content );
			$excerpt = str_replace( ']]>', ']]&gt;', $excerpt );

			if ( - 1 === $length ) {
				$excerpt = wp_trim_words( $excerpt, 55, '' );
			}

		}

		if ( - 1 !== $length ) {
			$excerpt = wp_trim_words( $excerpt, $length, $trimmed );
		}

		$this->render_meta( 'content_related', 'wdes-content-fields', [ 'before' ], $this->settings );

		printf( '<div class="wdes-posts-block-list-post-excerpt post-excerpt-%2$s">%1$s</div>', $excerpt, $context );

		$this->render_meta( 'content_related', 'wdes-content-fields', [ 'after' ], $this->settings );
	}

	/**
	 * Read More button
	 *
	 * @param string $context
	 *
	 * @return void
	 */
	public function read_more( $context = 'featured' ) {

		$allowed = false;
		$label   = '';
		$icon    = '';
		$layout  = $this->settings['featured_layout'];

		$icon_format = '<i class="wdes-posts-block-list-more-icon %1$s"></i>';

		switch ( $context ) {
			case 'featured':

				$allowed = isset( $this->settings['featured_read_more'] ) ? $this->settings['featured_read_more'] : '';
				$label   = isset( $this->settings['featured_read_more_text'] ) ? $this->settings['featured_read_more_text'] : '';

				if ( 'yes' === $this->settings['add_button_icon'] && ! empty( $this->settings['button_icon']['value'] ) ) {
					$icon = sprintf( $icon_format, esc_attr( $this->settings['button_icon']['value'] ) );
				}

				break;

			default:
				$allowed = isset( $this->settings['read_more'] ) ? $this->settings['read_more'] : '';
				$label   = isset( $this->settings['read_more_text'] ) ? $this->settings['read_more_text'] : '';


				if ( 'yes' === $this->settings['post_add_button_icon'] && ! empty( $this->settings['post_button_icon']['value'] ) ) {
					$icon = sprintf( $icon_format, esc_attr( $this->settings['post_button_icon']['value'] ) );
				}

				break;
		}

		if ( ! $allowed ) {
			return;
		}

		$tag  = 'a';
		$href = sprintf( 'href = "%s"', get_permalink() );

		if ( $layout === 'boxed' && $context === 'featured' ) {
			$tag  = 'button';
			$href = '';
		}

		$format = '<div class="wdes-posts-block-list-more-wrap"><%1$s %2$s class="wdes-posts-block-list-more %4$s-more elementor-button elementor-size-md" ><span class="wdes-posts-block-list-more-text">%3$s</span>%5$s</%1$s></div>';

		printf( $format, $tag, $href, $label, $context,$icon );
	}

	/**
	 * Post classes list
	 *
	 * @return void
	 */
	public function post_classes() {
		$classes = [ ' wdes-posts-block-list-post ' ];

		$show_image = isset( $this->settings['show_image'] ) ? $this->settings['show_image'] : '';

		if ( 'yes' === $show_image && has_post_thumbnail() ) {
			$classes[] = 'has-post-thumb';
		}

		$thumb_pos = $this->settings['image_position'];
		$classes[] = 'has-thumb-postion-' . $thumb_pos;

		echo implode( ' ', $classes );
	}

}
