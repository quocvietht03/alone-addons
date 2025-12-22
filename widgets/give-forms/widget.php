<?php
namespace AloneAddons\Widgets\Give_Forms;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

use Elementor\Plugin;
use Give\Helpers\Form\Template;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Be_Give_Forms extends Widget_Base {

	public function get_name() {
		return 'be-give-forms';
	}

	public function get_title() {
		return __( 'Be Give Forms', 'alone-addons' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'alone-addons' ];
	}

	public function get_script_depends() {
		return [ 'elementor-waypoints', 'jquery-progressbar', 'alone-addons' ];
	}

	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Grid_Pumori( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Coropuna( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Changtse( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Hardeol( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Nevado( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Galloway( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Havsula( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Taboche( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Wilson( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Cholatse( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Tronador( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Vaccine( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Yutmaru( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Platons( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Nuptse( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Gamin( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Cruces( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Swiss( $this ) );
		$this->add_skin( new Skins\Skin_Grid_Toluca( $this ) );
		$this->add_skin( new Skins\Skin_Cobble_Paradis( $this ) );
		$this->add_skin( new Skins\Skin_Cobble_Castor( $this ) );
		$this->add_skin( new Skins\Skin_List_Andrus( $this ) );

	}

	protected function get_supported_ids() {
		$supported_ids = [];

		$wp_query = new \WP_Query( array(
														'post_type' => 'give_posts',
														'post_status' => 'publish'
													) );

		if ( $wp_query->have_posts() ) {
	    while ( $wp_query->have_posts() ) {
        $wp_query->the_post();
        $supported_ids[get_the_ID()] = get_the_title();
	    }
		}

		return $supported_ids;
	}

	public function get_supported_taxonomies() {
		$supported_taxonomies = [];

		$categories = get_terms( array(
			'taxonomy' => 'give_posts_category',
	    'hide_empty' => false,
		) );
		if( ! empty( $categories )  && ! is_wp_error( $categories ) ) {
			foreach ( $categories as $category ) {
			    $supported_taxonomies[$category->term_id] = $category->name;
			}
		}

		return $supported_taxonomies;
	}

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'alone-addons' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
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
				'prefix_class' => 'elementor-grid%s-',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'alone-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'show_thumbnail',
			[
				'label' => __( 'Thumbnail', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'medium',
				'exclude' => [ 'custom' ],
				'condition' => [
					'_skin' => '',
					'show_thumbnail!'=> '',
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
					'_skin' => '',
					'show_thumbnail!'=> '',
				],
			]
		);

		$this->add_control(
			'show_goal_progress',
			[
				'label' => __( 'Goal Progress', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Title', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => __( 'Excerpt', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'alone-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 25,
				'condition' => [
					'_skin' => '',
					'show_excerpt!' => '',
				],
			]
		);

		$this->add_control(
			'excerpt_more',
			[
				'label' => __( 'Excerpt More', 'alone-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'condition' => [
					'_skin' => '',
					'show_excerpt!' => '',
				],
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
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'donation_button_label',
			[
				'label' => __( 'Donation button Label', 'alone-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Donate Now', 'alone-addons' ),
				'condition' => [
					'_skin' => '',
					'show_donation_button!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'alone-addons' ),
			]
		);

		$this->start_controls_tabs( 'tabs_query' );

		$this->start_controls_tab(
			'tab_query_include',
			[
				'label' => __( 'Include', 'elementor' ),
			]
		);

		$this->add_control(
			'ids',
			[
				'label' => __( 'Ids', 'alone-addons' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_ids(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'category',
			[
				'label' => __( 'Category', 'alone-addons' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_taxonomies(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'tab_query_exnlude',
			[
				'label' => __( 'Exclude', 'elementor' ),
			]
		);

		$this->add_control(
			'ids_exclude',
			[
				'label' => __( 'Ids', 'alone-addons' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_ids(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'category_exclude',
			[
				'label' => __( 'Category', 'alone-addons' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_taxonomies(),
				'label_block' => true,
				'multiple' => true,
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => __( 'Offset', 'alone-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'description' => __( 'Use this setting to skip over posts (e.g. \'2\' to skip over 2 posts).', 'alone-addons' ),
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date' => __( 'Date', 'alone-addons' ),
					'post_title' => __( 'Title', 'alone-addons' ),
					'menu_order' => __( 'Menu Order', 'alone-addons' ),
					'rand' => __( 'Random', 'alone-addons' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'alone-addons' ),
					'desc' => __( 'DESC', 'alone-addons' ),
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_pagination_section_controls() {
		$this->start_controls_section(
			'section_pagination',
			[
				'label' => __( 'Pagination', 'alone-addons' ),
			]
		);

		$this->add_control(
			'pagination',
			[
				'label' => __( 'Pagination', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'alone-addons' ),
					'number' => __( 'Number', 'alone-addons' ),
					'both' => __( 'Number + Previous/Next', 'alone-addons' ),
				],
			]
		);

		$this->end_controls_section();

	}


	protected function register_design_latyout_section_controls() {
		$this->start_controls_section(
			'section_design_layout',
			[
				'label' => __( 'Layout', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'column_gap',
			[
				'label' => __( 'Columns Gap', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--grid-column-gap: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'row_gap',
			[
				'label' => __( 'Rows Gap', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'_skin' => '',
				],
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
				'condition' => [
					'_skin' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-give-form' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_design_box_section_controls() {
		$this->start_controls_section(
			'section_design_box',
			[
				'label' => __( 'Box', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
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
						'max' => 50,
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

	protected function register_design_image_section_controls() {
		$this->start_controls_section(
			'section_design_image',
			[
				'label' => __( 'Image', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
					'show_thumbnail!' => '',
				],
			]
		);

		$this->add_control(
			'img_border_radius',
			[
				'label' => __( 'Border Radius', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .give-card__media' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

	protected function register_design_content_section_controls() {
		$this->start_controls_section(
			'section_design_content',
			[
				'label' => __( 'Content', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'heading_goal_progress_style',
			[
				'label' => __( 'Goal Progress', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'show_goal_progress!' => '',
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
					'show_goal_progress!' => '',
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
					'show_goal_progress!' => '',
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
					'show_goal_progress!' => '',
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
					'show_goal_progress!' => '',
				],
			]
		);

		$this->add_control(
			'heading_title_style',
			[
				'label' => __( 'Title', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'show_title!' => '',
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
					'show_title!' => '',
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
					'show_title!' => '',
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
					'show_title!' => '',
				],
			]
		);

		$this->add_control(
			'heading_excerpt_style',
			[
				'label' => __( 'Excerpt', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'show_excerpt!' => '',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .give-card__text' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_excerpt!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'default' => '',
				'selector' => '{{WRAPPER}} .give-card__text',
				'condition' => [
					'show_excerpt!' => '',
				],
			]
		);

		$this->add_control(
			'heading_donation_button_style',
			[
				'label' => __( 'Donation Button', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'show_donation_button!' => '',
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
					'show_donation_button!' => '',
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
					'show_donation_button!' => '',
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
					'show_donation_button!' => '',
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
					'show_donation_button!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .give-btn-modal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important',
				],
			]
		);

		$this->start_controls_tabs( 'donation_button_tabs' );

		$this->start_controls_tab( 'donation_button_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
				'condition' => [
					'show_donation_button!' => '',
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
					'{{WRAPPER}} .give-btn-modal,
					{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open' => 'background-color: {{VALUE}}',
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
					'show_donation_button!' => '',
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
					'{{WRAPPER}} .give-btn-modal:hover,
					{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open:hover' => 'background-color: {{VALUE}}',
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

	protected function register_design_give_form_section_controls() {
		$this->start_controls_section(
			'section_design_give_form',
			[
				'label' => __( 'Give Form (Apply On Legacy)', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
					'show_donation_button!' => '',
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
					'.give-form[data-style="elementor-give-forms--default"] .give-total-wrap #give-amount,
					 .give-form[data-style="elementor-give-forms--default"] #give-donation-level-button-wrap .give-btn:not(.give-default-level),
					 .give-form[data-style="elementor-give-forms--default"] #give-donation-level-button-wrap .give-btn:not(.give-default-level):hover,
					 .give-form[data-style="elementor-give-forms--default"] #give-gateway-radio-list > li label:hover,
					 .give-form[data-style="elementor-give-forms--default"] #give-gateway-radio-list > li.give-gateway-option-selected label,
					 .give-form[data-style="elementor-give-forms--default"] #give_terms_agreement label:hover,
					 .give-form[data-style="elementor-give-forms--default"] #give_terms_agreement input[type=checkbox]:checked + label,
					 .give-form[data-style="elementor-give-forms--default"] .give_terms_links:hover,
					 .give-form[data-style="elementor-give-forms--default"] #give-final-total-wrap .give-final-total-amount' => 'color: {{VALUE}};',
					'.give-form[data-style="elementor-give-forms--default"] .give-total-wrap .give-currency-symbol,
					 .give-form[data-style="elementor-give-forms--default"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-forms--default"] #give-gateway-radio-list > li.give-gateway-option-selected label:after,
					 .give-form[data-style="elementor-give-forms--default"] #give_terms_agreement input[type=checkbox]:checked + label:before,
					 .give-form[data-style="elementor-give-forms--default"] #give-final-total-wrap .give-donation-total-label' => 'background-color: {{VALUE}};',
					'.give-form[data-style="elementor-give-forms--default"] #give-donation-level-button-wrap .give-btn:hover,
					 .give-form[data-style="elementor-give-forms--default"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-forms--default"] #give_terms_agreement input[type=checkbox]:checked + label:before' => 'border-color: {{VALUE}};',
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
					'.give-form[data-style="elementor-give-forms--default"]' => 'color: {{VALUE}};',
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
					'.give-form[data-style="elementor-give-forms--default"]' => 'font-family: "{{VALUE}}", sans-serif',
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
					'.give-form[data-style="elementor-give-forms--default"] legend,
					 .give-form[data-style="elementor-give-forms--default"] .give-submit' => 'font-family: "{{VALUE}}", sans-serif',
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
					'.give-form[data-style="elementor-give-forms--default"] .give-submit' => 'color: {{VALUE}};',
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
					'.give-form[data-style="elementor-give-forms--default"] .give-submit' => 'background-color: {{VALUE}};',
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
					'.give-form[data-style="elementor-give-forms--default"] .give-submit:hover' => 'color: {{VALUE}};',
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
					'.give-form[data-style="elementor-give-forms--default"] .give-submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_design_goal_progress_section_controls() {
		$this->start_controls_section(
			'section_goal_progress',
			[
				'label' => __( 'Goal Progress', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
					'show_goal_progress!' => '',
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
					'custom_goal_progress!' => '',
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
					'custom_goal_progress!' => '',
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
					'custom_goal_progress!' => '',
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
					'custom_goal_progress!' => '',
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
					'custom_goal_progress!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_design_pagination_section_controls() {
		$this->start_controls_section(
			'section_design_pagination',
			[
				'label' => __( 'Pagination', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->add_control(
			'pagination_alignment',
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
					'{{WRAPPER}} .elementor-pagination' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_size',
			[
				'label' => __( 'Size', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 45,
				],
				'tablet_default' => [
					'size' => 45,
				],
				'mobile_default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination .nav-links .page-numbers' => 'line-height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->add_control(
			'pagination_border_color',
			[
				'label' => __( 'Border Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination .nav-links' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .elementor-pagination .nav-links .page-numbers:not(:last-child)' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pagination_typography',
				'label' => __( 'Typography', 'alone-addons' ),
				'selector' => '{{WRAPPER}} .elementor-pagination .nav-links .page-numbers',
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_navigation' );

		$this->start_controls_tab(
			'tabs_pagination_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination .nav-links .page-numbers' => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor-pagination .nav-links .page-numbers svg' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->add_control(
			'pagination_background',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination .nav-links .page-numbers' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_pagination_hover',
			[
				'label' => __( 'Hover', 'alone-addons' ),
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->add_control(
			'pagination_color_hover',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination .nav-links .page-numbers:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor-pagination .nav-links .page-numbers.current' => 'color: {{VALUE}}',
					'{{WRAPPER}} .elementor-pagination .nav-links .page-numbers:hover svg' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->add_control(
			'pagination_background_hover',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-pagination .nav-links .page-numbers:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .elementor-pagination .nav-links .page-numbers.current' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'pagination!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_controls() {

		$this->register_layout_section_controls();
		$this->register_query_section_controls();
		$this->register_pagination_section_controls();

		$this->register_design_latyout_section_controls();
		$this->register_design_box_section_controls();
		$this->register_design_image_section_controls();
		$this->register_design_content_section_controls();
		$this->register_design_give_form_section_controls();
		$this->register_design_goal_progress_section_controls();
		$this->register_design_pagination_section_controls();

	}

	public function get_instance_value_skin( $key ) {
		$settings = $this->get_settings_for_display();

		if( !empty( $settings['_skin'] ) && isset( $settings[str_replace( '-', '_', $settings['_skin'] ) . '_' . $key] ) ) {
			 return $settings[str_replace( '-', '_', $settings['_skin'] ) . '_' . $key];
		}
		return $settings[$key];
	}

	public function get_is_edit_mode() {
		if ( Plugin::$instance->editor->is_edit_mode() ) {
			return true;
		} else {
			return false;
		}
	}

	public function query_posts() {
		$settings = $this->get_settings_for_display();

		if( is_front_page() ) {
	    $paged = (get_query_var('page')) ? absint( get_query_var('page') ) : 1;
		} else {
	    $paged = (get_query_var('paged')) ? absint( get_query_var('paged') ) : 1;
		}

		$args = [
			'post_type' => 'give_posts',
			'posts_per_page' => $this->get_instance_value_skin('posts_per_page'),
			'paged' => $paged,
			'orderby' => $settings['orderby'],
			'order' => $settings['order'],
		];

		if( ! empty( $settings['ids'] ) ) {
			$args['post__in'] = $settings['ids'];
		}

		if( ! empty( $settings['ids_exclude'] ) ) {
			$args['post__not_in'] = $settings['ids_exclude'];
		}

		if( ! empty( $settings['category'] ) ) {
			$args['tax_query'] = array(
        array(
            'taxonomy' => 'give_posts_category',
            'field'    => 'term_id',
            'terms'    => $settings['category'],
        ),
    	);
		}

		if( ! empty( $settings['category_exclude'] ) ) {
			$args['tax_query'] = array(
        array(
            'taxonomy' => 'give_posts_category',
            'field'    => 'term_id',
            'terms'    => $settings['category_exclude'],
						'operator' => 'NOT IN',
        ),
    	);
		}

		if( 0 !== absint( $settings['offset'] ) ) {
			$args['offset'] = $settings['offset'];
		}

		return $query = new \WP_Query( $args );
	}

	public function pagination() {
		$settings = $this->get_settings_for_display();

		if ( '' === $settings['pagination'] ) {
			return;
		}

		$query = $this->query_posts();

		if ( ! $query->found_posts ) {
			return;
		}

		?>
		<nav class="elementor-pagination" role="navigation">
			<div class="nav-links">
				<?php
					$big = 999999999;

					if( is_front_page() ) {
						$current = max( 1, get_query_var('page') );
					} else {
						$current = max( 1, get_query_var('paged') );
					}

					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => $current,
						'total' => $query->max_num_pages,
						'mid_size'  => 2,
						'prev_next' => 'both' === $settings['pagination'] ? true : false,
						'prev_text' => '<svg class="svg-icon" width="12" height="12" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 443.52 443.52" style="enable-background:new 0 0 443.52 443.52;" xml:space="preserve"><path d="M143.492,221.863L336.226,29.129c6.663-6.664,6.663-17.468,0-24.132c-6.665-6.662-17.468-6.662-24.132,0l-204.8,204.8    c-6.662,6.664-6.662,17.468,0,24.132l204.8,204.8c6.78,6.548,17.584,6.36,24.132-0.42c6.387-6.614,6.387-17.099,0-23.712    L143.492,221.863z"></path></svg>' . __( 'Prev', 'alone-addons' ),
						'next_text' => __( 'Next', 'alone-addons' ) . '<svg class="svg-icon" width="12" height="12" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 443.52 443.52" style="enable-background:new 0 0 443.52 443.52;" xml:space="preserve"><path d="M336.226,209.591l-204.8-204.8c-6.78-6.548-17.584-6.36-24.132,0.42c-6.388,6.614-6.388,17.099,0,23.712l192.734,192.734    		L107.294,414.391c-6.663,6.664-6.663,17.468,0,24.132c6.665,6.663,17.468,6.663,24.132,0l204.8-204.8    C342.889,227.058,342.889,216.255,336.226,209.591z"></path></svg>',
					) );
				?>
			</div>
		</nav>
		<?php
	}

	public function render_filter() {
		if( 'yes' !== $this->get_instance_value_skin('show_filter') ) {
			return;
		}

		$settings = $this->get_settings_for_display();

		$classes = 'elementor-filter-wrap';

		if( $settings['_skin'] ) {
			$classes .= ' elementor-give-forms--' . $settings['_skin'];
		} else {
			$classes .= ' elementor-gives--default';
		}

		$cats = $this->get_instance_value_skin('filter_category');

		if( !empty( $cats ) ) {
			?>
				<div class="<?php echo esc_attr( $classes ); ?>">
					<ul class="elementor-filter" data-type="give-forms">
						<?php
							echo '<li>
										<a class="elementor-filter__link active" href="#" data-filter="all">' . esc_html__( 'Our Give', 'alone-addons' ) . '</a>
									</li>';

							foreach ($cats as $key => $value) {
								$cat = get_term_by('id', $value, 'give_posts_category');

								echo '<li>
												<a class="elementor-filter__link" href="#" data-filter="' . esc_attr( $cat->slug ) . '">' . $cat->name . '</a>
											</li>';
							}
						?>
					</ul>
				</div>
			<?php
		}

	}

	public function render_loop_header() {
		$settings = $this->get_settings_for_display();

		$classes = 'elementor-grid';

		if( $settings['_skin'] ) {
			$classes .= ' elementor-give-forms--' . $settings['_skin'];
		} else {
			$classes .= ' elementor-give-forms--default';
		}

		?>
			<div class="<?php echo esc_attr( $classes ); ?>">
		<?php
	}

	public function render_loop_footer() {

		?>
			</div>
		<?php
	}

	protected function render_post() {
		$settings = $this->get_settings_for_display();

		$post_id = get_the_ID();
		$form_id = get_field('give_form', $post_id);

		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'elementor-give-form' ); ?>>

			<?php
			if( '' !== $settings['show_thumbnail'] ) {
				// Maybe display the featured image.
				printf(
					'<div class="give-card__media">%s</div>',
					get_the_post_thumbnail( $post_id, $settings['thumbnail_size'] )
				);
			}
			?>

			<div class="give-card__body">
				<?php
				// Maybe display the goal progess bar.
				if ( '' !== $settings['show_goal_progress'] && give_is_setting_enabled( get_post_meta( $form_id, '_give_goal_option', true ) ) ) {

					$args = array(
						'show_text' => true,
						'show_bar' => true,
						'income_text' => __( 'of', 'alone-addons' ),
						'goal_text' => __( 'raised', 'alone-addons' ),
						'custom_goal_progress' => $settings['custom_goal_progress'],

					);

					$bar_opts = array(
						'type' => 'line',
						'strokewidth' => 4,
						'easing' => $settings['goal_progress_easing'],
						'duration' => absint( $settings['goal_progress_duration']['size'] ),
						'color' => $settings['goal_progress_color_from'],
						'trailcolor' => $settings['goal_progress_trailcolor'],
						'trailwidth' => 1,
						'tocolor' => $settings['goal_progress_color_to'],
						'width' => '100%',
						'height' => '12px',
					);

					alone_addons_goal_progress( $form_id, $args, $bar_opts );

				}

				if( '' !== $settings['show_title'] ) {
					// Maybe display the form title.
					printf(
						'<h3 class="give-card__title">
							<a href="%s">%s</a>
						</h3>',
						get_the_permalink(),
						get_the_title()
					);
				}

				if( '' !== $settings['show_excerpt'] ) {
					// Maybe display the form excerpt.
					$raw_content      = ''; // Raw form content.
					$stripped_content = ''; // Form content stripped of HTML tags and shortcodes.
					$excerpt          = ''; // Trimmed form excerpt ready for display.

					if ( has_excerpt( $post_id ) ) {
						// Get excerpt from the form post's excerpt field.
						$raw_content      = get_the_excerpt( $post_id );
						$stripped_content = wp_strip_all_tags(
							strip_shortcodes( $raw_content )
						);
					} else {
						// Get content from the form post's content field.
						$raw_content = get_the_content( $post_id );;

						if ( ! empty( $raw_content ) ) {
							$stripped_content = wp_strip_all_tags(
								strip_shortcodes( $raw_content )
							);
						}
					}

					// Maybe truncate excerpt.
					if ( 0 < absint($settings['excerpt_length']) ) {
						$excerpt = wp_trim_words( $stripped_content, absint($settings['excerpt_length']), '' );
					} else {
						$excerpt = $stripped_content;
					}

					printf( '<p class="give-card__text">%s</p>', $excerpt . $settings['excerpt_more'] );
				}

				if( '' !== $settings['show_donation_button'] ) {
					if( !Template::getActiveID($form_id) ) {
						if ( $this->get_is_edit_mode() ) {
							echo '<div class="root-data-givewp-embed"><button type="button" class="givewp-donation-form-modal__open">' . $settings['donation_button_label'] . '</button></div>';
						} else {
							echo do_shortcode('[give_form id="' . $form_id . '" display_style="modal" continue_button_title="' . $settings['donation_button_label'] . '"]');
						}
					} else {
						// Maybe display the form donate button.
						$atts = array(
							'id' => $form_id,  // integer.
							'show_title' => false, // boolean.
							'show_goal' => false, // boolean.
							'show_content' => 'none', //above, below, or none
							'display_style' => 'button', //modal, button, and reveal
							'continue_button_title' => $settings['donation_button_label'] //string

						);

						add_filter('give_form_html_tags', function($form_html_tags, $form) {
							$form_html_tags['data-style'] = 'elementor-give-forms--default';

							return $form_html_tags;
						}, 10, 2);

						echo give_get_donation_form( $atts );
					}
				}
				?>
			</div>
		</article>
		<?php
	}

	protected function render() {

		$query = $this->query_posts();

		if ( $query->have_posts() ) {

			$this->render_loop_header();

				while ( $query->have_posts() ) {
					$query->the_post();

					$this->render_post();

				}

			$this->render_loop_footer();

		} else {
		    // no posts found
		}

		$this->pagination();

		wp_reset_postdata();
	}

	protected function content_template() {

	}

}
