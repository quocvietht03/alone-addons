<?php
namespace AloneAddons\Widgets\CountDown;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Be_CountDown extends Widget_Base {

	public function get_name() {
		return 'be-countdown';
	}

	public function get_title() {
		return __( 'Be Count Down', 'alone-addons' );
	}

	public function get_icon() {
		return 'eicon-countdown';
	}

	public function get_categories() {
		return [ 'alone-addons' ];
	}

	public function get_script_depends() {
		return [ 'jquery-countdown-plugin', 'jquery-countdown', 'alone-addons' ];
	}

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'alone-addons' ),
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'alone-addons' ),
					'stacked' => __( 'Stacked', 'alone-addons' ),
					'framed' => __( 'Framed', 'alone-addons' ),
				],
				'prefix_class' => 'elementor-countdown--view-',
			]
		);

		$this->add_control(
			'shape',
			[
				'label' => __( 'Shape', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'circle',
				'options' => [
					'circle' => __( 'Circle', 'alone-addons' ),
					'rounded' => __( 'Rounded', 'alone-addons' ),
					'square' => __( 'Square', 'alone-addons' ),
				],
				'condition' => [
					'view!' => '',
				],
				'prefix_class' => 'elementor-countdown--shape-',
			]
		);

		$this->add_control(
			'date_end',
			[
				'label' => __( 'Date End', 'alone-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '2021/12/1 0:0:0',
				'placeholder' => '2021/12/1 0:0:0',
			]
		);

		$this->add_control(
			'format',
			[
				'label' => __( 'Format', 'alone-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'ODHMS',
				'placeholder' => 'ODHMS',
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
					'{{WRAPPER}} .elementor-countdown' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'section_size',
			[
				'label' => __( 'Section Size', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 200,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .countdown-row .countdown-section' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'view!' => '',
				],
			]
		);

		$this->add_control(
			'section_bg_color',
			[
				'label' => __( 'Section Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .countdown-row .countdown-section' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'view!' => '',
				],
			]
		);

		$this->add_control(
			'section_border_color',
			[
				'label' => __( 'Section Border Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .countdown-row .countdown-section' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'view' => 'framed',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_design_content_section_controls() {
		$this->start_controls_section(
			'section_design_content',
			[
				'label' => __( 'Content', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_amount_style',
			[
				'label' => __( 'Amount', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'amount_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .countdown-row .countdown-section > span.countdown-amount' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'amount_typography',
				'default' => '',
				'selector' => '{{WRAPPER}} .countdown-section > span.countdown-amount,
											 {{WRAPPER}} .countdown-section:not(:last-child):after',
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label' => __( 'Separator Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .countdown-row .countdown-section:not(:last-child):after' => 'color: {{VALUE}};',
				],
				'condition' => [
					'view' => '',
				],
			]
		);

		$this->add_control(
			'heading_period_style',
			[
				'label' => __( 'Amount', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'period_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .countdown-row .countdown-section > span.countdown-period' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'period_typography',
				'default' => '',
				'selector' => '{{WRAPPER}} .countdown-row .countdown-section > span.countdown-period',
			]
		);

		$this->end_controls_section();
	}

  protected function register_controls() {
		$this->register_layout_section_controls();

		$this->register_design_layout_section_controls();
		$this->register_design_content_section_controls();
	}

  protected function render() {
		$settings = $this->get_settings_for_display();

		$current_date = current_time('Y/m/d H:i:s');
		$count_date = strtotime($settings['date_end']) - strtotime($current_date);

		$months = 0;
		if($settings['format'] == 'ODHMS') {
			$months = floor($count_date/(30*24*3600));
			$count_date = $count_date%(30*24*3600);
		}

		$days = floor($count_date/(24*3600));
		$count_date = $count_date%(24*3600);

		$hours = floor($count_date/(3600));
		$count_date = $count_date%(3600);

		$minutes = floor($count_date/(60));
		$seconds = $count_date%(60);

		$until = '+'.$months.'o +'.$days.'d +'.$hours.'h +'.$minutes.'m +'.$seconds.'s';

		?>

		<div class="elementor-countdown">
			<div class="countdown" data-countdown="<?php echo esc_attr($until); ?>" data-format="<?php echo esc_attr($settings['format']); ?>"></div>
		</div>

		<?php
	}

	protected function content_template() {

	}
}
