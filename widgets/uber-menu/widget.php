<?php
namespace AloneAddons\Widgets\Uber_Menu;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Embed;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Modules\DynamicTags\Module as TagsModule;

use Give\Helpers\Form\Template;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Be_Uber_Menu extends Widget_Base {

	public function get_name() {
		return 'be-uber-menu';
	}

	public function get_title() {
		return __( 'Uber Menu Bears', 'alone-addons' );
	}

	public function get_icon() {
		return 'eicon-archive-posts';
	}

	public function get_categories() {
		return [ 'alone-addons' ];
	}

	public function get_script_depends() {
		return [ 'jquery-magnific-popup', 'alone-addons' ];
	}

	protected function get_supported_post_ids() {
		$supported_taxonomies = [];

		$args = array(
			'post_type' => 'give_forms',
			'post_status'    => 'publish',
		);

		$query = new \WP_Query( $args );
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) : $query->the_post();
			$supported_taxonomies[get_the_ID()] = get_the_title();
			endwhile;
	 		wp_reset_postdata();
	 	endif;

		return $supported_taxonomies;
	}

  protected function register_layout_section_controls() {
    $this->start_controls_section(
			'menu_section',
			[
				'label' => __( 'Menu', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

    $this->add_control(
			'assign',
			[
				'label' => __( 'Assign', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'menu' => __( 'Menu', 'alone-addons' ),
					'theme_location' => __( 'Theme Location', 'alone-addons' ),
				],
				'default' => 'menu',
			]
		);

    //$menu_ops = ubermenu_get_nav_menu_ops();
		$menus = wp_get_nav_menus( array('orderby' => 'name') );
		$menu_ops = array( 0 => '-- Select Menu --' );
		foreach( $menus as $menu ){
			$menu_ops[$menu->term_id] = $menu->name;
		}
		//uberp( $menu_ops );

    $this->add_control(
			'menu',
			[
				'label' => __( 'Menu', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => $menu_ops,
        'default' => 0,
        'condition' => [
          'assign' => 'menu'
        ],
			]
		);

    $theme_location_ops = get_registered_nav_menus(); //ubermenu_get_theme_location_ops();

    $this->add_control(
			'theme_location',
			[
				'label' => __( 'Theme Location', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => $theme_location_ops,
        'condition' => [
          'assign' => 'theme_location',
        ],
			]
		);

    $configs = ubermenu_get_menu_instances(true);
    $config_ops = [];
    foreach( $configs as $config_id ){
      $config_ops[$config_id] = $config_id;
    }

		$this->add_control(
			'config',
			[
				'label' => __( 'Configuration', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => $config_ops,
        'default' => 'main',
			]
		);

		$this->add_control(
			'show_button_donate',
			[
				'label' => __( 'Button Donate', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
      'form_button_text',
      [
        'label' => __( 'Button Text', 'alone-addons' ),
        'label_block' => true,
        'type' => Controls_Manager::TEXT,
        'default' => __( 'Donate Now', 'alone-addons' ),
				'condition' => [
					'show_button_donate!'=> '',
				],
      ]
    );

		$this->add_control(
			'form_id',
			[
				'label' => __( 'Form Id', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_supported_post_ids(),
				'condition' => [
					'show_button_donate!'=> '',
				],
			]
		);

		$this->add_control(
			'show_navigation_search',
			[
				'label' => __( 'Navigation Search', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_navigation_cart',
			[
				'label' => __( 'Navigation Cart', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_navigation_user',
			[
				'label' => __( 'Navigation User', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
			]
		);

		$this->end_controls_section();
  }

  protected function register_design_layout_section_controls() {
    $this->start_controls_section(
      'section_design_layout',
      [
        'label' => __( 'Layout', 'alone-addons' ),
        'tab' => Controls_Manager::TAB_STYLE,
      ]
    );

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'alone-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'alone-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'alone-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'alone-addons' ),
						'icon' => 'eicon-text-align-right',
					],
					'space-between' => [
						'title' => __( 'Justified', 'alone-addons' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .site-menu-wrap-bears' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_menu_color_style',
			[
				'label' => __( 'Menu Top Level', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'uber_menu_typography',
				'default' => '',
				'selector' => '{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav li.ubermenu-item-level-0>a.ubermenu-target',
			]
		);

		$this->start_controls_tabs( 'tabs_uber_menu_style' );

		$this->start_controls_tab(
			'tab_uber_menu_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

		$this->add_control(
			'uber_menu_text_color',
			[
				'label' => __( 'Text Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav li.ubermenu-item-level-0>a.ubermenu-target' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'uber_menu_bg_color',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav li.ubermenu-item-level-0>a.ubermenu-target' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_uber_menu_hover',
			[
				'label' => __( 'Hover, Active', 'alone-addons' ),
			]
		);

		$this->add_control(
			'uber_menu_hover_color',
			[
				'label' => __( 'Text Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav li.ubermenu-current-menu-ancestor.ubermenu-item-level-0>a.ubermenu-target, {{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav li.ubermenu-item-level-0>a.ubermenu-target:hover, {{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav li.ubermenu-item-level-0>a.ubermenu-target:focus, {{WRAPPER}} .site-menu-wrap-bears .ubermenu-item-level-0:hover > .ubermenu-target, {{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav .ubermenu-item-level-0.ubermenu-active > .ubermenu-target, .ubermenu-mobile-modal ul.ubermenu-nav li.ubermenu-current-menu-ancestor.ubermenu-item-level-0>a.ubermenu-target, .ubermenu-mobile-modal ul.ubermenu-nav li.ubermenu-item-level-0>a.ubermenu-target:hover, .ubermenu-mobile-modal ul.ubermenu-nav li.ubermenu-item-level-0>a.ubermenu-target:focus, .ubermenu-mobile-modal .ubermenu-item-level-0:hover > .ubermenu-target, .ubermenu-mobile-modal ul.ubermenu-nav .ubermenu-item-level-0.ubermenu-active > .ubermenu-target' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'uber_menu_bg_hover_color',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav li.ubermenu-item-level-0>a.ubermenu-target:hover,{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav li.ubermenu-current-menu-ancestor.ubermenu-item-level-0>a.ubermenu-target,{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav .ubermenu-item-level-0:hover > .ubermenu-target, {{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav .ubermenu-item-level-0.ubermenu-active > .ubermenu-target,.ubermenu-mobile-modal ul.ubermenu-nav li.ubermenu-item-level-0>a.ubermenu-target:hover,.ubermenu-mobile-modal ul.ubermenu-nav li.ubermenu-current-menu-ancestor.ubermenu-item-level-0>a.ubermenu-target,.ubermenu-mobile-modal ul.ubermenu-nav .ubermenu-item-level-0:hover > .ubermenu-target, .ubermenu-mobile-modal ul.ubermenu-nav .ubermenu-item-level-0.ubermenu-active > .ubermenu-target' => 'background-color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_menu_sub_style',
			[
				'label' => __( 'Menu Sub Level', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'uber_sub_menu_typography',
				'default' => '',
				'selector' => '{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav .ubermenu-submenu li a.ubermenu-target,.ubermenu-mobile-modal ul.ubermenu-nav .ubermenu-submenu li a.ubermenu-target',
			]
		);

		$this->start_controls_tabs( 'tabs_uber_sub_menu_style' );

		$this->start_controls_tab(
			'tab_uber_sub_menu_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

		$this->add_control(
			'uber_sub_menu_text_color',
			[
				'label' => __( 'Text Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav .ubermenu-submenu li a.ubermenu-target,.ubermenu-mobile-modal ul.ubermenu-nav .ubermenu-submenu li a.ubermenu-target' => 'color: {{VALUE}};',
					'{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav .ubermenu-submenu li a.ubermenu-target span.ubermenu-target-description,.ubermenu-mobile-modal ul.ubermenu-nav .ubermenu-submenu li a.ubermenu-target span.ubermenu-target-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
      'uber_sub_menu_bg_color',
      [
        'label' => __( 'Background Color', 'alone-addons' ),
        'type' => Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav .ubermenu-submenu li a.ubermenu-target,.ubermenu-mobile-modal ul.ubermenu-nav .ubermenu-submenu li a.ubermenu-target' => 'background-color: {{VALUE}};',
        ],
      ]
    );

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_uber_sub_menu_hover',
			[
				'label' => __( 'Hover, Active', 'alone-addons' ),
			]
		);

		$this->add_control(
			'uber_sub_menu_hover_color',
			[
				'label' => __( 'Text Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .site-menu-wrap-bears .ubermenu-main ul .ubermenu-submenu li a.ubermenu-target:hover,{{WRAPPER}} .site-menu-wrap-bears .ubermenu-main ul .ubermenu-submenu li.ubermenu-current_page_item a.ubermenu-target, .ubermenu-mobile-modal ul .ubermenu-submenu li a.ubermenu-target:hover,.ubermenu-mobile-modal ul .ubermenu-submenu li.ubermenu-current_page_item a.ubermenu-target' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
      'uber_sub_menu_bg_hover_color',
      [
        'label' => __( 'Background Color', 'alone-addons' ),
        'type' => Controls_Manager::COLOR,
        'default' => '',
        'selectors' => [
          '{{WRAPPER}} .site-menu-wrap-bears .ubermenu-main ul .ubermenu-submenu li a.ubermenu-target:hover,{{WRAPPER}} .site-menu-wrap-bears .ubermenu-main ul .ubermenu-submenu li.ubermenu-current_page_item a.ubermenu-target, .ubermenu-mobile-modal ul .ubermenu-submenu li a.ubermenu-target:hover,.ubermenu-mobile-modal ul .ubermenu-submenu li.ubermenu-current_page_item a.ubermenu-target' => 'background-color: {{VALUE}};',
        ],
      ]
    );


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_mega_style',
			[
				'label' => __( 'Mega Menu', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'uber_bg_color',
			[
				'label' => __( 'Background Mega Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ubermenu-desktop-view.ubermenu-main.ubermenu-horizontal .ubermenu-item > .ubermenu-submenu-drop' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'uber_tab_active_color',
			[
				'label' => __( 'Tabs Active Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .site-menu-wrap-bears .ubermenu-submenu .ubermenu-tabs .ubermenu-tab:hover > .ubermenu-target,.ubermenu-mobile-modal .ubermenu-submenu .ubermenu-tabs .ubermenu-tab:hover > .ubermenu-target' => 'color: {{VALUE}};',
					'{{WRAPPER}} .site-menu-wrap-bears .ubermenu-submenu .ubermenu-tab.ubermenu-active > .ubermenu-target,.ubermenu-mobile-modal .ubermenu-submenu .ubermenu-tab.ubermenu-active > .ubermenu-target' => 'color: {{VALUE}};',
					'{{WRAPPER}} .site-menu-wrap-bears .ubermenu-main .ubermenu-target:hover > .ubermenu-target-description, {{WRAPPER}} .site-menu-wrap-bears .ubermenu-submenu .ubermenu-tab.ubermenu-active > .ubermenu-target > .ubermenu-target-description, {{WRAPPER}} .site-menu-wrap-bears .ubermenu-main .ubermenu-submenu .ubermenu-target:hover > .ubermenu-target-description, {{WRAPPER}} .site-menu-wrap-bears .ubermenu-main .ubermenu-submenu .ubermenu-active > .ubermenu-target > .ubermenu-target-description, .ubermenu-mobile-modal .ubermenu-target:hover > .ubermenu-target-description, .ubermenu-mobile-modal .ubermenu-submenu .ubermenu-tab.ubermenu-active > .ubermenu-target > .ubermenu-target-description, .ubermenu-mobile-modal .ubermenu-submenu .ubermenu-target:hover > .ubermenu-target-description, .ubermenu-mobile-modal .ubermenu-submenu .ubermenu-active > .ubermenu-target > .ubermenu-target-description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'uber_tab_active_bg_color',
			[
				'label' => __( 'Background Tabs Active', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .site-menu-wrap-bears .ubermenu-submenu .ubermenu-tabs .ubermenu-tab:hover > .ubermenu-target,.ubermenu-mobile-modal .ubermenu-submenu .ubermenu-tabs .ubermenu-tab:hover > .ubermenu-target' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .site-menu-wrap-bears .ubermenu-submenu .ubermenu-tab.ubermenu-active > .ubermenu-target,.ubermenu-mobile-modal .ubermenu-submenu .ubermenu-tab.ubermenu-active > .ubermenu-target' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border-mega',
				'selector' => '{{WRAPPER}} .ubermenu-desktop-view.ubermenu-main.ubermenu-horizontal .ubermenu-item > .ubermenu-submenu-drop',
			]
		);

		$this->add_control(
			'border_radius_mega',
			[
				'label' => __( 'Border Radius', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ubermenu-desktop-view.ubermenu-main.ubermenu-horizontal .ubermenu-item > .ubermenu-submenu-drop' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_mega_shadow',
				'selector' => '{{WRAPPER}} .ubermenu-desktop-view.ubermenu-main.ubermenu-horizontal .ubermenu-item > .ubermenu-submenu-drop',
			]
		);

		$this->add_control(
			'heading_menu_icon_style',
			[
				'label' => __( 'Menu Icon', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'font_size_menu_icon',
			[
				'label' => __( 'Font size', 'alone-addons' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'default' => __( '15px', 'alone-addons' ),
				'selectors' => [
					'{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav .ubermenu-submenu li a.ubermenu-target i.fas' => 'font-size: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_uber_icon_style' );

		$this->start_controls_tab(
			'tab_uber_icon_menu_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

		$this->add_control(
			'uber_menu_icon_color',
			[
				'label' => __( 'Icon Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .site-menu-wrap-bears ul.ubermenu-nav .ubermenu-submenu li a.ubermenu-target i.fas' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_uber_icon_menu_hover',
			[
				'label' => __( 'Hover, Active', 'alone-addons' ),
			]
		);

		$this->add_control(
			'uber_icon_menu_hover_color',
			[
				'label' => __( 'Icon Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .site-menu-wrap-bears .ubermenu-main ul .ubermenu-submenu li a.ubermenu-target:hover i.fas' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

    $this->end_controls_section();
  }

	protected function register_design_button_donate_section_controls() {
		$this->start_controls_section(
			'section_design_button',
			[
				'label' => __( 'Button Donate', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button_donate!'=> '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'give_btn_typography',
				'default' => '',
				'selector' => '{{WRAPPER}} .give-btn, 
								{{WRAPPER}} .givewp-donation-form-modal__open',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .give-btn' => 'fill: {{VALUE}}; color: {{VALUE}};',
					'{{WRAPPER}} .givewp-donation-form-modal__open' => 'fill: {{VALUE}} !important; color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .give-btn' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .givewp-donation-form-modal__open' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'alone-addons' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .give-btn:hover, {{WRAPPER}} .give-btn:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .give-btn:hover svg, {{WRAPPER}} .give-btn:focus svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .givewp-donation-form-modal__open:hover, {{WRAPPER}} .givewp-donation-form-modal__open:focus' => 'color: {{VALUE}} !important;;',
					'{{WRAPPER}} .givewp-donation-form-modal__open:hover svg, {{WRAPPER}} .givewp-donation-form-modal__open:focus svg' => 'fill: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'button_bg_color_hover',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .give-btn:hover, {{WRAPPER}} .give-btn:focus' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .givewp-donation-form-modal__open:hover, {{WRAPPER}} .givewp-donation-form-modal__open:focus' => 'background-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .give-btn:hover, {{WRAPPER}} .give-btn:focus' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .givewp-donation-form-modal__open:hover, {{WRAPPER}} .givewp-donation-form-modal__open:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .give-btn, 
								{{WRAPPER}} .givewp-donation-form-modal__open',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .give-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .givewp-donation-form-modal__open' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .give-btn, 
								{{WRAPPER}} .givewp-donation-form-modal__open',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => __( 'Padding', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .give-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .givewp-donation-form-modal__open' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;;',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'text_margin',
			[
				'label' => __( 'Margin', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .give-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .givewp-donation-form-modal__open' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);


		$this->end_controls_section();
	}

	protected function register_design_form_section_controls() {
		$this->start_controls_section(
			'section_design_form',
			[
				'label' => __( 'Give Form', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button_donate!'=> '',
				],
			]
		);

		$this->add_control(
			'form_text_color',
			[
				'label' => __( 'Text Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.give-form[data-style="elementor-give-uber-menu"],
					.give-form[data-style="elementor-give-uber-menu"] #give-donation-level-button-wrap .give-btn' => 'color: {{VALUE}};',
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
					'.give-form[data-style="elementor-give-uber-menu"] .give-total-wrap #give-amount,
					.give-form[data-style="elementor-give-uber-menu"] #give-donation-level-button-wrap .give-btn:not(.give-default-level),
					 .give-form[data-style="elementor-give-uber-menu"] #give-donation-level-button-wrap .give-btn:not(.give-default-level):hover,
					 .give-form[data-style="elementor-give-uber-menu"] #give-gateway-radio-list > li label:hover,
					 .give-form[data-style="elementor-give-uber-menu"] #give-gateway-radio-list > li.give-gateway-option-selected label,
					 .give-form[data-style="elementor-give-uber-menu"] #give_terms_agreement label:hover,
					 .give-form[data-style="elementor-give-uber-menu"] #give_terms_agreement input[type=checkbox]:checked + label,
					 .give-form[data-style="elementor-give-uber-menu"] .give_terms_links:hover,
					 .give-form[data-style="elementor-give-uber-menu"] #give-final-total-wrap .give-final-total-amount' => 'color: {{VALUE}};',
					'.give-form[data-style="elementor-give-uber-menu"] .give-total-wrap .give-currency-symbol,
					 .give-form[data-style="elementor-give-uber-menu"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-uber-menu"] #give-gateway-radio-list > li.give-gateway-option-selected label:after,
					 .give-form[data-style="elementor-give-uber-menu"] #give_terms_agreement input[type=checkbox]:checked + label:before,
					 .give-form[data-style="elementor-give-uber-menu"] #give-final-total-wrap .give-donation-total-label' => 'background-color: {{VALUE}};',
					'.give-form[data-style="elementor-give-uber-menu"] #give-donation-level-button-wrap .give-btn:hover,
					 .give-form[data-style="elementor-give-uber-menu"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-uber-menu"] #give_terms_agreement input[type=checkbox]:checked + label:before' => 'border-color: {{VALUE}};',
				]
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
					'.give-form[data-style="elementor-give-uber-menu"]' => 'font-family: "{{VALUE}}", sans-serif',
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
					'.give-form[data-style="elementor-give-uber-menu"] legend,
					 .give-form[data-style="elementor-give-uber-menu"] .give-submit' => 'font-family: "{{VALUE}}", sans-serif',
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
					'.give-form[data-style="elementor-give-uber-menu"] .give-submit' => 'color: {{VALUE}};',
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
					'.give-form[data-style="elementor-give-uber-menu"] .give-submit' => 'background-color: {{VALUE}};',
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
					'.give-form[data-style="elementor-give-uber-menu"] .give-submit:hover' => 'color: {{VALUE}};',
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
					'.give-form[data-style="elementor-give-uber-menu"] .give-submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_design_navigation_section_controls() {
		$this->start_controls_section(
			'section_design_icon_layout',
			[
				'label' => __( 'Design Icon', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_navi',
				'selector' => '{{WRAPPER}} .extras-navigation .extra-item .toggle-icon',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_radius_navi',
			[
				'label' => __( 'Border Radius', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .extra-item .toggle-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'navi_box_shadow',
				'selector' => '{{WRAPPER}} .extras-navigation .extra-item .toggle-icon',
			]
		);

		$this->add_responsive_control(
			'navi_padding',
			[
				'label' => __( 'Padding', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .extra-item .toggle-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'navi_margin',
			[
				'label' => __( 'Margin', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .extra-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_cart',
			[
				'label' => __( 'Cart Icon', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_navigation_cart!'=> '',
				],
			]
		);

		$this->add_control(
			'icon_cart_size',
			[
				'label' => __( 'Icon Size', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .toggle-item.mini-cart a.toggle-icon svg' => 'width: {{SIZE}}{{UNIT}};height:auto;',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon_cart' );

		$this->start_controls_tab(
			'tab_icon_cart_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

		$this->add_control(
			'icon_cart_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .toggle-item.mini-cart a.toggle-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_cart_bg_color',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .toggle-item.mini-cart a.toggle-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_cart_hover',
			[
				'label' => __( 'Hover', 'alone-addons' ),
			]
		);

		$this->add_control(
			'icon_cart_color_hover',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .toggle-item.mini-cart a.toggle-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_cart_bg_hover_color',
			[
				'label' => __( 'Background Hover', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .toggle-item.mini-cart a.toggle-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'cart_counter_bg_color',
			[
				'label' => __( 'Background Cart Counter', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mini-cart .toggle-icon .mini-cart-counter' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'cart_counter_color',
			[
				'label' => __( 'Color Cart Counter', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .mini-cart .toggle-icon .mini-cart-counter' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_icon_search',
			[
				'label' => __( 'Icon Search', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_navigation_search!'=> '',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .toggle-item.mini-search a.toggle-icon svg' => 'width: {{SIZE}}{{UNIT}};height:auto;',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon_search' );

		$this->start_controls_tab(
			'tab_icon_search_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

		$this->add_control(
			'icon_search_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .toggle-item.mini-search a.toggle-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_search_background_color',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .toggle-item.mini-search a.toggle-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_search_hover',
			[
				'label' => __( 'Hover', 'alone-addons' ),
			]
		);

		$this->add_control(
			'icon_search_color_hover',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .toggle-item.mini-search a.toggle-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_search_bg_hover_color',
			[
				'label' => __( 'Background Hover', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .toggle-item.mini-search a.toggle-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_design_icon_user',
			[
				'label' => __( 'Icon User', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_navigation_user!'=> '',
				],
			]
		);

		$this->add_control(
			'icon_user_size',
			[
				'label' => __( 'Icon Size', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .mini-user a.toggle-icon svg' => 'width: {{SIZE}}{{UNIT}};height:auto;',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon_user' );

		$this->start_controls_tab(
			'tab_icon_user_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

		$this->add_control(
			'icon_user_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .mini-user a.toggle-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_user_bg_color',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .mini-user a.toggle-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_user_search_hover',
			[
				'label' => __( 'Hover', 'alone-addons' ),
			]
		);

		$this->add_control(
			'icon_user_color_hover',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .mini-user a.toggle-icon:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_user_bg_hover_color',
			[
				'label' => __( 'Background Hover', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .extras-navigation .mini-user a.toggle-icon:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_controls() {
		$this->register_layout_section_controls();

		$this->register_design_layout_section_controls();
			$this->register_design_button_donate_section_controls();
			$this->register_design_form_section_controls();
			$this->register_design_navigation_section_controls();
	}

  	public function get_is_edit_mode() {
		if ( Plugin::$instance->editor->is_edit_mode() ) {
			return true;
		} else {
			return false;
		}
	}

	protected function render() {
    $settings = $this->get_settings_for_display();

    $config = $settings['config'];
    $menu = $settings['menu'];
    $theme_location = $settings['theme_location'];

		?><div class="site-menu-wrap-bears"><?php

    switch( $settings['assign'] ){
      case 'menu':

        if( !$settings['menu'] ){
          ubermenu_admin_notice( 'Please select a <strong>Menu</strong> in the Elementor settings' );
          return;
        }

        ubermenu( $config , [ 'menu' => $settings['menu'] ] );
        break;

      case 'theme_location':

        if( !$settings['theme_location'] ){
          ubermenu_admin_notice( 'Please select a <strong>Theme Location</strong> in the Elementor settings' );
          return;
        }

        ubermenu( $config , ['theme_location' => $settings['theme_location'] ] );
        break;
    }

		?><div id="site-extras-navigation" class="extras-navigation">
				<?php
					if( '' !== $settings['show_navigation_search'] ) { alone_site_branding_extras_navigation_search(); }
				?>

				<?php
					if ( class_exists( 'WooCommerce' ) ) {
						if( '' !== $settings['show_navigation_cart'] ) { alone_site_branding_extras_navigation_cart(); }
					}
				?>

				<?php
					if( '' !== $settings['show_navigation_user'] ) { alone_site_branding_extras_navigation_user(); }
				?>

				<?php
				if ( class_exists( 'Give' ) ) {
					if( '' !== $settings['show_button_donate'] && !empty( $settings['form_id'] ) ) {
						$form_id = $settings['form_id'];

						if( !Template::getActiveID($form_id) ) {
							if ( $this->get_is_edit_mode() ) {
								echo '<div class="root-data-givewp-embed"><button type="button" class="givewp-donation-form-modal__open">' . esc_html__( 'Donate Now', 'alone' ) . '</button></div>';
							} else {
								echo do_shortcode('[give_form id="' . $form_id . '" display_style="modal" continue_button_title="' . esc_html__( 'Donate Now', 'alone' ) . '"]');
							}
						} else {
							$donation_btn_text = $settings['form_button_text'] ? $settings['form_button_text'] : esc_html__( 'Donate Now', 'alone' );
							// Maybe display the form donate button.
							$atts = array(
								'id' => $form_id,  // integer.
								'show_title' => false, // boolean.
								'show_goal' => false, // boolean.
								'show_content' => 'none', //above, below, or none
								'display_style' => 'button', //modal, button, and reveal
								'continue_button_title' => $donation_btn_text //string

							);

							add_filter('give_form_html_tags', function($form_html_tags, $form) {
								$form_html_tags['data-style'] = 'elementor-give-uber-menu';

								return $form_html_tags;
							}, 10, 2);

							echo give_get_donation_form( $atts );
						}
					}
				}
				?>
			</div>
		</div><?php
  }

	protected function content_template() {}

}
