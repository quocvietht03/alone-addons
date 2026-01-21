<?php

namespace AloneAddons\Widgets\List_Image_Marquee;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class Be_List_Image_Marquee extends Widget_Base
{

	public function get_name()
	{
		return 'be-list-image-marquee';
	}

	public function get_title()
	{
		return __('List Image Marquee', 'alone-addons');
	}

	public function get_icon()
	{
		return 'eicon-carousel';
	}

	public function get_categories()
	{
		return ['alone-addons'];
	}

	public function get_script_depends()
	{
		return ['alone-addons'];
	}

	protected function register_layout_section_controls()
	{
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __('Layout', 'alone-addons'),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'list_image',
			[
				'label' => __('Image', 'alone-addons'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'list_url',
			[
				'label' => __('Link', 'alone-addons'),
				'type' => Controls_Manager::URL,
				'placeholder' => __('https://your-link.com', 'alone-addons'),
				'default' => [
					'url' => '',
				],
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __('Images', 'alone-addons'),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_image' => Utils::get_placeholder_image_src(),
						'list_url' => '',
					],
					[
						'list_image' => Utils::get_placeholder_image_src(),
						'list_url' => '',
					],
					[
						'list_image' => Utils::get_placeholder_image_src(),
						'list_url' => '',
					],
					[
						'list_image' => Utils::get_placeholder_image_src(),
						'list_url' => '',
					],
					[
						'list_image' => Utils::get_placeholder_image_src(),
						'list_url' => '',
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_size',
				'default' => 'medium',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'marquee_direction',
			[
				'label' => __('Direction', 'alone-addons'),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => __('Left', 'alone-addons'),
					'right' => __('Right', 'alone-addons'),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'marquee_speed',
			[
				'label' => __('Speed (seconds)', 'alone-addons'),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
						'step' => 1,
					],
				],
				'description' => __('Time for one complete scroll (higher = slower)', 'alone-addons'),
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => __('Pause on Hover', 'alone-addons'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __('Yes', 'alone-addons'),
				'label_off' => __('No', 'alone-addons'),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_responsive_control(
			'space_between',
			[
				'label' => __('Space Between', 'alone-addons'),
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
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function register_design_image_section_controls()
	{
		$this->start_controls_section(
			'section_design_image',
			[
				'label' => __('Image', 'alone-addons'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => __('Width', 'alone-addons'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default' => [
					'size' => 200,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .be-list-image-marquee__item img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);

		$this->start_controls_tabs('image_effects_tabs');

		$this->start_controls_tab(
			'image_normal',
			[
				'label' => __('Normal', 'alone-addons'),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_filters',
				'selector' => '{{WRAPPER}} .be-list-image-marquee__item img',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_shadow',
				'selector' => '{{WRAPPER}} .be-list-image-marquee__item img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'image_hover',
			[
				'label' => __('Hover', 'alone-addons'),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_hover_filters',
				'selector' => '{{WRAPPER}} .be-list-image-marquee__item:hover img',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_hover_shadow',
				'selector' => '{{WRAPPER}} .be-list-image-marquee__item:hover img',
			]
		);

		$this->add_control(
			'image_hover_transition',
			[
				'label' => __('Transition Duration', 'alone-addons'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0.3,
				],
				'selectors' => [
					'{{WRAPPER}} .be-list-image-marquee__item img' => 'transition-duration: {{SIZE}}s;',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}


	protected function register_controls()
	{
		$this->register_layout_section_controls();
		$this->register_design_image_section_controls();

	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		if (empty($settings['list'])) {
			return;
		}

		$marquee_direction = !empty($settings['marquee_direction']) ? $settings['marquee_direction'] : 'left';
		$marquee_speed = !empty($settings['marquee_speed']['size']) ? $settings['marquee_speed']['size'] : 20;
		$pause_on_hover = !empty($settings['pause_on_hover']) && $settings['pause_on_hover'] === 'yes' ? 'yes' : 'no';
		$space_between = !empty($settings['space_between']['size']) ? $settings['space_between']['size'] : 30;
		$space_between_tablet = !empty($settings['space_between_tablet']['size']) ? $settings['space_between_tablet']['size'] : $space_between;
		$space_between_mobile = !empty($settings['space_between_mobile']['size']) ? $settings['space_between_mobile']['size'] : $space_between_tablet;

		$image_size = !empty($settings['image_size_size']) ? $settings['image_size_size'] : 'medium';

		$this->add_render_attribute('wrapper', 'class', 'be-list-image-marquee__wrapper');
		$this->add_render_attribute('wrapper', 'data-direction', esc_attr($marquee_direction));
		$this->add_render_attribute('wrapper', 'data-speed', esc_attr($marquee_speed));
		$this->add_render_attribute('wrapper', 'data-pause-on-hover', esc_attr($pause_on_hover));
		$this->add_render_attribute('wrapper', 'style', '--marquee-speed: ' . esc_attr($marquee_speed) . 's; --space-between: ' . esc_attr($space_between) . 'px; --space-between-tablet: ' . esc_attr($space_between_tablet) . 'px; --space-between-mobile: ' . esc_attr($space_between_mobile) . 'px;');

		$this->add_render_attribute('track', 'class', 'be-list-image-marquee__track');
		if ($marquee_direction === 'right') {
			$this->add_render_attribute('track', 'class', 'be-list-image-marquee__track--reverse');
		}

?>
		<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
			<div <?php echo $this->get_render_attribute_string('track'); ?>>
				<?php
				// Render images three times for seamless loop
				foreach ([1, 2, 3] as $loop) :
					foreach ($settings['list'] as $index => $item) :
						$item_link = !empty($item['list_url']['url']) ? $item['list_url']['url'] : '';
						$item_target = !empty($item['list_url']['is_external']) ? ' target="_blank"' : '';
						$item_nofollow = !empty($item['list_url']['nofollow']) ? ' rel="nofollow"' : '';
				?>
					<div class="be-list-image-marquee__item">
						<?php
						if (!empty($item['list_image']['id'])) {
							$image_html = wp_get_attachment_image($item['list_image']['id'], $image_size);
						} else {
							$image_url = !empty($item['list_image']['url']) ? $item['list_image']['url'] : Utils::get_placeholder_image_src();
							$image_html = '<img src="' . esc_url($image_url) . '" alt="' . esc_attr__('Image', 'alone-addons') . '">';
						}

						if (!empty($item_link)) {
							echo '<a href="' . esc_url($item_link) . '"' . $item_target . $item_nofollow . '>' . $image_html . '</a>';
						} else {
							echo $image_html;
						}
						?>
					</div>
				<?php
					endforeach;
				endforeach;
				?>
			</div>
		</div>
<?php
	}

	protected function content_template() {}
}
