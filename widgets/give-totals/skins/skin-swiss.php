<?php
namespace AloneAddons\Widgets\Give_Totals\Skins;

use Elementor\Widget_Base;
use Elementor\Skin_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

use Give\Helpers\Form\Template;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Swiss extends Skin_Base {

	protected function _register_controls_actions() {
		add_action( 'elementor/element/be-give-totals/section_layout/before_section_end', [ $this, 'register_layout_section_controls' ] );
    	add_action( 'elementor/element/be-give-totals/section_design_layout/after_section_end', [ $this, 'register_design_give_total_box_controls' ] );
		add_action( 'elementor/element/be-give-totals/section_design_layout/after_section_end', [ $this, 'register_design_give_total_section_controls' ] );
		add_action( 'elementor/element/be-give-totals/section_design_layout/after_section_end', [ $this, 'register_design_give_form_section_controls' ] );

	}

	public function get_id() {
		return 'skin-swiss';
	}


	public function get_title() {
		return __( 'Swiss', 'alone-addons' );
	}


	public function register_layout_section_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->parent->start_injection( [
			'at' => 'after',
			'of' => 'form_id',
		] );

        $this->add_control(
			'bottom_text',
			[
				'label' => __( 'Bottom Text', 'alone-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'By donating, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>', 'alone-addons' ),
			]
		);
		
		$this->parent->end_injection();

	}


  public function register_design_give_total_box_controls( Widget_Base $widget ) {
		$this->parent = $widget;

    $this->start_controls_section(
			'section_design_box',
			[
				'label' => __( 'Box', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_control(
			'box_background',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-give-totals' => 'background-color: {{VALUE}};',
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
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-give-totals' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
  }
	public function register_design_give_total_section_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_design_give_totals',
			[
				'label' => __( 'Give Total', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_bottom_text_style',
			[
				'label' => __( 'Bottom Text', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'bottom_text_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-gt-bottom__text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'bottom_text_typography',
				'label' => __( 'Typography', 'alone-addons' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .elementor-gt-bottom__text',
			]
		);

		$this->add_control(
			'heading_goal_progress_style',
			[
				'label' => __( 'Goal Progress', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
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
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'goal_progress_typography',
				'label' => __( 'Typography', 'alone-addons' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .give-goal-progress',
			]
		);

		$this->end_controls_section();
	}

	public function register_design_give_form_section_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_design_give_form',
			[
				'label' => __( 'Give Form', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'form_id!'=> '',
				],
			]
		);

		$this->add_control(
			'heading_form',
			[
				'label' => __( 'Give Form (Apply On Legacy)', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
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
					'.give-form[data-style="elementor-give-totals--swiss"] .give-total-wrap #give-amount,
					 .give-form[data-style="elementor-give-totals--swiss"] #give-donation-level-button-wrap .give-btn:not(.give-default-level),
					 .give-form[data-style="elementor-give-totals--swiss"] #give-donation-level-button-wrap .give-btn:not(.give-default-level):hover,
					 .give-form[data-style="elementor-give-totals--swiss"] #give-gateway-radio-list > li label:hover,
					 .give-form[data-style="elementor-give-totals--swiss"] #give-gateway-radio-list > li.give-gateway-option-selected label,
					 .give-form[data-style="elementor-give-totals--swiss"] #give_terms_agreement label:hover,
					 .give-form[data-style="elementor-give-totals--swiss"] #give_terms_agreement input[type=checkbox]:checked + label,
					 .give-form[data-style="elementor-give-totals--swiss"] .give_terms_links:hover,
					 .give-form[data-style="elementor-give-totals--swiss"] #give-final-total-wrap .give-final-total-amount' => 'color: {{VALUE}};',
					'.give-form[data-style="elementor-give-totals--swiss"] .give-total-wrap .give-currency-symbol,
					 .give-form[data-style="elementor-give-totals--swiss"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-totals--swiss"] #give-gateway-radio-list > li.give-gateway-option-selected label:after,
					 .give-form[data-style="elementor-give-totals--swiss"] #give_terms_agreement input[type=checkbox]:checked + label:before,
					 .give-form[data-style="elementor-give-totals--swiss"] #give-final-total-wrap .give-donation-total-label' => 'background-color: {{VALUE}};',
					'.give-form[data-style="elementor-give-totals--swiss"] #give-donation-level-button-wrap .give-btn:hover,
					 .give-form[data-style="elementor-give-totals--swiss"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-totals--swiss"] #give_terms_agreement input[type=checkbox]:checked + label:before' => 'border-color: {{VALUE}};',
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
					.give-form[data-style="elementor-give-totals--swiss"]' => 'color: {{VALUE}};',
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
					.give-form[data-style="elementor-give-totals--swiss"]' => 'font-family: "{{VALUE}}", sans-serif',
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
					 .give-form[data-style="elementor-give-totals--swiss"] legend,
					 .give-form[data-style="elementor-give-totals--swiss"] .give-submit' => 'font-family: "{{VALUE}}", sans-serif',
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
					 .give-form[data-style="elementor-give-totals--swiss"] .give-submit' => 'color: {{VALUE}};',
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
					 .give-form[data-style="elementor-give-totals--swiss"] .give-submit' => 'background-color: {{VALUE}};',
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
					 .give-form[data-style="elementor-give-totals--swiss"] .give-submit:hover' => 'color: {{VALUE}};',
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
					 .give-form[data-style="elementor-give-totals--swiss"] .give-submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();

		$total_earnings = get_option( 'give_earnings_total', false );
		if( '' !== $settings['custom_total_earnings'] ) {
			$total_earnings = $settings['total_earnings'];
		}

		$args = array(
			'total_earnings' => $total_earnings, // integer.
			'total_goal'   => $settings['total_goal'], // integer.
			'ids'          => $settings['ids'], // integer|array.
			'cats'         => $settings['category'], // integer|array.
			'tags'         => 0, // integer|array.
			'message'      => apply_filters( 'give_totals_message', __( 'Hey! We\'ve raised {total} of the {total_goal} we are trying to raise for this campaign!', 'alone-addons' ) ),
			'link'         => '', // URL.
			'link_text'    => __( 'Donate Now', 'alone-addons' ), // string,
			'progress_bar' => true, // boolean.
			'show_text' => true, // boolean.
			'show_bar' => true, // boolean.
			'income_text' => __( 'Raised:', 'alone-addons' ),
			'goal_text' => __( 'Goal:', 'alone-addons' ),
			'custom_goal_progress' => $settings['custom_goal_progress'],
		);

		$bar_opts = array(
			'type' => 'line',
			'strokewidth' => 1,
			'easing' => $settings['goal_progress_easing'],
			'duration' => absint( $settings['goal_progress_duration']['size'] ),
			'color' => $settings['goal_progress_color_from'],
			'trailcolor' => $settings['goal_progress_trailcolor'],
			'trailwidth' => 1,
			'tocolor' => $settings['goal_progress_color_to'],
			'width' => '100%',
			'height' => '15px',
		);

		$this->parent->render_loop_header();

		?>

			<div class="elementor-gt-header">
				<?php echo alone_addons_give_totals ( $args, $bar_opts ); ?>
			</div>

			<div class="elementor-gt-form">

				<?php
					if( !empty( $settings['form_id'] ) ) {
						if( !Template::getActiveID($settings['form_id']) ) {
							echo do_shortcode('[give_form id="' . $settings['form_id'] . '"]');
						} else {
							// Maybe display the form donate button.
							$atts = array(
								'id' => $settings['form_id'],  // integer.
								'show_title' => false, // boolean.
								'show_goal' => false, // boolean.
								'show_content' => 'none', //above, below, or none
								'display_style' => 'modal', //modal, button, and reveal
								'continue_button_title' => '' //string
			
							);
			
							add_filter('give_form_html_tags', function($form_html_tags, $form) {
								$form_html_tags['data-style'] = 'elementor-give-totals--swiss';
			
								return $form_html_tags;
							}, 10, 2);
			
							echo give_get_donation_form( $atts );
						}
					}
				?>

			</div>

      <div class="elementor-gt-bottom">
        <?php 
            if( $this->parent->get_instance_value_skin('bottom_text') ) {
                echo '<div class="elementor-gt-bottom__text">' . $this->parent->get_instance_value_skin('bottom_text') . '</div>';
            }
        ?>
      </div>

		<?php

		$this->parent->render_loop_footer();

	}

	protected function content_template() {

	}

}
