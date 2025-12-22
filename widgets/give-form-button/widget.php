<?php
namespace AloneAddons\Widgets\Give_Form_Button;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

use Elementor\Plugin;
use Give\Helpers\Form\Template;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Be_Give_Form_Button extends Widget_Base {

	public function get_name() {
		return 'be-give-form-button';
	}

	public function get_title() {
		return __( 'Be Give Form Button', 'alone-addons' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'alone-addons' ];
	}

	public function get_script_depends() {
		return [ 'alone-addons' ];
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
			'section_layout',
			[
				'label' => __( 'Layout', 'alone-addons' ),
			]
		);

		$this->add_control(
      'form_button_text',
      [
        'label' => __( 'Button Text', 'alone-addons' ),
        'label_block' => true,
        'type' => Controls_Manager::TEXT,
        'default' => __( 'Donate Now', 'alone-addons' ),
      ]
    );

		$this->add_control(
			'form_id',
			[
				'label' => __( 'Form Id', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_supported_post_ids(),
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
					'{{WRAPPER}} .give-form-wrap .give-btn-modal' => 'text-align: {{VALUE}};',
				],
			]
		);

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name' => 'give_btn_typography',
        'default' => '',
        'selector' => '{{WRAPPER}} .give-form-wrap .give-btn-modal,
						{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open',
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
					'{{WRAPPER}} .give-form-wrap .give-btn-modal' => 'fill: {{VALUE}}; color: {{VALUE}};',
					'{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open' => 'fill: {{VALUE}}; color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => __( 'Background', 'alone-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .give-form-wrap .give-btn-modal,
								{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'global' => [
							'type' => Controls_Manager::COLOR,
						],
					],
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
					'{{WRAPPER}} .give-form-wrap .give-btn-modal:hover, {{WRAPPER}} .give-form-wrap .give-btn-modal:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .give-form-wrap .give-btn-modal:hover svg, {{WRAPPER}} .give-form-wrap .give-btn-modal:focus svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open:hover, {{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open:focus' => 'color: {{VALUE}};',
					'{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open:hover svg, {{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open:focus svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background_hover',
				'label' => __( 'Background', 'alone-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .give-form-wrap .give-btn-modal:hover, {{WRAPPER}} .give-form-wrap .give-btn-modal:focus,
								{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open:hover, {{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open:focus',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
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
					'{{WRAPPER}} .give-form-wrap .give-btn-modal:hover, {{WRAPPER}} .give-form-wrap .give-btn-modal:focus,
					{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open:hover, {{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .give-form-wrap .give-btn-modal,
								{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open',
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
					'{{WRAPPER}} .give-form-wrap .give-btn-modal,
					{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .give-form-wrap .give-btn-modal,
								{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => __( 'Padding', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .give-form-wrap .give-btn-modal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
    $this->add_responsive_control(
      'text_margin',
      [
        'label' => __( 'Margin', 'alone-addons' ),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
          '{{WRAPPER}} .give-form-wrap .give-btn-modal,
		  {{WRAPPER}} .root-data-givewp-embed .givewp-donation-form-modal__open' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );


		$this->end_controls_section();
	}

	protected function register_design_form_section_controls() {
		$this->start_controls_section(
			'section_design_form',
			[
				'label' => __( 'Give Form (Apply On Legacy)', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'form_main_color',
			[
				'label' => __( 'Main Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-gt-form form[id*=give-form] .give-total-wrap #give-amount,
					 {{WRAPPER}} .elementor-gt-form form[id*=give-form] #give-donation-level-button-wrap .give-btn:not(.give-default-level)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-gt-form form[id*=give-form] .give-total-wrap .give-currency-symbol,
					 {{WRAPPER}} .elementor-gt-form form[id*=give-form] #give-donation-level-button-wrap .give-btn.give-default-level' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .elementor-gt-form form[id*=give-form] #give-donation-level-button-wrap .give-btn:hover,
					 {{WRAPPER}} .elementor-gt-form form[id*=give-form] #give-donation-level-button-wrap .give-btn.give-default-level' => 'border-color: {{VALUE}};',
					'.give-form[data-style="elementor-give-form-button"] .give-total-wrap #give-amount,
					 .give-form[data-style="elementor-give-form-button"] #give-donation-level-button-wrap .give-btn:not(.give-default-level),
					 .give-form[data-style="elementor-give-form-button"] #give-donation-level-button-wrap .give-btn:not(.give-default-level):hover,
					 .give-form[data-style="elementor-give-form-button"] #give-gateway-radio-list > li label:hover,
					 .give-form[data-style="elementor-give-form-button"] #give-gateway-radio-list > li.give-gateway-option-selected label,
					 .give-form[data-style="elementor-give-form-button"] #give_terms_agreement label:hover,
					 .give-form[data-style="elementor-give-form-button"] #give_terms_agreement input[type=checkbox]:checked + label,
					 .give-form[data-style="elementor-give-form-button"] .give_terms_links:hover,
					 .give-form[data-style="elementor-give-form-button"] #give-final-total-wrap .give-final-total-amount' => 'color: {{VALUE}};',
					'.give-form[data-style="elementor-give-form-button"] .give-total-wrap .give-currency-symbol,
					 .give-form[data-style="elementor-give-form-button"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-form-button"] #give-gateway-radio-list > li.give-gateway-option-selected label:after,
					 .give-form[data-style="elementor-give-form-button"] #give_terms_agreement input[type=checkbox]:checked + label:before,
					 .give-form[data-style="elementor-give-form-button"] #give-final-total-wrap .give-donation-total-label' => 'background-color: {{VALUE}};',
					'.give-form[data-style="elementor-give-form-button"] #give-donation-level-button-wrap .give-btn:hover,
					 .give-form[data-style="elementor-give-form-button"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-form-button"] #give_terms_agreement input[type=checkbox]:checked + label:before' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .elementor-gt-form form[id*=give-form],
					.give-form[data-style="elementor-give-form-button"]' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} form[id*=give-form],
					.give-form[data-style="elementor-give-form-button"]' => 'font-family: "{{VALUE}}", sans-serif',
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
					'{{WRAPPER}} form[id*=give-form] > .give-btn,
					 .give-form[data-style="elementor-give-form-button"] legend,
					 .give-form[data-style="elementor-give-form-button"] .give-submit' => 'font-family: "{{VALUE}}", sans-serif',
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
					'{{WRAPPER}} form[id*=give-form] .give-btn-modal,
					 .give-form[data-style="elementor-give-form-button"] .give-submit' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} form[id*=give-form] .give-btn-modal,
					 .give-form[data-style="elementor-give-form-button"] .give-submit' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} form[id*=give-form] .give-btn-modal:hover,
					 .give-form[data-style="elementor-give-form-button"] .give-submit:hover' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} form[id*=give-form] .give-btn-modal:hover,
					 .give-form[data-style="elementor-give-form-button"] .give-submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_controls() {
		$this->register_layout_section_controls();

		$this->register_design_latyout_section_controls();
		$this->register_design_form_section_controls();
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

	public function render_loop_header() {
		$settings = $this->get_settings_for_display();

		$classes = 'elementor-give-form';

		?>
			<div class="<?php echo esc_attr( $classes ); ?>">
		<?php
	}

	public function render_loop_footer() {

		?>
			</div>
		<?php
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->render_loop_header();

		if( !empty( $settings['form_id'] ) ) {
			if( !Template::getActiveID($settings['form_id']) ) {
				if ( $this->get_is_edit_mode() ) {
					echo '<div class="root-data-givewp-embed"><button type="button" class="givewp-donation-form-modal__open">' . $settings['form_button_text'] . '</button></div>';
				} else {
					echo do_shortcode('[give_form id="' . $form_id . '" display_style="modal" continue_button_title="' . $settings['form_button_text'] . '"]');
				}
			} else {
				// Maybe display the form donate button.
				$atts = array(
					'id' => $settings['form_id'],  // integer.
					'show_title' => false, // boolean.
					'show_goal' => false, // boolean.
					'show_content' => 'none', //above, below, or none
					'display_style' => 'button', //modal, button, and reveal
					'continue_button_title' => $settings['form_button_text'] //string

				);

				add_filter('give_form_html_tags', function($form_html_tags, $form) {
					$form_html_tags['data-style'] = 'elementor-give-form-button';

					return $form_html_tags;
				}, 10, 2);

				echo give_get_donation_form( $atts );
			}
		}

		$this->render_loop_footer();

	}

	protected function content_template() {

	}
}
