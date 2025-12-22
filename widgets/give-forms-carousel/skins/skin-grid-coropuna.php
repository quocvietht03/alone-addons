<?php
namespace AloneAddons\Widgets\Give_Forms_Carousel\Skins;

use Elementor\Widget_Base;
use Elementor\Skin_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;

use Give\Helpers\Form\Template;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Grid_Coropuna extends Skin_Base {

	protected function _register_controls_actions() {
		add_action( 'elementor/element/be-give-forms-carousel/section_layout/before_section_end', [ $this, 'register_layout_controls' ] );
		add_action( 'elementor/element/be-give-forms-carousel/section_design_layout/before_section_end', [ $this, 'registerd_design_layout_controls' ] );
		add_action( 'elementor/element/be-give-forms-carousel/section_design_layout/after_section_end', [ $this, 'register_design_box_section_controls' ] );
		add_action( 'elementor/element/be-give-forms-carousel/section_design_layout/after_section_end', [ $this, 'register_design_image_section_controls' ] );
		add_action( 'elementor/element/be-give-forms-carousel/section_design_layout/after_section_end', [ $this, 'register_design_content_section_controls' ] );
		add_action( 'elementor/element/be-give-forms-carousel/section_design_layout/after_section_end', [ $this, 'register_design_give_form_section_controls' ] );
		add_action( 'elementor/element/be-give-forms-carousel/section_design_layout/after_section_end', [ $this, 'register_design_goal_progress_section_controls' ] );

	}

	public function get_id() {
		return 'skin-grid-coropuna';
	}


	public function get_title() {
		return __( 'Grid Coropuna', 'alone-addons' );
	}


	public function register_layout_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->add_responsive_control(
			'sliders_per_view',
			[
				'label' => __( 'Columns', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '2',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'posts_count',
			[
				'label' => __( 'Posts Count', 'alone-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
      'show_thumbnail',
      [
        'label' => __( 'Thumbnail', 'alone-addons' ),
        'type'  => Controls_Manager::SWITCHER,
        'label_on' => __( 'Show', 'alone-addons' ),
        'label_off' => __( 'Hide', 'alone-addons' ),
        'default'  => 'yes',
        'separator' => 'before',
      ]
    );

    $this->add_group_control(
      Group_Control_Image_Size::get_type(),
      [
        'name' => 'thumbnail',
        'default' => 'medium',
        'exclude' => [ 'custom' ],
				'condition' => [
					'skin_grid_coropuna_show_thumbnail!'=> '',
				],
      ]
    );

    $this->add_responsive_control(
      'item_ratio',
      [
        'label' => __( 'Image Ratio', 'alone-addons' ),
        'type' => Controls_Manager::SLIDER,
        'default' => [
          'size' => 0.66,
        ],
        'range' => [
          'px' => [
            'min' => 0.3,
            'max' => 2,
            'step' => 0.01,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .give-card__media' => 'padding-bottom: calc( {{SIZE}} * 100% );',
        ],
				'condition' => [
					'skin_grid_coropuna_show_thumbnail!'=> '',
				],
      ]
    );

		$this->add_control(
      'show_goal_progress',
      [
        'label' => __( 'Goal Progress', 'alone-addons' ),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => __( 'Show', 'alone-addons'),
        'label_off' => __( 'Hide', 'alone-addons'),
        'default' => 'yes',
				'condition' => [
					'skin_grid_coropuna_show_thumbnail!'=> '',
				],
      ]
    );

    $this->add_control(
      'show_title',
      [
        'label' => __( 'Title', 'alone-addons'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => __( 'Show', 'alone-addons'),
        'label_off' => __( 'Hide', 'alone-addons'),
        'default' => 'yes',
        'separator' => 'before',
      ]
    );

		$this->add_control(
			'show_category',
			[
				'label' => __( 'Category', 'alone-addons' ),
				'type'  => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons'),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_donation_button',
			[
				'label' => __( 'Donation Button', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'donation_button_label',
			[
				'label' => __( 'Donation button Label', 'alone-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Donate Now', 'alone-addons' ),
				'condition' => [
					'skin_grid_coropuna_show_donation_button!' => '',
				],
			]
		);

	}

	public function registerd_design_layout_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->add_responsive_control(
			'space_between',
			[
				'label' => __( 'Space Between', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 30,
				],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'alone-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'alone-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'alone-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'alone-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-give-form' => 'text-align: {{VALUE}};',
				],
			]
		);

	}

	public function register_design_box_section_controls( Widget_Base $widget) {
    $this->parent = $widget;

    $this->start_controls_section(
      'section_design_box',
      [
        'label' => __( 'Box', 'alone-addons' ),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

		$this->add_control(
			'box_border_width',
			[
				'label' => __( 'Border Width', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-give-form' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'box_border_radius',
			[
				'label' => __( 'Border Radius', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-give-form' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label' => __( 'Padding', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-give-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => __( 'Content Padding', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .give-card__body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs( 'bg_effects_tabs' );

		$this->start_controls_tab( 'classic_style_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .elementor-give-form',
			]
		);

		$this->add_control(
			'box_bg_color',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-give-form' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'box_border_color',
			[
				'label' => __( 'Border Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-give-form' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'classic_style_hover',
			[
				'label' => __( 'Hover', 'alone-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_hover',
				'selector' => '{{WRAPPER}} .elementor-give-form:hover',
			]
		);

		$this->add_control(
			'box_bg_color_hover',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-give-form:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'box_border_color_hover',
			[
				'label' => __( 'Border Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-give-form:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

  }

	public function register_design_image_section_controls(Widget_Base $widget) {
    $this->parent = $widget;

    $this->start_controls_section(
			'section_design_image',
			[
				'label' => __( 'Image', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skin_grid_coropuna_show_thumbnail!' => '',
				],
			]
		);

    $this->start_controls_tabs( 'thumbnail_effects_tabs' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

    $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_filters',
				'selector' => '{{WRAPPER}} .give-card__media img',
			]
		);

    $this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => __( 'Hover', 'alone-addons' ),
			]
		);

    $this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_hover_filters',
				'selector' => '{{WRAPPER}} .elementor-give-form:hover .give-card__media img',
			]
		);

    $this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

  }

	public function register_design_content_section_controls(Widget_Base $widget) {
    $this->parent = $widget;

    $this->start_controls_section(
			'section_design_content',
			[
				'label' => __( 'Content', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_goal_progress_style',
			[
				'label' => __( 'Goal Progress', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'skin_grid_coropuna_show_goal_progress!' => '',
					'skin_grid_coropuna_show_thumbnail!'=> '',
				],
			]
		);

		$this->add_control(
			'goal_progress_primary_color',
			[
				'label' => __( 'Primary Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .give-goal-progress .income,
					 {{WRAPPER}} .give-goal-progress .goal-text' => 'color: {{VALUE}};',
				],
				'condition' => [
					'skin_grid_coropuna_show_goal_progress!' => '',
					'skin_grid_coropuna_show_thumbnail!'=> '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'goal_progress_primary_typography',
				'label' => __( 'Primary Typography', 'alone-addons' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .give-goal-progress .income,
				 							 {{WRAPPER}} .give-goal-progress .goal-text',
				'condition' => [
					'skin_grid_coropuna_show_goal_progress!' => '',
					'skin_grid_coropuna_show_thumbnail!'=> '',
				],
			]
		);

		$this->add_control(
			'goal_progress_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .give-goal-progress' => 'color: {{VALUE}};',
				],
				'condition' => [
					'skin_grid_coropuna_show_goal_progress!' => '',
					'skin_grid_coropuna_show_thumbnail!'=> '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'goal_progress_typography',
				'label' => __( 'Typography', 'alone-addons' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .give-goal-progress',
				'condition' => [
					'skin_grid_coropuna_show_goal_progress!' => '',
					'skin_grid_coropuna_show_thumbnail!'=> '',
				],
			]
		);

		$this->add_control(
			'heading_title_style',
			[
				'label' => __( 'Title', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'skin_grid_coropuna_show_title!' => '',
				],
			]
		);

    $this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .give-card__title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'skin_grid_coropuna_show_title!' => '',
				],
			]
		);

    $this->add_control(
			'title_color_hover',
			[
				'label' => __( 'Color Hover', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					' {{WRAPPER}} .give-card__title a:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'skin_grid_coropuna_show_title!' => '',
				],
			]
		);

    $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'default' => '',
				'selector' => '{{WRAPPER}} .give-card__title',
				'condition' => [
					'skin_grid_coropuna_show_title!' => '',
				],
			]
		);

		$this->add_control(
			'heading_category_style',
			[
				'label' => __( 'Category', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'skin_grid_coropuna_show_category!' => '',
				],
			]
		);

		$this->add_control(
			'category_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .give-card__category' => 'color: {{VALUE}};',
					'{{WRAPPER}} .give-card__category svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
					'skin_grid_coropuna_show_category!' => '',
				],
			]
		);

		$this->add_control(
			'category_color_hover',
			[
				'label' => __( 'Color Hover', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .give-card__category a:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'skin_grid_coropuna_show_category!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_typography',
				'label' => __( 'Typography', 'alone-addons' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .give-card__category',
				'condition' => [
					'skin_grid_coropuna_show_category!' => '',
				],
			]
		);

		$this->add_control(
			'heading_donation_button_style',
			[
				'label' => __( 'Donation Button', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'skin_grid_coropuna_show_donation_button!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'donation_button_typography',
				'default' => '',
				'selector' => '{{WRAPPER}} .give-btn-modal,
								{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open',
				'condition' => [
					'skin_grid_coropuna_show_donation_button!' => '',
				],
			]
		);

		$this->add_control(
			'donation_button_width',
			[
				'label' => __( 'Border Width', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'condition' => [
					'skin_grid_coropuna_show_donation_button!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .give-btn-modal,
					{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'donation_button_radius',
			[
				'label' => __( 'Border Radius', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'condition' => [
					'skin_grid_coropuna_show_donation_button!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .give-btn-modal,
					{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'donation_button_padding',
			[
				'label' => __( 'Padding', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'condition' => [
					'skin_grid_coropuna_show_donation_button!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .give-btn-modal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}  !important;',
				],
			]
		);

		$this->start_controls_tabs( 'donation_button_tabs' );

		$this->start_controls_tab( 'donation_button_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
				'condition' => [
					'skin_grid_coropuna_show_donation_button!' => '',
				],
			]
		);

		$this->add_control(
			'donation_button_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .give-btn-modal' => 'color: {{VALUE}};',
					'{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'donation_button_bg_color',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .give-btn-modal' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'donation_button_border_color',
			[
				'label' => __( 'Border Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .give-btn-modal,
					{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'donation_button',
			[
				'label' => __( 'Hover', 'alone-addons' ),
				'condition' => [
					'skin_grid_coropuna_show_donation_button!' => '',
				],
			]
		);

		$this->add_control(
			'donation_button_hover',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .give-btn-modal:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'donation_button_bg_color_hover',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .give-btn-modal:hover' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open:hover' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'donation_button_border_color_hover',
			[
				'label' => __( 'Border Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .give-btn-modal:hover,
					{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
  }

	public function register_design_give_form_section_controls(Widget_Base $widget) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_design_give_form',
			[
				'label' => __( 'Give Form (Apply On Legacy)', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skin_grid_coropuna_show_donation_button!' => '',
				],
			]
		);

		$this->add_control(
			'form_main_color',
			[
				'label' => __( 'Main Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.give-form[data-style="elementor-give-forms-carousel--coropuna"] .give-total-wrap #give-amount,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give-donation-level-button-wrap .give-btn:not(.give-default-level),
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give-donation-level-button-wrap .give-btn:not(.give-default-level):hover,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give-gateway-radio-list > li label:hover,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give-gateway-radio-list > li.give-gateway-option-selected label,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give_terms_agreement label:hover,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give_terms_agreement input[type=checkbox]:checked + label,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] .give_terms_links:hover,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give-final-total-wrap .give-final-total-amount' => 'color: {{VALUE}};',
					'.give-form[data-style="elementor-give-forms-carousel--coropuna"] .give-total-wrap .give-currency-symbol,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give-gateway-radio-list > li.give-gateway-option-selected label:after,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give_terms_agreement input[type=checkbox]:checked + label:before,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give-final-total-wrap .give-donation-total-label' => 'background-color: {{VALUE}};',
					'.give-form[data-style="elementor-give-forms-carousel--coropuna"] #give-donation-level-button-wrap .give-btn:hover,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] #give_terms_agreement input[type=checkbox]:checked + label:before' => 'border-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'form_text_color',
			[
				'label' => __( 'Text Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.give-form[data-style="elementor-give-forms-carousel--coropuna"]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'form_typograph_heading',
			[
				'label' => esc_html__( 'Fonts', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'form_typography',
			[
				'label' => esc_html__( 'Typography', 'alone-addons' ),
				'type' => Controls_Manager::FONT,
				'default' => '',
				'selectors' => [
					'.give-form[data-style="elementor-give-forms-carousel--coropuna"]' => 'font-family: "{{VALUE}}", sans-serif',
				],
			]
		);

		$this->add_control(
			'form_main_typography',
			[
				'label' => esc_html__( 'Main Typography', 'alone-addons' ),
				'description' => esc_html__( 'Used for heading, title, button', 'alone-addons' ),
				'type' => Controls_Manager::FONT,
				'default' => '',
				'selectors' => [
					'.give-form[data-style="elementor-give-forms-carousel--coropuna"] legend,
					 .give-form[data-style="elementor-give-forms-carousel--coropuna"] .give-submit' => 'font-family: "{{VALUE}}", sans-serif',
				],
			]
		);


		$this->add_control(
			'form_button_heading',
			[
				'label' => esc_html__( 'Button', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->start_controls_tabs( 'tabs_form_button_style' );

		$this->start_controls_tab(
			'tab_form_button_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

		$this->add_control(
			'form_button_text_color',
			[
				'label' => __( 'Text Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.give-form[data-style="elementor-give-forms-carousel--coropuna"] .give-submit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'form_button_bg_color',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.give-form[data-style="elementor-give-forms-carousel--coropuna"] .give-submit' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_form_button_hover',
			[
				'label' => __( 'Hover', 'alone-addons' ),
			]
		);

		$this->add_control(
			'form_button_hover_color',
			[
				'label' => __( 'Text Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.give-form[data-style="elementor-give-forms-carousel--coropuna"] .give-submit:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'form_button_bg_color_hover',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.give-form[data-style="elementor-give-forms-carousel--coropuna"] .give-submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function register_design_goal_progress_section_controls(Widget_Base $widget){

		$this->parent = $widget;

		$this->start_controls_section(
			'section_goal_progress',
			[
				'label' => __( 'Goal Progress', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skin_grid_coropuna_show_goal_progress!' => '',
					'skin_grid_coropuna_show_thumbnail!'=> '',
				],
			]
		);

		$this->add_control(
			'custom_goal_progress',
			[
				'label' => __( 'Custom Goal Progress', 'alone-addons' ),
				'description' => __( 'Check this to custom goal progress in give forms.', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'alone-addons' ),
				'label_off' => __( 'Off', 'alone-addons' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'goal_progress_easing',
			[
				'label' => __( 'Easing', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'linear',
				'options' => [
					'linear' => __( 'Linear', 'alone-addons' ),
					'easeOut' => __( 'EaseOut', 'alone-addons' ),
					'bounce' => __( 'Bounce', 'alone-addons' ),
				],
				'condition' => [
					'skin_grid_coropuna_custom_goal_progress!' => '',
				],
			]
		);

		$this->add_control(
			'goal_progress_duration',
			[
				'label' => __( 'Duration', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 800,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					],
				],
				'condition' => [
					'skin_grid_coropuna_custom_goal_progress!' => '',
				],
			]
		);

		$this->add_control(
			'goal_progress_color_from',
			[
				'label' => __( 'from Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFEA82',
				'condition' => [
					'skin_grid_coropuna_custom_goal_progress!' => '',
				],
			]
		);

		$this->add_control(
			'goal_progress_color_to',
			[
				'label' => __( 'to Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ED6A5A',
				'condition' => [
					'skin_grid_coropuna_custom_goal_progress!' => '',
				],
			]
		);

		$this->add_control(
			'goal_progress_trailcolor',
			[
				'label' => __( 'Trail Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#EEEEEE',
				'condition' => [
					'skin_grid_coropuna_custom_goal_progress!' => '',
				],
			]
		);

		$this->add_control(
			'goal_progress_padding',
			[
				'label' => __( 'Padding', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .give-goal-progress svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'goal_progress_background',
			[
				'label' => __( 'Background', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .give-goal-progress svg' => 'background: {{VALUE}};',
				]
			]
		);

		$this->end_controls_section();
	}

	protected function render_post() {

    $settings = $this->parent->get_settings_for_display();

		$post_id = get_the_ID();
		$form_id = get_field('give_form', $post_id);

		$form_class = 'elementor-give-form';

		if( '' !== $this->parent->get_instance_value_skin( 'show_donation_button' ) ) {
			$form_class .= ' has-btn-donation';
		}

		?>
      	<div class="swiper-slide">
	  		<article id="post-<?php the_ID();  ?>" <?php post_class( $form_class ); ?> >
				<?php if( '' !== $this->parent->get_instance_value_skin('show_thumbnail') ) { ?>
					<div class="give-card__media">
						<a href="<?php the_permalink(); ?>">
			        <?php
			          // Maybe display the featured image.
			          printf(
			            '%s<div class="give-card__overlay"></div>',
			            get_the_post_thumbnail( $post_id, $this->parent->get_instance_value_skin( 'thumbnail_size' ) )
			          );

		            if( '' !== $this->parent->get_instance_value_skin('show_goal_progress') && give_is_setting_enabled( get_post_meta( $form_id, '_give_goal_option', true ) ) ) {
		              $args = array(
		                'show_text' => true,
		                'show_bar' => true,
		                'income_text' => __( 'Raised:', 'alone-addons' ),
		                'goal_text' => __( 'Goal:', 'alone-addons' ),
		                'custom_goal_progress' => $this->parent->get_instance_value_skin('custom_goal_progress'),

		              );

		              $bar_opts = array(
		                'type' => 'line',
		                'strokewidth' => 1,
		                'easing' => $this->parent->get_instance_value_skin('goal_progress_easing'),
		                'duration' => !empty( $this->parent->get_instance_value_skin('goal_progress_duration')['size'] ) ? absint( $this->parent->get_instance_value_skin('goal_progress_duration')['size'] ) : 0,
		                'color' => $this->parent->get_instance_value_skin('goal_progress_color_from'),
		                'trailcolor' => $this->parent->get_instance_value_skin('goal_progress_trailcolor'),
		                'trailwidth' => 1,
		                'tocolor' => $this->parent->get_instance_value_skin('goal_progress_color_to'),
		                'width' => '100%',
		                'height' => '20px',
		              );

		              alone_addons_goal_progress( $form_id, $args, $bar_opts );
		            }
			        ?>
						</a>
					</div>
				<?php } ?>

				<div class="give-card__body">
				<?php
					if( '' !== $this->parent->get_instance_value_skin( 'show_category' ) ){
					the_terms( $post_id, 'give_posts_category', '<div class="give-card__category">' . alone_addons_get_icon_svg( 'location', 14 ) , ', ', '</div>' );
					}

					if( '' !== $this->parent->get_instance_value_skin( 'show_title' ) ){
						// Maybe display the form title.
						printf(
						'<h3 class="give-card__title">
										<a href="%s">%s</a>
									</h3>',
									get_the_permalink(),
									get_the_title()
						);
					}

					if( '' !== $this->parent->get_instance_value_skin( 'show_donation_button' ) ) {
						if( !Template::getActiveID($form_id) ) {
							if ( $this->parent->get_is_edit_mode() ) {
								echo '<div class="root-data-givewp-embed"><button type="button" class="givewp-donation-form-modal__open">' . $this->parent->get_instance_value_skin('donation_button_label') . '</button></div>';
							} else {
								echo do_shortcode('[give_form id="' . $form_id . '" display_style="modal" continue_button_title="' . $this->parent->get_instance_value_skin('donation_button_label') . '"]');
							}
						} else {
							// Maybe display the form donate button.
							$atts = array(
								'id' => $form_id,  // integer.
								'show_title' => false, // boolean.
								'show_goal' => false, // boolean.
								'show_content' => 'none', //above, below, or none
								'display_style' => 'button', //modal, button, and reveal
								'continue_button_title' => $this->parent->get_instance_value_skin('donation_button_label') //string

							);

							add_filter('give_form_html_tags', function($form_html_tags, $form) {
								$form_html_tags['data-style'] = 'elementor-give-forms-carousel--coropuna';

								return $form_html_tags;
							}, 10, 2);

							echo give_get_donation_form( $atts );
						}
					}
				?>
				</div>
			</article>
      	</div>
		<?php
	}

	public function render() {

		$query = $this->parent->query_posts();

		if ( $query->have_posts() ) {

			$this->parent->render_loop_header();

				while ( $query->have_posts() ) {
					$query->the_post();

					$this->render_post();

				}

			$this->parent->render_loop_footer();

		} else {
		    // no posts found
		}

		wp_reset_postdata();
	}

	protected function content_template() {

	}

}
