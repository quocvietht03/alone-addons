<?php
namespace AloneAddons\Widgets\Give_Totals;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

use Elementor\Plugin;
use Give\Helpers\Form\Template;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Be_Give_Totals extends Widget_Base {

	public function get_name() {
		return 'be-give-totals';
	}

	public function get_title() {
		return __( 'Be Give Totals', 'alone-addons' );
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'alone-addons' ];
	}

	public function get_script_depends() {
		return [ 'elementor-waypoints', 'jquery-progressbar', 'alone-addons' ];
	}

	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Pumori( $this ) );
		$this->add_skin( new Skins\Skin_Baruntse( $this ) );
		$this->add_skin( new Skins\Skin_Coropuna( $this ) );
		$this->add_skin( new Skins\Skin_Saltoro( $this ) );
		$this->add_skin( new Skins\Skin_Changla( $this ) );
		$this->add_skin( new Skins\Skin_Taboche( $this ) );
		$this->add_skin( new Skins\Skin_Galloway( $this ) );
		$this->add_skin( new Skins\Skin_Wilson( $this ) );
		$this->add_skin( new Skins\Skin_Jorasses( $this ) );
		$this->add_skin( new Skins\Skin_Swiss( $this ) );
		$this->add_skin( new Skins\Skin_Toluca( $this ) );

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

	protected function get_supported_taxonomies() {
		$supported_taxonomies = [];

		$categories = get_terms( array(
			'taxonomy' => 'give_forms_category',
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

		$this->add_control(
			'heading_give_total',
			[
				'label' => __( 'Give Total', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'total_goal',
			[
				'label' => __( 'Total Goal', 'alone-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
			]
		);

		$this->add_control(
			'custom_total_earnings',
			[
				'label' => __( 'Custom Total Earnings', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'total_earnings',
			[
				'label' => __( 'Total Earnings', 'alone-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1200,
				'condition' => [
					'custom_total_earnings!' => '',
				],
			]
		);

		$this->add_control(
			'ids',
			[
				'label' => __( 'Ids', 'alone-addons' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_supported_post_ids(),
				'label_block' => true,
				'multiple' => true,
				'condition' => [
					'custom_total_earnings' => '',
				],
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
				'condition' => [
					'custom_total_earnings' => '',
				],
			]
		);

		$this->add_control(
			'heading_give_form',
			[
				'label' => __( 'Give Form', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
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
					'{{WRAPPER}} .elementor-give-totals' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_design_give_total_section_controls() {
		$this->start_controls_section(
			'section_design_content',
			[
				'label' => __( 'Give Total', 'alone-addons' ),
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
			]
		);

		$this->add_control(
			'goal_progress_main_color',
			[
				'label' => __( 'Main Color', 'alone-addons' ),
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
				'name' => 'goal_progress_main_typography',
				'label' => __( 'Main Typography', 'alone-addons' ),
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

		$this->add_control(
			'heading_message',
			[
				'label' => __( 'Message', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'mesage_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .give-totals-message' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'message_typography',
				'default' => '',
				'selector' => '{{WRAPPER}} .give-totals-message',
			]
		);

		$this->end_controls_section();
	}

	protected function register_design_give_form_section_controls() {
		$this->start_controls_section(
			'section_give_form',
			[
				'label' => __( 'Give Form (Apply On Legacy)', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
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
					'{{WRAPPER}} .elementor-gt-form form[id*=give-form] .give-total-wrap #give-amount,
					 {{WRAPPER}} .elementor-gt-form form[id*=give-form] #give-donation-level-button-wrap .give-btn:not(.give-default-level)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-gt-form form[id*=give-form] .give-total-wrap .give-currency-symbol,
					 {{WRAPPER}} .elementor-gt-form form[id*=give-form] #give-donation-level-button-wrap .give-btn.give-default-level' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .elementor-gt-form form[id*=give-form] #give-donation-level-button-wrap .give-btn:hover,
					 {{WRAPPER}} .elementor-gt-form form[id*=give-form] #give-donation-level-button-wrap .give-btn.give-default-level' => 'border-color: {{VALUE}};',
					'.give-form[data-style="elementor-give-totals--default"] .give-total-wrap #give-amount,
					 .give-form[data-style="elementor-give-totals--default"] #give-donation-level-button-wrap .give-btn:not(.give-default-level),
					 .give-form[data-style="elementor-give-totals--default"] #give-donation-level-button-wrap .give-btn:not(.give-default-level):hover,
					 .give-form[data-style="elementor-give-totals--default"] #give-gateway-radio-list > li label:hover,
					 .give-form[data-style="elementor-give-totals--default"] #give-gateway-radio-list > li.give-gateway-option-selected label,
					 .give-form[data-style="elementor-give-totals--default"] #give_terms_agreement label:hover,
					 .give-form[data-style="elementor-give-totals--default"] #give_terms_agreement input[type=checkbox]:checked + label,
					 .give-form[data-style="elementor-give-totals--default"] .give_terms_links:hover,
					 .give-form[data-style="elementor-give-totals--default"] #give-final-total-wrap .give-final-total-amount' => 'color: {{VALUE}};',
					'.give-form[data-style="elementor-give-totals--default"] .give-total-wrap .give-currency-symbol,
					 .give-form[data-style="elementor-give-totals--default"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-totals--default"] #give-gateway-radio-list > li.give-gateway-option-selected label:after,
					 .give-form[data-style="elementor-give-totals--default"] #give_terms_agreement input[type=checkbox]:checked + label:before,
					 .give-form[data-style="elementor-give-totals--default"] #give-final-total-wrap .give-donation-total-label' => 'background-color: {{VALUE}};',
					'.give-form[data-style="elementor-give-totals--default"] #give-donation-level-button-wrap .give-btn:hover,
					 .give-form[data-style="elementor-give-totals--default"] #give-donation-level-button-wrap .give-btn.give-default-level,
					 .give-form[data-style="elementor-give-totals--default"] #give_terms_agreement input[type=checkbox]:checked + label:before' => 'border-color: {{VALUE}};',
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
					.give-form[data-style="elementor-give-totals--default"]' => 'color: {{VALUE}};',
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
					.give-form[data-style="elementor-give-totals--default"]' => 'font-family: "{{VALUE}}", sans-serif',
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
					 .give-form[data-style="elementor-give-totals--default"] legend,
					 .give-form[data-style="elementor-give-totals--default"] .give-submit' => 'font-family: "{{VALUE}}", sans-serif',
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
					 .give-form[data-style="elementor-give-totals--default"] .give-submit' => 'color: {{VALUE}};',
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
					 .give-form[data-style="elementor-give-totals--default"] .give-submit' => 'background-color: {{VALUE}};',
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
					 .give-form[data-style="elementor-give-totals--default"] .give-submit:hover' => 'color: {{VALUE}};',
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
					 .give-form[data-style="elementor-give-totals--default"] .give-submit:hover' => 'background-color: {{VALUE}};',
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

	protected function register_controls() {
		$this->register_layout_section_controls();

		$this->register_design_latyout_section_controls();
		$this->register_design_give_total_section_controls();
		$this->register_design_give_form_section_controls();
		$this->register_design_goal_progress_section_controls();
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

		$classes = 'elementor-give-totals';

		if( $settings['_skin'] ) {
			$classes .= ' elementor-give-totals--' . $settings['_skin'];
		} else {
			$classes .= ' elementor-give-totals--default';
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

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->render_loop_header();

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
					$form_html_tags['data-style'] = 'elementor-give-totals--default';

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
