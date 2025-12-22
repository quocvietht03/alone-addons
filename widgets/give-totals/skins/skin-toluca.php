<?php
namespace AloneAddons\Widgets\Give_Totals\Skins;

use Elementor\Widget_Base;
use Elementor\Skin_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

use Give\Helpers\Form\Template;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Toluca extends Skin_Base {

	protected function _register_controls_actions() {
		add_action( 'elementor/element/be-give-totals/section_layout/before_section_end', [ $this, 'register_layout_section_controls' ] );
    	add_action( 'elementor/element/be-give-totals/section_design_layout/after_section_end', [ $this, 'register_design_give_total_box_controls' ] );
		add_action( 'elementor/element/be-give-totals/section_design_layout/after_section_end', [ $this, 'register_design_give_total_section_controls' ] );
		add_action( 'elementor/element/be-give-totals/section_design_layout/after_section_end', [ $this, 'register_design_give_form_section_controls' ] );

	}

	public function get_id() {
		return 'skin-toluca';
	}


	public function get_title() {
		return __( 'Toluca', 'alone-addons' );
	}


	public function register_layout_section_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->parent->start_injection( [
			'at' => 'before',
			'of' => 'total_goal',
		] );
		$this->add_control(
			'header_title',
			[
				'label' => __( 'Title', 'alone-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Welcome To Donate & Give <span>Bright Future</span>', 'alone-addons' ),
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
			'heading_header_title_style',
			[
				'label' => __( 'Title', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'header_title_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-gt-header__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_title_typography',
				'label' => __( 'Typography', 'alone-addons' ),
				'default' => '',
				'selector' => '{{WRAPPER}} .elementor-gt-header__title',
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
			]
		);

		$this->add_control(
			'heading_form',
			[
				'label' => __( 'Give Form (Apply On Legacy)', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
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
					'.give-form[data-style="elementor-give-totals--toluca"] .give-total-wrap #give-amount,
					 .give-form[data-style="elementor-give-totals--toluca"] #give-donation-level-button-wrap .give-btn:not(.give-default-level),
					 .give-form[data-style="elementor-give-totals--toluca"] #give-donation-level-button-wrap .give-btn:not(.give-default-level):hover,
					 .give-form[data-style="elementor-give-totals--toluca"] #give-gateway-radio-list > li label:hover,
					 .give-form[data-style="elementor-give-totals--toluca"] #give-gateway-radio-list > li.give-gateway-option-selected label,
					 .give-form[data-style="elementor-give-totals--toluca"] #give_terms_agreement label:hover,
					 .give-form[data-style="elementor-give-totals--toluca"] #give_terms_agreement input[type=checkbox]:checked + label,
					 .give-form[data-style="elementor-give-totals--toluca"] .give_terms_links:hover,
					 .give-form[data-style="elementor-give-totals--toluca"] #give-final-total-wrap .give-final-total-amount' => 'color: {{VALUE}};',
					'.give-form[data-style="elementor-give-totals--toluca"] .give-total-wrap .give-currency-symbol,
					 .give-form[data-style="elementor-give-totals--toluca"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-totals--toluca"] #give-gateway-radio-list > li.give-gateway-option-selected label:after,
					 .give-form[data-style="elementor-give-totals--toluca"] #give_terms_agreement input[type=checkbox]:checked + label:before,
					 .give-form[data-style="elementor-give-totals--toluca"] #give-final-total-wrap .give-donation-total-label' => 'background-color: {{VALUE}};',
					'.give-form[data-style="elementor-give-totals--toluca"] #give-donation-level-button-wrap .give-btn:hover,
					 .give-form[data-style="elementor-give-totals--toluca"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-totals--toluca"] #give_terms_agreement input[type=checkbox]:checked + label:before' => 'border-color: {{VALUE}};',
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
					.give-form[data-style="elementor-give-totals--toluca"]' => 'color: {{VALUE}};',
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
					.give-form[data-style="elementor-give-totals--toluca"]' => 'font-family: "{{VALUE}}", sans-serif',
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
					 .give-form[data-style="elementor-give-totals--toluca"] legend,
					 .give-form[data-style="elementor-give-totals--toluca"] .give-submit' => 'font-family: "{{VALUE}}", sans-serif',
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
					 .give-form[data-style="elementor-give-totals--toluca"] .give-submit' => 'color: {{VALUE}};',
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
					 .give-form[data-style="elementor-give-totals--toluca"] .give-submit' => 'background-color: {{VALUE}};',
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
					 .give-form[data-style="elementor-give-totals--toluca"] .give-submit:hover' => 'color: {{VALUE}};',
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
					 .give-form[data-style="elementor-give-totals--toluca"] .give-submit:hover' => 'background-color: {{VALUE}};',
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
			'message'      => '', // apply_filters( 'give_totals_message', __( 'Hey! We\'ve raised {total} of the {total_goal} we are trying to raise for this campaign!', 'alone-addons' ) ),
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
				<?php
					if( $this->parent->get_instance_value_skin('header_title') ) {
                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="58" height="58" viewBox="0 0 58 58" fill="currentColor">
                                <path d="M36.7122 20.0928C33.5618 17.0206 29.7726 18.2803 27.6916 20.9412C25.6118 18.2848 21.8191 17.0206 18.6699 20.0939C17.6424 21.178 16.598 23.1978 17.4532 26.6642C19.1298 33.0499 26.8307 38.2449 27.6927 38.3786C28.6839 38.1804 36.2874 32.9547 37.93 26.6631C38.7841 23.1967 37.7396 21.1769 36.7122 20.0928ZM36.2806 26.2507C35.0719 31.1445 29.3512 35.3665 27.6916 36.5038C26.032 35.371 20.3113 31.1456 19.1026 26.2519C18.5713 24.0995 18.8489 22.3765 19.9035 21.2618C20.6884 20.4655 21.7536 20.0078 22.8715 19.9863C25.1711 19.9863 26.9927 22.8002 26.9383 22.8376C27.2351 23.4357 28.1436 23.4357 28.4427 22.8376C28.4551 22.8138 29.7261 20.4677 32.0801 20.0203C32.8629 19.8707 34.4352 20.1573 35.4785 21.2584C36.5219 22.3595 36.8164 24.1006 36.2806 26.2507Z"></path>
                                <path d="M17.2788 10.4219C17.8849 11.6589 18.5113 12.9379 18.9984 13.8441C19.9851 15.6736 21.545 17.2426 21.6107 17.3117C21.7699 17.4712 21.986 17.5609 22.2114 17.5612C22.4368 17.5614 22.6531 17.472 22.8126 17.3128C22.9721 17.1536 23.0619 16.9375 23.0621 16.7121C23.0623 16.4867 22.973 16.2704 22.8137 16.1109C22.799 16.0973 21.3649 14.6518 20.4949 13.0376C20.0225 12.1608 19.4028 10.8966 18.8047 9.67425C18.2258 8.49612 17.6798 7.3803 17.2482 6.57034C16.9356 5.98468 17.0216 5.63124 17.1157 5.58253C17.238 5.51569 17.7149 5.68561 18.1669 6.50124C19.0109 8.026 20.7361 10.3596 22.0355 12.052C22.7067 12.9483 23.5775 13.6759 24.5788 14.1771C25.5802 14.6783 26.6846 14.9392 27.8043 14.9392C28.9241 14.9392 30.0285 14.6783 31.0298 14.1771C32.0312 13.6759 32.902 12.9483 33.5732 12.052C34.8725 10.3641 36.5978 8.03054 37.4429 6.50124C37.896 5.68448 38.3718 5.51569 38.4941 5.58253C38.5836 5.63124 38.6742 5.98468 38.3616 6.57034C37.3828 8.41003 36.1367 11.1016 35.1093 13.0523C34.2699 14.6609 32.8165 16.095 32.8029 16.1109C32.2557 16.6286 32.6545 17.5835 33.3965 17.5677C33.6188 17.568 33.8324 17.481 33.9912 17.3253C34.058 17.2596 35.6485 15.694 36.6159 13.8407C37.6354 11.8946 38.8895 9.20186 39.8603 7.37577C41.5108 4.09741 37.7589 2.32569 35.9555 5.67655C35.1625 7.10956 33.4905 9.36839 32.2274 11.011C31.7154 11.7019 31.0487 12.2632 30.2807 12.65C29.5127 13.0368 28.6648 13.2382 27.8049 13.2382C26.945 13.2382 26.0971 13.0368 25.329 12.65C24.561 12.2632 23.8943 11.7019 23.3824 11.011C22.1193 9.36839 20.4461 7.10956 19.6532 5.67768C18.6563 3.87651 17.2176 3.59104 16.3034 4.09175C15.1299 4.73065 15.1366 6.22597 15.7495 7.3769C16.1664 8.15628 16.7067 9.2585 17.2788 10.4219Z"></path>
                                <path d="M4.93451 32.5004C6.81158 32.1662 10.2145 31.7562 12.0973 31.4107C14.1613 31.0346 16.6127 29.6605 16.7158 29.5982C16.9065 29.4847 17.0452 29.301 17.1023 29.0865C17.1594 28.8721 17.1303 28.6438 17.0212 28.4505C16.9121 28.2572 16.7317 28.1143 16.5186 28.0523C16.3055 27.9903 16.0766 28.0141 15.8809 28.1187C15.8582 28.1312 13.5722 29.4112 11.7926 29.7352C9.91775 30.0751 6.51138 30.4897 4.63658 30.8239C3.98295 30.9371 3.67482 30.7457 3.65556 30.6449C3.63064 30.5067 3.93877 30.1057 4.85521 29.9289C6.57029 29.6004 9.31849 28.6806 11.3281 27.9669C12.3879 27.6051 13.3488 27.0014 14.1346 26.2037C14.9204 25.4059 15.5096 24.436 15.8553 23.3709C16.2011 22.3059 16.2939 21.1749 16.1265 20.0677C15.9591 18.9604 15.536 17.9075 14.8908 16.9922C13.6866 15.2352 12.001 12.8733 10.8127 11.5989C10.176 10.9192 10.1624 10.4106 10.2633 10.3143C10.338 10.2441 10.7017 10.2678 11.1616 10.7459C12.6082 12.2446 14.7866 14.2644 16.3193 15.8435C16.8347 16.3692 17.4034 17.1723 17.963 18.1669C18.0765 18.3577 18.2601 18.4964 18.4746 18.5535C18.6891 18.6106 18.9174 18.5814 19.1106 18.4724C19.3039 18.3633 19.4469 18.1829 19.5089 17.9698C19.5709 17.7567 19.547 17.5278 19.4424 17.3321C18.1352 14.9135 16.6523 13.8203 14.8398 11.9988C13.9109 11.0925 13.0353 10.2452 12.3839 9.56889C11.1944 8.33073 9.82713 8.38284 9.09306 9.08292C8.33748 9.79885 8.16416 11.2545 9.56885 12.7589C10.6869 13.9563 12.3182 16.2446 13.4895 17.954C13.9655 18.6331 14.2855 19.409 14.4269 20.2262C14.5683 21.0433 14.5275 21.8816 14.3074 22.6812C13.8112 24.3906 12.4949 25.7489 10.756 26.3651C8.8042 27.0595 6.13869 27.951 4.53123 28.2637C2.51029 28.6602 1.79549 29.9357 1.9858 30.9587C2.22029 32.2852 3.72014 32.7292 4.93451 32.5004Z"></path>
                                <path d="M6.7255 37.9062C8.59691 36.9943 11.191 35.5511 13.1655 34.5757C14.7764 33.7748 17.3796 33.4894 17.4045 33.4871C18.5181 33.3296 18.3504 31.7188 17.2267 31.7969C17.1134 31.8094 14.2961 32.1153 12.4088 33.0544C10.4366 34.0263 7.84245 35.4707 5.98351 36.378C2.71874 38.0625 4.71589 41.6977 8.14831 40.0416C9.6323 39.3494 12.3125 38.5043 14.2995 37.9187C15.1198 37.6555 15.9906 37.5894 16.8412 37.7257C17.6918 37.8621 18.4983 38.197 19.1953 38.7034C19.8922 39.2098 20.46 39.8733 20.8525 40.6402C21.245 41.4071 21.4512 42.2557 21.4543 43.1171C21.511 45.1891 21.537 47.9996 21.341 49.624C20.8698 53.6308 25.0408 53.9582 25.4951 50.5495C25.7567 48.6623 26.4183 45.2989 26.6721 43.4003C26.9541 41.3058 26.3957 38.9688 26.3719 38.8691C26.3455 38.7606 26.2981 38.6584 26.2323 38.5683C26.1664 38.4782 26.0835 38.4019 25.9882 38.3439C25.8929 38.2858 25.7871 38.2471 25.6768 38.2299C25.5666 38.2127 25.454 38.2174 25.3455 38.2438C25.2371 38.2701 25.1349 38.3175 25.0448 38.3834C24.9547 38.4492 24.8784 38.5321 24.8203 38.6274C24.7623 38.7227 24.7235 38.8285 24.7064 38.9388C24.6892 39.0491 24.6939 39.1617 24.7202 39.2701C24.7202 39.2905 25.2277 41.3896 24.9876 43.1715C24.7338 45.061 24.0734 48.4278 23.8117 50.3139C23.7199 50.9709 23.4367 51.2032 23.3382 51.1918C23.2 51.1737 22.9134 50.7557 23.0278 49.8324C23.2408 48.1026 23.2158 45.2004 23.1581 43.0707C23.1476 41.9487 22.8743 40.8447 22.3602 39.8474C21.846 38.85 21.1053 37.9871 20.1974 37.3277C19.2896 36.6683 18.2398 36.2308 17.1323 36.0503C16.0249 35.8699 14.8905 35.9515 13.8203 36.2885C11.7812 36.8912 9.01038 37.7612 7.43011 38.5021C6.58503 38.8963 6.09905 38.7535 6.03902 38.6278C5.9937 38.5349 6.12964 38.1962 6.7255 37.9062Z"></path>
                                <path d="M50.4883 39.559C51.0626 38.3526 50.1791 37.1461 49.0089 36.5786C48.2159 36.1912 47.1261 35.6157 45.9763 35.0074C44.7597 34.3628 43.5 33.6956 42.5779 33.2492C40.6872 32.343 37.896 32.0122 37.7782 32.0032C37.5564 31.9815 37.335 32.0479 37.1617 32.188C36.9884 32.328 36.8771 32.5305 36.8517 32.7519C36.8263 32.9732 36.8888 33.1957 37.0259 33.3714C37.163 33.5471 37.3636 33.6619 37.5844 33.691C37.6105 33.691 40.2103 34.0014 41.8416 34.7853C43.56 35.61 46.5574 37.2775 48.2714 38.1113C48.8673 38.4013 49.0032 38.74 48.959 38.8329C48.899 38.9586 48.413 39.1025 47.5679 38.7071C45.9888 37.9697 43.2213 37.0963 41.1777 36.4936C40.1077 36.1624 38.9753 36.0851 37.8702 36.2678C36.7651 36.4505 35.7179 36.8883 34.8115 37.5463C33.9051 38.2043 33.1645 39.0645 32.6485 40.0587C32.1325 41.0528 31.8553 42.1535 31.8388 43.2735C31.781 45.4032 31.7561 48.3055 31.9691 50.0353C32.0824 50.9608 31.7969 51.3788 31.6587 51.3946C31.5533 51.4094 31.2758 51.1737 31.1852 50.5167C30.8963 48.455 30.3254 45.5425 30.0082 43.363C29.7465 41.6037 30.2687 39.5012 30.2744 39.4808C30.3298 39.2624 30.2962 39.0309 30.181 38.8373C30.0657 38.6437 29.8783 38.5037 29.6599 38.4483C29.4414 38.3929 29.2099 38.4265 29.0163 38.5417C28.8227 38.657 28.6827 38.8444 28.6273 39.0628C28.6024 39.1614 28.0144 41.5108 28.3271 43.6122C28.642 45.7883 29.2141 48.7019 29.5018 50.7489C29.7567 52.4255 30.7876 53.1901 31.8807 53.078C32.9127 52.9421 33.9085 51.867 33.657 49.8234C33.4565 48.199 33.4814 45.3885 33.5437 43.3166C33.5935 41.478 34.4771 39.8048 35.9498 38.8012C36.6424 38.3451 37.4272 38.0477 38.2482 37.9302C39.0691 37.8127 39.9058 37.878 40.6985 38.1215C42.6866 38.7083 45.3669 39.5522 46.8497 40.2444C48.7109 41.1132 50.0408 40.4981 50.4883 39.559Z"></path>
                                <path d="M50.8417 28.5877C49.2343 28.2762 46.5699 27.3835 44.6169 26.6903C43.8326 26.4203 43.1175 25.9805 42.5228 25.4023C41.9281 24.824 41.4684 24.1215 41.1766 23.3451C40.5728 21.6708 40.8447 19.796 41.8846 18.278C43.0559 16.5697 44.6872 14.2803 45.8041 13.084C47.2088 11.5785 47.0355 10.1229 46.2799 9.40693C45.3102 8.48822 43.8897 8.95381 42.988 9.89291C42.3728 10.5352 41.4904 11.3871 40.5547 12.2922C38.5428 14.2984 37.2956 15.1967 35.9101 17.7161C35.3924 18.7175 36.8039 19.5094 37.3896 18.5499C37.9651 17.5303 38.5439 16.7034 39.0639 16.1585C40.3791 14.7799 42.8939 12.444 44.2137 11.071C44.6736 10.593 45.0383 10.5692 45.112 10.6406C45.2139 10.7369 45.2003 11.2421 44.5637 11.924C43.3742 13.1985 41.6886 15.5604 40.4856 17.3174C39.8346 18.2309 39.4068 19.2843 39.2365 20.3931C39.0661 21.5018 39.1579 22.6351 39.5045 23.7019C39.8511 24.7688 40.4428 25.7396 41.2323 26.5366C42.0217 27.3335 42.987 27.9343 44.0505 28.2909C46.0579 29.0046 48.8083 29.9244 50.5212 30.2563C51.4365 30.4342 51.7457 30.8352 51.7197 30.9723C51.7015 31.0731 51.3923 31.2679 50.7398 31.1513C48.6894 30.7899 45.743 30.4319 43.5713 30.0604C41.7974 29.7624 39.5249 28.4631 39.5023 28.4495C39.4056 28.3938 39.2989 28.3577 39.1882 28.3432C39.0776 28.3287 38.9651 28.3362 38.8574 28.3652C38.7496 28.3942 38.6486 28.4441 38.5601 28.5121C38.4716 28.5801 38.3974 28.6649 38.3417 28.7616C38.286 28.8583 38.2499 28.965 38.2354 29.0757C38.221 29.1863 38.2284 29.2987 38.2574 29.4065C38.2864 29.5143 38.3363 29.6153 38.4043 29.7038C38.4723 29.7922 38.5571 29.8665 38.6538 29.9222C38.7569 29.9822 41.2117 31.3869 43.2893 31.7347C45.4563 32.1062 48.4039 32.4631 50.4407 32.8222C53.8799 33.4452 54.7307 29.3184 50.8417 28.5877Z"></path>
                                <path d="M27.8049 12.6876C30.1566 12.7476 32.1651 10.0606 32.1096 7.78814C32.0201 2.37669 23.5795 2.37783 23.4911 7.78814C23.4492 10.064 25.452 12.7533 27.8049 12.6876ZM27.8049 5.41376C29.3172 5.41376 30.4103 6.41291 30.4103 7.79267C30.4103 9.23361 29.2062 10.9929 27.8049 10.9929C26.4036 10.9929 25.1994 9.23361 25.1994 7.79267C25.1949 6.41744 26.2926 5.4183 27.8049 5.4183V5.41376Z"></path>
                                <path d="M16.3985 47.2088C19.0187 47.2451 20.7372 44.7019 20.5741 42.195C20.3113 37.5913 15.0369 37.316 12.6444 40.4856C10.5442 43.2916 13.0001 47.2043 16.3985 47.2088ZM14.0196 41.4847C14.867 40.3191 16.8755 39.6043 18.0128 40.4301C19.277 41.4202 18.9938 43.5215 18.2394 44.5524C18.0576 44.8139 17.8219 45.0335 17.5481 45.1962C17.2744 45.359 16.9689 45.4612 16.6523 45.496C14.5543 45.7045 12.6795 43.2735 14.023 41.4847H14.0196Z"></path>
                                <path d="M38.5972 47.4128C39.5548 47.4025 40.4843 47.0879 41.2514 46.5145C44.5784 44.0495 43.1386 39.6983 39.4457 38.7434C34.9858 37.5698 33.094 42.5009 35.3675 45.7521C35.7334 46.2674 36.2178 46.6872 36.7799 46.9762C37.3419 47.2652 37.9652 47.415 38.5972 47.4128ZM36.1152 42.4805C36.1866 40.8028 37.3873 39.9306 39.005 40.3803C39.7863 40.5869 40.4771 41.0466 40.9693 41.6876C42.8158 44.2466 38.6085 47.3029 36.745 44.7552C36.2885 44.0879 36.0669 43.2876 36.1152 42.4805Z"></path>
                                <path d="M44.9489 17.5043C42.7727 18.1579 40.8356 20.9027 41.6207 23.1162C42.1248 24.8483 44.2522 25.9732 46.0907 25.9347C49.138 25.9789 51.1068 23.2431 50.1541 20.3442C49.479 18.133 47.1624 16.7453 44.9489 17.5043ZM47.3164 19.293C49.0927 20.3205 49.2694 23.4051 47.0899 24.0848C45.8766 24.4801 43.7923 24.0995 43.2383 22.5917C42.6538 20.6671 45.3861 18.1251 47.3164 19.293Z"></path>
                                <path d="M7.76201 25.375C9.9438 26.1272 13.0749 25.0352 13.7523 22.7899C14.5374 20.5719 12.6014 17.8305 10.4252 17.178C5.25056 15.5932 2.64283 23.6203 7.76201 25.375ZM6.83537 20.5424C7.73142 17.9653 10.4445 18.2542 11.7438 20.2592C12.6716 21.6571 12.214 23.0709 10.6405 23.6577C8.42017 24.522 6.03787 23.1445 6.83537 20.5447V20.5424Z"></path>
                            </svg>';
						echo '<h2 class="elementor-gt-header__title">' . $this->parent->get_instance_value_skin('header_title') . '</h2>';
					}

				?>
			</div>

			<div class="elementor-gt-form">

				<?php
                    echo alone_addons_give_totals ( $args, $bar_opts );
                    
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
								$form_html_tags['data-style'] = 'elementor-give-totals--toluca';
			
								return $form_html_tags;
							}, 10, 2);
			
							echo give_get_donation_form( $atts );
						}
					}
				?>

			</div>

		<?php

		$this->parent->render_loop_footer();

	}

	protected function content_template() {

	}

}
