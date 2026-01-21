<?php

namespace AloneAddons\Widgets\Featured_Box;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class Be_Featured_Box extends Widget_Base
{

	public function get_name()
	{
		return 'be-featured-box';
	}

	public function get_title()
	{
		return __('Be Featured Box', 'alone-addons');
	}

	public function get_icon()
	{
		return 'eicon-image';
	}

	public function get_categories()
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

		$this->add_control(
			'image_main',
			[
				'label' => __('Image', 'alone-addons'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_responsive_control(
			'image_ratio',
			[
				'label' => __('Image Ratio', 'alone-addons'),
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
					'{{WRAPPER}} .elementor-featured-box__wrapper' => 'padding-bottom: calc( {{SIZE}} * 100% );',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image_main_size',
				'default' => 'large',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __('Icon', 'alone-addons'),
				'type' => Controls_Manager::MEDIA,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __('Title', 'alone-addons'),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __('Collective Strength', 'alone-addons'),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => __('Button Text', 'alone-addons'),
				'type' => Controls_Manager::TEXT,
				'default' => __('Learn More', 'alone-addons'),
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => __('Button Link', 'alone-addons'),
				'type' => Controls_Manager::URL,
				'placeholder' => __('https://your-link.com', 'alone-addons'),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_design_layout_section_controls()
	{
		$this->start_controls_section(
			'section_design_layout',
			[
				'label' => __('Layout', 'alone-addons'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __('Content Alignment', 'alone-addons'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'alone-addons'),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __('Center', 'alone-addons'),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __('Right', 'alone-addons'),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-featured-box__content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_position',
			[
				'label' => __('Content Position', 'alone-addons'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'top-left' => __('Top Left', 'alone-addons'),
					'top-center' => __('Top Center', 'alone-addons'),
					'top-right' => __('Top Right', 'alone-addons'),
					'middle-left' => __('Middle Left', 'alone-addons'),
					'middle-center' => __('Middle Center', 'alone-addons'),
					'middle-right' => __('Middle Right', 'alone-addons'),
					'bottom-left' => __('Bottom Left', 'alone-addons'),
					'bottom-center' => __('Bottom Center', 'alone-addons'),
					'bottom-right' => __('Bottom Right', 'alone-addons'),
				],
				'default' => 'bottom-left',
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

		$this->add_control(
			'image_border_radius',
			[
				'label' => __('Border Radius', 'alone-addons'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .elementor-featured-box__wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'overlay_heading',
			[
				'label' => __('Overlay', 'alone-addons'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs('overlay_tabs');

		$this->start_controls_tab(
			'overlay_normal',
			[
				'label' => __('Normal', 'alone-addons'),
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label' => __('Overlay Color', 'alone-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-featured-box__image:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_opacity',
			[
				'label' => __('Opacity', 'alone-addons'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
				],

				'selectors' => [
					'{{WRAPPER}} .elementor-featured-box__image:before' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'overlay_hover',
			[
				'label' => __('Hover', 'alone-addons'),
			]
		);

		$this->add_control(
			'overlay_color_hover',
			[
				'label' => __('Overlay Color', 'alone-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .elementor-featured-box__image:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_opacity_hover',
			[
				'label' => __('Opacity', 'alone-addons'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}}:hover .elementor-featured-box__image:before' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'overlay_transition',
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
					'{{WRAPPER}} .elementor-featured-box__overlay' => 'transition-duration: {{SIZE}}s;',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function register_design_icon_section_controls()
	{
		$this->start_controls_section(
			'section_design_icon',
			[
				'label' => __('Icon', 'alone-addons'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __('Size', 'alone-addons'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', 'em'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-featured-box__icon img' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
				],
			]
		);



		$this->end_controls_section();
	}

	protected function register_design_content_section_controls()
	{
		$this->start_controls_section(
			'section_design_content',
			[
				'label' => __('Content', 'alone-addons'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);



		$this->add_control(
			'heading_title_style',
			[
				'label' => __('Title', 'alone-addons'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __('Color', 'alone-addons'),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .elementor-featured-box__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_title',
				'selector' => '{{WRAPPER}} .elementor-featured-box__title',
			]
		);



		$this->add_control(
			'heading_button_style',
			[
				'label' => __('Button', 'alone-addons'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs('tabs_button_style');

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __('Normal', 'alone-addons'),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __('Text Color', 'alone-addons'),
				'type' => Controls_Manager::COLOR,
			
				'selectors' => [
					'{{WRAPPER}} .elementor-featured-box__button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => __('Background Color', 'alone-addons'),
				'type' => Controls_Manager::COLOR,
			
				'selectors' => [
					'{{WRAPPER}} .elementor-featured-box__button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __('Hover', 'alone-addons'),
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label' => __('Text Color', 'alone-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-featured-box__button' => '--color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_bg_color',
			[
				'label' => __('Background Color', 'alone-addons'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-featured-box__button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_button',
				'selector' => '{{WRAPPER}} .elementor-featured-box__button',
			]
		);

	

		$this->end_controls_section();
	}

	protected function register_controls()
	{
		$this->register_layout_section_controls();
		$this->register_design_layout_section_controls();
		$this->register_design_image_section_controls();
		$this->register_design_icon_section_controls();
		$this->register_design_content_section_controls();
	}

	protected function render()
	{
		$settings = $this->get_settings_for_display();

		$button_link = '#';
		if (! empty($settings['button_link']['url'])) {
			$button_link = $settings['button_link']['url'];
		}

		$content_position = ! empty($settings['content_position']) ? $settings['content_position'] : 'bottom-left';

		$this->add_render_attribute('wrapper', 'class', 'elementor-featured-box__wrapper');
		$this->add_render_attribute('content', 'class', 'elementor-featured-box__content');
		$this->add_render_attribute('content', 'class', 'elementor-featured-box__content--' . $content_position);

?>
		<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
			<div class="elementor-featured-box__image">
				<?php
				if (! empty($settings['image_main']['id'])) {
					$image_size = ! empty($settings['image_main_size_size']) ? $settings['image_main_size_size'] : 'large';
					echo wp_get_attachment_image($settings['image_main']['id'], $image_size);
				} else {
					echo '<img src="' . esc_url(Utils::get_placeholder_image_src()) . '" alt="' . esc_attr__('Awaiting image', 'alone-addons') . '">';
				}
				?>
				<div class="elementor-featured-box__overlay"></div>
			</div>

			<?php if (! empty($settings['title']) || ! empty($settings['button_text']) || ! empty($settings['icon']['id']) || ! empty($settings['icon']['url'])) : ?>
				<div <?php echo $this->get_render_attribute_string('content'); ?>>
					<?php if (! empty($settings['icon']['id']) || ! empty($settings['icon']['url'])) : ?>
						<div class="elementor-featured-box__icon">
							<?php
							if (! empty($settings['icon']['id'])) {
								echo wp_get_attachment_image($settings['icon']['id'], 'thumbnail');
							} elseif (! empty($settings['icon']['url'])) {
								echo '<img src="' . esc_url($settings['icon']['url']) . '" alt="' . esc_attr__('Icon', 'alone-addons') . '">';
							} else {
								echo '<img src="' . esc_url(Utils::get_placeholder_image_src()) . '" alt="' . esc_attr__('Awaiting image', 'alone-addons') . '">';
							}
							?>
						</div>
					<?php endif; ?>

					<?php if (! empty($settings['title'])) : ?>
						<h3 class="elementor-featured-box__title"><?php echo esc_html($settings['title']); ?></h3>
					<?php endif; ?>

					<?php if (! empty($settings['button_text'])) : ?>
						<a href="<?php echo esc_url($button_link); ?>" class="elementor-featured-box__button">
							<?php echo esc_html($settings['button_text']); ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<path d="M20.7806 12.531L14.0306 19.281C13.8899 19.4218 13.699 19.5008 13.5 19.5008C13.301 19.5008 13.1101 19.4218 12.9694 19.281C12.8286 19.1403 12.7496 18.9494 12.7496 18.7504C12.7496 18.5514 12.8286 18.3605 12.9694 18.2198L18.4397 12.7504H3.75C3.55109 12.7504 3.36032 12.6714 3.21967 12.5307C3.07902 12.3901 3 12.1993 3 12.0004C3 11.8015 3.07902 11.6107 3.21967 11.4701C3.36032 11.3294 3.55109 11.2504 3.75 11.2504H18.4397L12.9694 5.78104C12.8286 5.64031 12.7496 5.44944 12.7496 5.25042C12.7496 5.05139 12.8286 4.86052 12.9694 4.71979C13.1101 4.57906 13.301 4.5 13.5 4.5C13.699 4.5 13.8899 4.57906 14.0306 4.71979L20.7806 11.4698C20.8504 11.5394 20.9057 11.6222 20.9434 11.7132C20.9812 11.8043 21.0006 11.9019 21.0006 12.0004C21.0006 12.099 20.9812 12.1966 20.9434 12.2876C20.9057 12.3787 20.8504 12.4614 20.7806 12.531Z" fill="white" />
							</svg>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
<?php
	}

	protected function content_template() {}
}
