<?php
/**
 * Custom elementor
 *
 * @package Alone
 */

// Heading
add_action( 'elementor/element/heading/section_title/after_section_end', function( $element, $args ) {

  $element->start_controls_section(
		'heading_custom_section',
		[
			'label' => __( 'Custom', 'alone-addons' ),
		]
	);

	$element->add_responsive_control(
		'heading_max_width',
		[
			'type' => \Elementor\Controls_Manager::SLIDER,
			'label' => __( 'Max Width', 'alone-addons' ),
      'size_units' => [ 'px', '%' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 1000,
					'step' => 5,
				],
				'%' => [
					'min' => 0,
					'max' => 100,
				],
			],
      'default' => [
				'unit' => '%',
				'size' => 100,
			],
      'selectors' => [
        '{{WRAPPER}} .elementor-heading-title' => 'max-width: {{SIZE}}{{UNIT}};',
      ],
		]
	);

  $element->add_responsive_control(
		'heading_auto_left',
		[
			'label' => __( 'Auto Left', 'alone-addons' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'On', 'alone-addons' ),
			'label_off' => __( 'Off', 'alone-addons' ),
			'return_value' => 'auto',
			'default' => '',
      'selectors' => [
        '{{WRAPPER}} .elementor-heading-title' => 'margin-left: {{VALUE}};',
      ],
		]
	);

  $element->add_responsive_control(
		'heading_auto_right',
		[
			'label' => __( 'Auto Right', 'alone-addons' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'On', 'alone-addons' ),
			'label_off' => __( 'Off', 'alone-addons' ),
			'return_value' => 'auto',
			'default' => '',
      'selectors' => [
        '{{WRAPPER}} .elementor-heading-title' => 'margin-right: {{VALUE}};',
      ],
		]
	);

  $element->end_controls_section();

}, 10, 2 );

//Text Editor
add_action( 'elementor/element/text-editor/section_editor/after_section_end', function( $element, $args ) {

  $element->start_controls_section(
		'text_editor_custom_section',
		[
			'label' => __( 'Custom', 'alone-addons' ),
		]
	);

	$element->add_responsive_control(
		'text_editor_max_width',
		[
			'type' => \Elementor\Controls_Manager::SLIDER,
			'label' => __( 'Max Width', 'alone-addons' ),
      'size_units' => [ 'px', '%' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 1000,
					'step' => 5,
				],
				'%' => [
					'min' => 0,
					'max' => 100,
				],
			],
      'default' => [
				'unit' => '%',
				'size' => 100,
			],
      'selectors' => [
        '{{WRAPPER}} .elementor-widget-container > *' => 'max-width: {{SIZE}}{{UNIT}};',
      ],
		]
	);

  $element->add_responsive_control(
		'text_editor_auto_left',
		[
			'label' => __( 'Auto Left', 'alone-addons' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'On', 'alone-addons' ),
			'label_off' => __( 'Off', 'alone-addons' ),
			'return_value' => 'auto',
			'default' => '',
      'selectors' => [
        '{{WRAPPER}} .elementor-widget-container > *' => 'margin-left: {{VALUE}};',
      ],
		]
	);

  $element->add_responsive_control(
		'text_editor_auto_right',
		[
			'label' => __( 'Auto Right', 'alone-addons' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => __( 'On', 'alone-addons' ),
			'label_off' => __( 'Off', 'alone-addons' ),
			'return_value' => 'auto',
			'default' => '',
      'selectors' => [
        '{{WRAPPER}} .elementor-widget-container > *' => 'margin-right: {{VALUE}};',
      ],
		]
	);

  $element->end_controls_section();

}, 10, 2 );

// Button
add_action( 'elementor/element/button/section_button/after_section_end', function( $element, $args ) {

  $element->start_controls_section(
		'button_custom_section',
		[
			'label' => __( 'Custom', 'alone-addons' ),
		]
	);

	$element->add_responsive_control(
		'button_min_width',
		[
			'type' => \Elementor\Controls_Manager::SLIDER,
			'label' => __( 'Min Width', 'alone-addons' ),
      'size_units' => [ 'px', '%' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 1000,
					'step' => 5,
				],
				'%' => [
					'min' => 0,
					'max' => 100,
				],
			],
      'selectors' => [
        '{{WRAPPER}} .elementor-button' => 'min-width: {{SIZE}}{{UNIT}};',
      ],
		]
	);

  $element->end_controls_section();

}, 10, 2 );

// Slides
add_action( 'elementor/element/slides/section_slides/before_section_end', function( $element, $args ) {

  $element->add_responsive_control(
		'slides_content_width',
		[
			'type' => \Elementor\Controls_Manager::SLIDER,
			'label' => __( 'Content Width', 'alone-addons' ),
      'size_units' => [ 'px', '%' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 2000,
					'step' => 5,
				],
				'%' => [
					'min' => 0,
					'max' => 100,
				],
        'default' => [
					'unit' => '%',
					'size' => 100,
				],
			],
      'selectors' => [
        '{{WRAPPER}} .swiper-slide-inner' => 'max-width: {{SIZE}}{{UNIT}};',
      ],
		]
	);

}, 10, 2 );

// Section Waves Animation
add_action( 'elementor/element/section/section_advanced/after_section_end', function( $element, $args ) {

	$element->start_controls_section(
		'waves_animation_section',
		[
			'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
			'label' => esc_html__( 'Waves Animation Styles', 'alone-addons' ),
		]
	);

	$element->add_control(
		'enable_custom_waves',
		[
			'label' => esc_html__( 'Enable Custom Wave', 'alone-addons' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Yes', 'alone-addons' ),
			'label_off' => esc_html__( 'No', 'alone-addons' ),
			'return_value' => 'yes',
			'prefix_class' => 'bt-wave-animation--',
			'default' => '',
			'description' => esc_html__( 'Enable animated waves at the top of this section. Note: You must add the class "bt-wave-animation" to the section for the settings below to work.', 'alone-addons' ),
		]
	);
	$element->add_control(
		'wave_color',
		[
			'label' => esc_html__( 'Wave Color', 'alone-addons' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'default' => '#000000',
			'condition' => [
				'enable_custom_waves' => 'yes',
			],
			'selectors' => [
				'{{WRAPPER}} .waves use' => 'fill: {{VALUE}};',
			],
		]
	);

	$element->add_responsive_control(
		'wave_height',
		[
			'label' => esc_html__( 'Wave Height', 'alone-addons' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'vh' ],
			'range' => [
				'px' => [
					'min' => 10,
					'max' => 200,
					'step' => 1,
				],
				'vh' => [
					'min' => 1,
					'max' => 20,
					'step' => 0.1,
				],
			],
			'default' => [
				'unit' => 'px',
				'size' => 30,
			],
			'condition' => [
				'enable_custom_waves' => 'yes',
			],
			'selectors' => [
				'{{WRAPPER}} .waves' => 'height: {{SIZE}}{{UNIT}};',
			],
		]
	);
	$element->add_responsive_control(
		'wave_offset',
		[
			'label' => esc_html__( 'Wave Offset', 'alone-addons' ),
			'type' => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range' => [
				'px' => [
					'min' => -200,
					'max' => 200,
					'step' => 1,
				],
				'%' => [
					'min' => -100,
					'max' => 100,
					'step' => 1,
				],
			],
			'default' => [
				'unit' => 'px',
				'size' => 0,
			],
			'condition' => [
				'enable_custom_waves' => 'yes',
			],
			'selectors' => [
				'{{WRAPPER}} .waves' => 'top: {{SIZE}}{{UNIT}};',
			],
		]
	);
	$element->add_control(
		'wave_reverse',
		[
			'label' => esc_html__( 'Reverse Wave Direction', 'alone-addons' ),
			'type' => \Elementor\Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Yes', 'alone-addons' ),
			'label_off' => esc_html__( 'No', 'alone-addons' ),
			'return_value' => 'yes',
			'default' => '',
			'condition' => [
				'enable_custom_waves' => 'yes',
			],
			'selectors' => [
				'{{WRAPPER}} .waves' => 'transform: rotate(0deg);',
			],
		]
	);

	$element->end_controls_section();

}, 10, 2 );








