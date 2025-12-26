<?php

namespace AloneAddons\Widgets\Be_Together;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class Be_Together extends Widget_Base
{

    public function get_name()
    {
        return 'be-together';
    }

    public function get_title()
    {
        return __('Be Together', 'alone-addons');
    }

    public function get_icon()
    {
        return 'eicon-text';
    }

    public function get_categories()
    {
        return ['alone-addons'];
    }

    public function get_script_depends()
    {
        return ['gsap', 'alone-addons'];
    }

    protected function register_controls()
    {
        $this->register_layout_section_controls();
        $this->register_design_section_controls();
    }

    protected function register_layout_section_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'alone-addons'),
            ]
        );

        $this->add_control(
            'heading_text',
            [
                'label' => __('Heading Text', 'alone-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Together, We Can', 'alone-addons'),
                'label_block' => true,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'heading_highlight',
            [
                'label' => __('Heading Highlight', 'alone-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Change Lives.', 'alone-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => __('Description', 'alone-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Empowering children, supporting vulnerable families, protecting animals, and delivering hope across Africa and beyond.', 'alone-addons'),
                'rows' => 3,
            ]
        );

        $this->add_control(
            'heading_list',
            [
                'label' => __('Heading Variations', 'alone-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'heading_highlight' => __('Change Lives.', 'alone-addons'),
                        'description' => __('Empowering children, supporting vulnerable families, protecting animals, and delivering hope across Africa and beyond.', 'alone-addons'),
                    ],
                ],
                'title_field' => '{{{ heading_highlight }}}',
                'max_items' => 3,
            ]
        );

        $this->add_control(
            'animation_interval',
            [
                'label' => __('Animation Interval (ms)', 'alone-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3000,
                'min' => 500,
                'max' => 10000,
                'step' => 100,
                'description' => __('Time in milliseconds between text changes', 'alone-addons'),
            ]
        );

        $this->add_control(
            'image_left',
            [
                'label' => __('Image Left', 'alone-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_left_size',
                'default' => 'large',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_right',
            [
                'label' => __('Image Right', 'alone-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_right_size',
                'default' => 'large',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_1_text',
            [
                'label' => __('Button 1 Text', 'alone-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('DONATE NOW', 'alone-addons'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_1_link',
            [
                'label' => __('Button 1 Link', 'alone-addons'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $this->add_control(
            'button_2_text',
            [
                'label' => __('Button 2 Text', 'alone-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('JOIN OUR MISSION', 'alone-addons'),
            ]
        );

        $this->add_control(
            'button_2_link',
            [
                'label' => __('Button 2 Link', 'alone-addons'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function register_design_section_controls()
    {
        $this->start_controls_section(
            'section_design_top',
            [
                'label' => __('Top Section', 'alone-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'top_background',
                'label' => __('Background', 'alone-addons'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .be-together-top',
                'default' => '#ffffff',
            ]
        );

        $this->add_responsive_control(
            'top_padding',
            [
                'label' => __('Padding', 'alone-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .be-together-top' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_bottom',
            [
                'label' => __('Bottom Section', 'alone-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'bottom_background',
                'label' => __('Background', 'alone-addons'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .be-together-bottom',
                'default' => '#0066cc',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_heading',
            [
                'label' => __('Heading', 'alone-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_text_color',
            [
                'label' => __('Text Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#252525',
                'selectors' => [
                    '{{WRAPPER}} .be-together-heading-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_text_typography',
                'selector' => '{{WRAPPER}} .be-together-heading-text',
            ]
        );

        $this->add_control(
            'heading_highlight_color',
            [
                'label' => __('Highlight Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#5C88C6',
                'selectors' => [
                    '{{WRAPPER}} .be-together-heading-highlight' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_highlight_typography',
                'selector' => '{{WRAPPER}} .be-together-heading-highlight',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_description',
            [
                'label' => __('Description', 'alone-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .be-together-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .be-together-description',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_design_buttons',
            [
                'label' => __('Buttons', 'alone-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_1_heading',
            [
                'label' => __('Button 1', 'alone-addons'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'button_1_bg_color',
            [
                'label' => __('Background Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#FFD700',
                'selectors' => [
                    '{{WRAPPER}} .be-together-button-1' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_1_text_color',
            [
                'label' => __('Text Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .be-together-button-1' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_1_typography',
                'selector' => '{{WRAPPER}} .be-together-button-1',
            ]
        );

        $this->add_responsive_control(
            'button_1_padding',
            [
                'label' => __('Padding', 'alone-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .be-together-button-1' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_1_border',
                'selector' => '{{WRAPPER}} .be-together-button-1',
            ]
        );

        $this->add_control(
            'button_1_border_radius',
            [
                'label' => __('Border Radius', 'alone-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .be-together-button-1' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_1_min_width',
            [
                'label' => __('Min Width', 'alone-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .be-together-button-1' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_2_heading',
            [
                'label' => __('Button 2', 'alone-addons'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_2_bg_color',
            [
                'label' => __('Background Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => 'transparent',
                'selectors' => [
                    '{{WRAPPER}} .be-together-button-2' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_2_text_color',
            [
                'label' => __('Text Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .be-together-button-2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_2_typography',
                'selector' => '{{WRAPPER}} .be-together-button-2',
            ]
        );

        $this->add_responsive_control(
            'button_2_padding',
            [
                'label' => __('Padding', 'alone-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .be-together-button-2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_2_border',
                'selector' => '{{WRAPPER}} .be-together-button-2',
            ]
        );

        $this->add_control(
            'button_2_border_radius',
            [
                'label' => __('Border Radius', 'alone-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .be-together-button-2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_2_min_width',
            [
                'label' => __('Min Width', 'alone-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .be-together-button-2' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'buttons_gap',
            [
                'label' => __('Gap Between Buttons', 'alone-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .be-together-buttons' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['heading_list'])) {
            return;
        }

        $first_item = $settings['heading_list'][0];
        $heading_list_json = wp_json_encode($settings['heading_list']);
        $animation_interval = ! empty($settings['animation_interval']) ? $settings['animation_interval'] : 3000;

        $this->add_render_attribute('wrapper', 'class', 'be-together-wrapper');
        $this->add_render_attribute('wrapper', 'data-heading-list', esc_attr($heading_list_json));
        $this->add_render_attribute('wrapper', 'data-animation-interval', esc_attr($animation_interval));

        $button_1_target = $settings['button_1_link']['is_external'] ? ' target="_blank"' : '';
        $button_1_nofollow = $settings['button_1_link']['nofollow'] ? ' rel="nofollow"' : '';
        $button_1_url = ! empty($settings['button_1_link']['url']) ? $settings['button_1_link']['url'] : '#';

        $button_2_target = $settings['button_2_link']['is_external'] ? ' target="_blank"' : '';
        $button_2_nofollow = $settings['button_2_link']['nofollow'] ? ' rel="nofollow"' : '';
        $button_2_url = ! empty($settings['button_2_link']['url']) ? $settings['button_2_link']['url'] : '#';

?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <div class="be-together-top">
                <h2 class="be-together-heading">
                    <span class="be-together-heading-text"><?php echo esc_html($settings['heading_text']); ?></span>
                    <span class="be-together-heading-highlight"><?php echo esc_html($first_item['heading_highlight']); ?></span>
                    <svg class="be-together-arrow" xmlns="http://www.w3.org/2000/svg" width="315" height="309" viewBox="0 0 315 309" fill="none">
                        <g clip-path="url(#clip0_38_795)">
                            <path class="be-together-arrow-path" d="M201.77 44.8891C198.645 38.6871 195.51 32.4731 192.407 26.2531C189.963 21.3467 187.669 12.9112 183.594 9.42846C181.658 7.76058 181.709 5.13696 183.58 3.51251C183.82 3.31171 184.04 3.1079 184.28 2.9071C185.804 1.56438 188.131 1.89808 189.689 2.94514C194.456 6.13131 195.905 14.3386 197.847 19.3228C200.905 27.1619 203.92 34.995 206.945 42.8401C208.263 46.2589 203.376 48.0711 201.77 44.8891Z" fill="#252525" />
                            <path class="be-together-arrow-path" d="M210.668 106.172C209.306 100.918 209.099 95.4129 208.472 90.0185C207.987 85.8744 208.305 77.311 204.886 74.5961C203.147 73.2131 203.11 70.5235 204.871 69.1719C205.084 69.01 205.31 68.8392 205.524 68.6774C207.044 67.5266 208.882 67.7581 210.41 68.7152C215.12 71.6795 214.36 79.2383 214.563 83.9729C214.889 91.0674 215.492 98.8966 213.739 105.81C213.401 107.142 211.106 107.935 210.647 106.169L210.668 106.172Z" fill="#252525" />
                            <path class="be-together-arrow-path" d="M192.707 175.485C200.543 160.664 205.412 145.503 208.586 129.039C209.416 124.731 216.089 125.624 215.377 130.014C212.608 146.963 205.594 163.314 196.026 177.427C194.817 179.21 191.679 177.434 192.707 175.485Z" fill="#252525" />
                            <path class="be-together-arrow-path" d="M160.474 227.306C165.085 221.23 169.352 214.923 173.072 208.238C176.142 202.743 178.207 196.216 182.232 191.414C184.036 189.256 188.174 190.577 187.59 193.68C186.391 200.042 181.992 206.052 178.424 211.358C174.018 217.902 169.1 224.041 163.826 229.883C162.048 231.852 158.829 229.476 160.474 227.306Z" fill="#252525" />
                            <path class="be-together-arrow-path" d="M103.295 270.539C119.444 264.503 132.816 254.946 144.156 242.039C147.189 238.592 152.901 242.93 149.89 246.455C138.116 260.219 122.459 270.015 105.082 274.998C102.196 275.825 100.362 271.626 103.295 270.539Z" fill="#252525" />
                            <path class="be-together-arrow-path" d="M151.308 286.069C150.543 286.119 149.79 286.161 149.025 286.212C149.263 287.069 149.48 287.924 149.719 288.782C146.844 286.466 139.237 286.733 135.514 285.985C131.041 285.086 126.58 284.104 122.141 283.029C116.657 281.708 103.269 280.632 100.347 274.823C97.0294 268.219 105.821 260.016 109.102 255.267C112.199 250.771 115.306 246.286 118.403 241.79C120.096 239.338 121.79 236.886 123.483 234.434C124.041 233.615 124.619 232.8 125.176 231.981C126.36 228.708 127.352 228.711 128.176 231.995C129.768 232.223 131.34 232.449 132.933 232.677C132.555 232.794 132.155 232.908 131.776 233.024C132.769 231.745 133.774 230.456 134.766 229.176C134.296 228.456 133.829 227.715 133.358 226.995C136.518 228.454 136.724 233.242 133.336 234.542C130.703 235.555 129.136 235.212 126.824 233.565C125.439 232.575 124.677 230.68 124.951 229.019C125.016 228.611 125.078 228.224 125.143 227.817C125.389 226.216 126.499 224.45 128.133 223.968C134.187 222.216 139.064 227.054 136.282 233.029C133.888 238.183 129.277 242.975 126.008 247.64C122.305 252.916 118.581 258.188 114.877 263.464C113.231 265.805 110.96 268.185 109.731 270.758C109.005 272.439 108.586 272.379 108.488 270.547C110.208 271.189 111.93 271.811 113.655 272.411C118.827 274.233 124.031 275.974 129.272 277.592C135.15 279.409 141.071 281.06 147.029 282.589C149.745 283.288 152.007 283.463 153.065 286.267C153.405 287.161 153.137 288.213 152.365 288.798C151.308 289.598 150.623 289.606 149.376 289.192C148.557 288.925 148.228 288.022 148.257 287.246C148.265 287.108 148.272 286.97 148.268 286.841C148.327 285.438 150.558 284.806 151.299 286.057L151.308 286.069Z" fill="#252525" />
                        </g>
                        <defs>
                            <clipPath id="clip0_38_795">
                                <rect width="208.694" height="235.915" fill="white" transform="matrix(-0.603592 -0.797293 -0.797293 0.603592 314.06 166.39)" />
                            </clipPath>
                        </defs>
                    </svg>
                </h2>
            </div>
            <div class="be-together-bottom">
                <div class="be-together-content">
                    <div class="be-together-left">
                        <?php if (! empty($settings['image_left']['url'])) : ?>
                            <div class="be-together-image-left">
                                <?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'image_left_size', 'image_left'); ?>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="be-together-text-content">
                        <p class="be-together-description"><?php echo esc_html($first_item['description']); ?></p>
                        <div class="be-together-buttons">
                            <?php if (! empty($settings['button_1_text'])) : ?>
                                <a href="<?php echo esc_url($button_1_url); ?>" class="be-together-button-1" <?php echo $button_1_target . $button_1_nofollow; ?>>
                                    <?php echo esc_html($settings['button_1_text']); ?>
                                </a>
                            <?php endif; ?>
                            <?php if (! empty($settings['button_2_text'])) : ?>
                                <a href="<?php echo esc_url($button_2_url); ?>" class="be-together-button-2" <?php echo $button_2_target . $button_2_nofollow; ?>>
                                    <?php echo esc_html($settings['button_2_text']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="be-together-right">
                        <?php if (! empty($settings['image_right']['url'])) : ?>
                            <div class="be-together-image-right">
                                <?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'image_right_size', 'image_right'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
<?php
    }

    protected function content_template() {}
}
