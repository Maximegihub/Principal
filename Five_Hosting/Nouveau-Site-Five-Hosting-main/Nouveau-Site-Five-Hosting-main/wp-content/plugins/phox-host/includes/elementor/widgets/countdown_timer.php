<?php

namespace Phox_Host\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Plugin;
use Phox_Host\Elementor\Base\Base_Widget;

/**
 * Countdown Timer widget.
 *
 * Countdown Timer widget that will display in Phox category
 *
 * @package Elementor\Widgets
 * @since 1.6.2
 */
class Countdown_Timer extends Base_Widget {

    /**
     * Get Widget name
     *
     * Retrieve Countdown Timer widget name
     *
     * @return string Widget name
     * @since  1.6.2
     * @access public
     *
     */
    public function get_name() {
        return 'wdes_countdown_timer';
    }

    /**
     * Get Widget title
     *
     * Retrieve Countdown Timer widget title
     *
     * @return string Widget title
     * @since  1.6.2
     * @access public
     *
     */
    public function get_title() {
        return __( 'Countdown Timer', 'phox-host' );
    }

    /**
     * Get Widget icon
     *
     * Retrieve Countdown Timer widget icon
     *
     * @return string Widget icon
     * @since  1.6.2
     * @access public
     *
     */
    public function get_icon() {
        return 'wdes-widget-elementor wdes-widget-countdown';
    }

    /**
     * Get Widget keywords
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array widget keywords.
     * @since  1.4.0
     * @access public
     *
     */
    public function get_keywords() {
        return [ 'tabs', 'accordion', 'toggle' ];
    }

    /**
     * Get script dependencies.
     *
     * Retrieve the list of script dependencies the element requires.
     *
     * @since 1.6.2
     * @access public
     *
     * @return array Element scripts dependencies.
     */
    public function get_script_depends() {
        return [ 'wdes-jq-countdown' ];
    }

    /**
     * Register Tabs widget controls
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.6.2
     * @access protected
     */
    protected function register_controls() {

        $css_scheme = [
        	'global'  => '.wdes-countdown-timer',
            'item'    => '.wdes-countdown-timer_item',
            'label'   => '.wdes-countdown-timer_item-label',
            'value'   => '.wdes-countdown-timer_item-value',
            'sep'     => '.wdes-countdown-timer_separator',
            'number'   => '.wdes-countdown-timer_digit',
            'message' => '.wdes-countdown-timer-message',
        ];

        $this->start_controls_section(
            'countdown_settings_general_section',
            [
                'label' => esc_html__( 'Timer Settings', 'phox-host' ),
            ]
        );

        $default_date = date(
            'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS )
        );

        $this->add_control(
            'by_full_date',
            [
                'label'       => esc_html__( 'Date', 'phox-host' ),
                'type'        => Controls_Manager::DATE_TIME,
                'default'     => $default_date,
                'description' => sprintf(
                    esc_html__( 'Date set according to your timezone: %s.', 'phox-host' ),
                    Utils::get_timezone_string()
                ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'general_section',
            [
                'label' => esc_html__( 'General', 'phox-host' ),
            ]
        );

        $this->add_control(
            'general_text_label',
            [
                'label'     => esc_html__( 'Text Label', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'label_days',
            [
                'label'       => esc_html__( 'Days Label', 'phox-host' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Days', 'phox-host' ),
                'placeholder' => esc_html__( 'Days', 'phox-host' ),
                'description' => esc_html__( 'Leave blank to hide', 'phox-host' ),
            ]
        );

        $this->add_control(
            'label_hours',
            [
                'label'       => esc_html__( 'Hours Label', 'phox-host' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Hours', 'phox-host' ),
                'placeholder' => esc_html__( 'Hours', 'phox-host' ),
                'description' => esc_html__( 'Leave blank to hide', 'phox-host' ),

            ]
        );

        $this->add_control(
            'label_min',
            [
                'label'       => esc_html__( 'Minutes Label', 'phox-host' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Minutes', 'phox-host' ),
                'placeholder' => esc_html__( 'Minutes', 'phox-host' ),
                'description' => esc_html__( 'Leave blank to hide', 'phox-host' ),
            ]
        );

        $this->add_control(
            'label_sec',
            [
                'label'       => esc_html__( 'Seconds Label', 'phox-host' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Seconds', 'phox-host' ),
                'placeholder' => esc_html__( 'Seconds', 'phox-host' ),
                'description' => esc_html__( 'Leave blank to hide', 'phox-host' ),
            ]
        );

	    $this->add_control(
		    'display_section',
		    [
			    'label' => esc_html__( 'Display Blocks ', 'phox-host' ),
			    'type'      => Controls_Manager::HEADING,
			    'separator' => 'before',
		    ]
	    );

        $this->add_control(
	        'countdown_display_block_days',
	        [
		        'label'        => esc_html__( 'Display Days', 'phox-host' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'phox-host' ),
		        'label_off'    => esc_html__( 'Hide', 'phox-host' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
	        ]
        );

        $this->add_control(
	        'countdown_display_block_hours',
	        [
		        'label'        => esc_html__( 'Display Hours', 'phox-host' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'phox-host' ),
		        'label_off'    => esc_html__( 'Hide', 'phox-host' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
	        ]
        );

        $this->add_control(
	        'countdown_display_block_min',
	        [
		        'label'        => esc_html__( 'Display Minutes', 'phox-host' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'phox-host' ),
		        'label_off'    => esc_html__( 'Hide', 'phox-host' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
	        ]
        );

        $this->add_control(
	        'countdown_display_block_sec',
	        [
		        'label'        => esc_html__( 'Display Seconds', 'phox-host' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'phox-host' ),
		        'label_off'    => esc_html__( 'Hide', 'phox-host' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
	        ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_separator',
            [
                'label' => esc_html__( 'Separator', 'phox-host' ),
            ]
        );

        $this->add_control(
            'countdown_separator_display',
            [
                'label'        => esc_html__( 'Display Separator', 'phox-host' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'phox-host' ),
                'label_off'    => esc_html__( 'Hide', 'phox-host' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'countdown_separator_type',
            [
                'label'     => __( 'Separator Type', 'phox-host' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'dotted',
                'options'   => [
                    'solid'  => __( 'Solid', 'phox-host' ),
                    'dotted' => __( 'Dotted', 'phox-host' ),
                    'custom' => __( 'Custom', 'phox-host' ),
                ],
                'condition' => [
                    'countdown_separator_display' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'countdown_custom_separator',
            [
                'label'     => __( 'Separator', 'phox-host' ),
                'type'      => Controls_Manager::TEXT,
                'default'     => '',
                'placeholder' => ':',
                'condition' => [
                    'countdown_separator_display' => 'yes',
                    'countdown_separator_type' => 'custom',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_finish_settings',
            [
                'label' => esc_html__( 'Finish Action', 'phox-host' ),
            ]
        );

        $this->add_control(
            'finish_actions',
            [
                'label'       => esc_html__( 'Actions After Finish', 'phox-host' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'options'     => [
                    'redirect' => esc_html__( 'Redirect', 'phox-host' ),
                    'message'  => esc_html__( 'Show Message', 'phox-host' ),
                    'template'  => esc_html__( 'Show Template', 'phox-host' ),
                    'hide'     => esc_html__( 'Hide Timer', 'phox-host' ),
                ]
            ]
        );

        $this->add_control(
            'finish_redirect_url',
            array(
                'label'         => esc_html__( 'Redirect URL', 'phox-host' ),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'show_external' => false,
                'dynamic'       => array(
                    'active' => true,
                ),
                'condition'     => array(
                    'finish_actions' => 'redirect',
                ),
            )
        );

        $this->add_control(
            'message_after_finish',
            array(
                'label'       => esc_html__( 'Message', 'phox-host' ),
                'type'        => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'dynamic'     => array(
                    'active' => true,
                ),
                'condition'   => array(
                    'finish_actions' => 'message',
                ),
            )
        );

        $this->add_control(
            'template_after_finish',
            [
                'label'       => esc_html__( 'Templates', 'phox-host' ),
                'type'        => 'wdes-select-templates',
                'condition'   => [
                    'finish_actions' => 'template',
                ],
                'label_block' => 'true',
            ]
        );

        $this->end_controls_section();

	    $this->start_controls_section(
		    'countdown_styles_global_section',
		    [
			    'label'      => esc_html__( 'Countdown Global', 'phox-host' ),
			    'tab'        => Controls_Manager::TAB_STYLE,
			    'show_label' => false,
		    ]
	    );

	    $this->add_control(
		    'global_alignment',
		    [
			    'label'     => esc_html__( 'Alignment', 'phox-host' ),
			    'type'      => Controls_Manager::CHOOSE,
			    'default' => 'center',
			    'options' => [
				    'flex-start'    => [
					    'title' => esc_html__( 'Left', 'phox-host' ),
					    'icon'  => 'eicon-arrow-left',
				    ],
				    'center' => [
					    'title' => esc_html__( 'Center', 'phox-host' ),
					    'icon'  => 'eicon-text-align-justify',
				    ],
				    'flex-end' => [
					    'title' => esc_html__( 'Right', 'phox-host' ),
					    'icon'  => 'eicon-arrow-right',
				    ],
			    ],
			    'selectors'  => [
				    '{{WRAPPER}} ' . $css_scheme['global'] => 'justify-content: {{VALUE}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'global_height',
		    [
			    'label'     => esc_html__( 'Height', 'phox-host' ),
			    'type'      => Controls_Manager::CHOOSE,
			    'default' => '136px',
			    'options' => [
				    '136px'    => [
					    'title' => esc_html__( 'Default', 'phox-host' ),
					    'icon'  => 'eicon-frame-expand',
				    ],
				    'auto' => [
					    'title' => esc_html__( 'Auto', 'phox-host' ),
					    'icon'  => 'eicon-flash',
				    ]
			    ],
			    'selectors'  => [
				    '{{WRAPPER}} ' . $css_scheme['global'] => 'min-height: {{VALUE}};',
			    ],
		    ]
	    );

	    $this->end_controls_section();

        $this->start_controls_section(
            'countdown_styles_items_section',
            [
                'label'      => esc_html__( 'Countdown Item', 'phox-host' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'item_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['item'],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__( 'Item Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} '  . $css_scheme['item'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_margin',
            [
                'label'      => esc_html__( 'Item Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} '  . $css_scheme['item'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['item'],
                'placeholder' => '1px',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top'      => '1',
                            'right'    => '1',
                            'bottom'   => '1',
                            'left'     => '1',
                            'isLinked' => true,
                        ],
                    ],
                    'color' => [
                        'scheme' => [
                            'type'  => Color::get_type(),
                            'value' => Color::COLOR_3,
                        ],
                        'default' => '#e7e7e7',
                    ],
                ],
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['item'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['item'],
            ]
        );

	    $this->add_control(
		    'item_alignment',
		    [
			    'label'     => esc_html__( 'Alignment', 'phox-host' ),
			    'type'      => Controls_Manager::CHOOSE,
			    'default' => 'center',
			    'options' => [
				    'left'    => [
					    'title' => esc_html__( 'Left', 'phox-host' ),
					    'icon'  => 'eicon-arrow-left',
				    ],
				    'center' => [
					    'title' => esc_html__( 'Center', 'phox-host' ),
					    'icon'  => 'eicon-text-align-justify',
				    ],
				    'right' => [
					    'title' => esc_html__( 'Right', 'phox-host' ),
					    'icon'  => 'eicon-arrow-right',
				    ],
			    ],
			    'selectors'  => [
				    '{{WRAPPER}} ' . $css_scheme['item'] => 'text-align: {{VALUE}};',
			    ],
		    ]
	    );

	    $this->add_control(
		    'items_size',
		    [
			    'label'   => esc_html__( 'Size', 'phox-host' ),
			    'type'    => Controls_Manager::SELECT,
			    'default' => 'fixed',
			    'options' => [
				    'auto'  => esc_html__( 'Auto', 'phox-host' ),
				    'fixed' => esc_html__( 'Fixed', 'phox-host' ),
			    ],
			    'separator' => 'before',
		    ]
	    );

	    $this->add_responsive_control(
		    'items_size_val',
		    [
			    'label'      => esc_html__( 'Width', 'phox-host' ),
			    'type'       => Controls_Manager::SLIDER,
			    'size_units' => [ 'px', '%', 'em' ],
			    'default'    => [
				    'unit' => 'px',
				    'size' => 130,
			    ],
			    'range'      => [
				    'px' => [
					    'min' => 60,
					    'max' => 600,
				    ],
				    'em' => [
					    'min' => 1,
					    'max' => 20,
				    ],
			    ],
			    'render_type' => 'template',
			    'condition'   => [
				    'items_size' => 'fixed',
			    ],
			    'selectors' => [
				    '{{WRAPPER}} ' . $css_scheme['item'] => 'width: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_responsive_control(
		    'items_width_val',
		    [
			    'label'      => esc_html__( 'Height', 'phox-host' ),
			    'type'       => Controls_Manager::SLIDER,
			    'size_units' => [ 'px', '%', 'em' ],
			    'default'    => [
				    'unit' => 'px',
				    'size' => 136,
			    ],
			    'range'      => [
				    'px' => [
					    'min' => 60,
					    'max' => 600,
				    ],
				    'em' => [
					    'min' => 1,
					    'max' => 20,
				    ],
			    ],
			    'render_type' => 'template',
			    'condition'   => [
				    'items_size' => 'fixed',
			    ],
			    'selectors' => [
				    '{{WRAPPER}} ' . $css_scheme['item'] => 'height: {{SIZE}}{{UNIT}};',
			    ],
		    ]
	    );

        $this->add_control(
            'order_heading',
            [
                'label'     => esc_html__( 'Order', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'value_order',
            [
                'label'   => esc_html__( 'Number Order', 'phox-host' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1,
                'min'     => 1,
                'max'     => 2,
                'step'    => 1,
                'selectors' => [
                    '{{WRAPPER}} '. $css_scheme['value'] => 'order: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'label_order',
            [
                'label'   => esc_html__( 'Label Order', 'phox-host' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 2,
                'min'     => 1,
                'max'     => 2,
                'step'    => 1,
                'selectors' => [
                    '{{WRAPPER}} '. $css_scheme['label'] => 'order: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'label_styles_section',
            [
                'label'      => esc_html__( 'Labels', 'phox-host' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => esc_html__( 'Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#c51e3a',
                'scheme'    => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_3,
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['label'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'label_typography',
                'scheme'   => Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'label_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
            ]
        );

        $this->add_responsive_control(
            'label_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} '  . $css_scheme['label'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'label_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} '  . $css_scheme['label'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'label_border',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['label'],
            ]
        );

        $this->add_control(
            'label_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['label'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'label_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_number_styles',
            [
                'label'      => esc_html__( 'Numbers', 'phox-host' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'value_color',
            [
                'label'     => esc_html__( 'Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#1b3a4e',
                'scheme'    => [
                    'type'  => Color::get_type(),
                    'value' => Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['value'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'value_typography',
                'scheme'   => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} ' . $css_scheme['value'],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'value_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['value'],
            ]
        );

        $this->add_responsive_control(
            'value_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} '  . $css_scheme['value'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'value_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} '  . $css_scheme['value'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'value_border',
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['value'],
            ]
        );

        $this->add_control(
            'value_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['value'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'value_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['value'],
            ]
        );

        $this->add_control(
            'number_item_heading',
            [
                'label'     => esc_html__( 'Number Item Styles', 'phox-host' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'digit_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['number'],
            ]
        );

        $this->add_responsive_control(
            'number_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} '  . $css_scheme['number'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'number_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} '  . $css_scheme['number'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'number_border',
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['number'],
            ]
        );

        $this->add_control(
            'number_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['number'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'number_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['number'],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_sep_styles',
            [
                'label'      => esc_html__( 'Separator Styles', 'phox-host' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'sep_color',
            [
                'label'     => esc_html__( 'Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['sep'] => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'sep_size',
            [
                'label'      => esc_html__( 'Size', 'phox-host' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'range'      => [
                    'px' => [
                        'min' => 12,
                        'max' => 300,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['sep'] => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'sep_font',
            [
                'label'     => esc_html__( 'Font', 'phox-host' ),
                'type'      => Controls_Manager::FONT,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['sep'] => 'font-family: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'sep_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} '  . $css_scheme['sep'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_message_style',
            [
                'label'     => esc_html__( 'Message', 'phox-host' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'finish_actions' => 'message',
                ],
            ]
        );

        $this->add_control(
            'message_color',
            [
                'label'     => esc_html__( 'Text Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['message'] => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'message_bg_color',
            [
                'label'     => esc_html__( 'Background Color', 'phox-host' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['message'] => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'message_typography',
                'selector' => '{{WRAPPER}} ' . $css_scheme['message'],
            ]
        );

        $this->add_responsive_control(
            'message_padding',
            [
                'label'      => esc_html__( 'Padding', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['message'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'message_margin',
            [
                'label'      => esc_html__( 'Margin', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['message'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'message_align',
            [
                'label'   => esc_html__( 'Alignment', 'phox-host' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'phox-host' ),
                        'icon'  => 'eicon-arrow-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'phox-host' ),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'phox-host' ),
                        'icon'  => 'eicon-arrow-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'phox-host' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $css_scheme['message'] => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'message_border',
                'selector' => '{{WRAPPER}} ' . $css_scheme['message'],
            ]
        );

        $this->add_control(
            'message_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'phox-host' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} ' . $css_scheme['message'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * Render
     */
    protected function render() {

        $settings = $this->get_settings_for_display();
        $configs_lib = [];

        //data
        $configs_lib['date'] = $settings['by_full_date'];

	    //display
	    $configs_lib['display']['days'] = $settings['countdown_display_block_days'] ?? '';
	    $configs_lib['display']['hours'] = $settings['countdown_display_block_hours'] ?? '';
	    $configs_lib['display']['min'] = $settings['countdown_display_block_min'] ?? '';
	    $configs_lib['display']['sec'] = $settings['countdown_display_block_sec'] ?? '';

        //label
        $configs_lib['label']['days'] = esc_html($settings['label_days']);
        $configs_lib['label']['hours'] = esc_html($settings['label_hours']);
        $configs_lib['label']['min'] = esc_html($settings['label_min']);
        $configs_lib['label']['sec'] = esc_html($settings['label_sec']);

        //separator
        $configs_lib['separator']['display'] = $settings['countdown_separator_display'];
        $configs_lib['separator']['type'] = $settings['countdown_separator_type'];
        $configs_lib['separator']['custom'] = esc_html($settings['countdown_custom_separator']) ?? '';

        //finish action
        $configs_lib['finish']['action'] = $settings['finish_actions'];
        $configs_lib['finish']['redirectUrl'] = filter_var($settings['finish_redirect_url']['url'], FILTER_VALIDATE_URL) ?? '';
        $configs_lib['finish']['message'] = esc_js($settings['message_after_finish']) ?? '';

        //convert to json
        $configs_json = json_encode($configs_lib);

        printf("<div class='wdes-countdown-timer' data-configs='%s'></div>", esc_attr($configs_json));

        if( $configs_lib['finish']['action'] === 'template' ){
            $template_id = $settings['template_after_finish'];
            if ( get_post_type( $template_id ) === 'elementor_library' ) {
                $template_shortcode = $this->elementor()->frontend->get_builder_content_for_display( $template_id, true );
                printf('<div class="wdes-countdown-timer-template" style="display: none"> %s </div>', $template_shortcode);
            }

        }


    }



}


