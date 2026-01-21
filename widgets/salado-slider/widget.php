<?php

namespace AloneAddons\Widgets\Salado_Slider;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Utils;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class Be_Salado_Slider extends Widget_Base
{

    public function get_name()
    {
        return 'be-salado-slider';
    }

    public function get_title()
    {
        return __('Be Salado Slider', 'alone-addons');
    }

    public function get_icon()
    {
        return 'eicon-slider-push';
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
            'sub_heading',
            [
                'label' => __('Sub Heading', 'alone-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Voices in action', 'alone-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'heading',
            [
                'label' => __('Heading', 'alone-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Your Voice Can Shape A Better Future', 'alone-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => __('Description', 'alone-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Uniting communities to raise awareness and inspire meaningful, lasting social change.', 'alone-addons'),
                'rows' => 3,
            ]
        );

        $repeater->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'alone-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('LEARN MORE', 'alone-addons'),
            ]
        );

        $repeater->add_control(
            'button_link',
            [
                'label' => __('Button Link', 'alone-addons'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );
        $repeater->add_control(
            'people_donation_images',
            [
                'label' => __('People Image', 'alone-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $repeater->add_control(
            'people_donation_text',
            [
                'label' => __('People Donation Text', 'alone-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('12.4K People Donated', 'alone-addons'),
                'rows' => 3,
                'label_block' => true,
                'separator' => 'before',
            ]
        );
        $repeater->add_control(
            'image_main',
            [
                'label' => __('Main Image', 'alone-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'slides_list',
            [
                'label' => __('Slides', 'alone-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'sub_heading' => __('Voices in action', 'alone-addons'),
                        'heading' => __('Your Voice Can Shape A Better Future', 'alone-addons'),
                        'description' => __('Uniting communities to raise awareness and inspire meaningful, lasting social change.', 'alone-addons'),
                        'button_text' => __('LEARN MORE', 'alone-addons'),
                        'people_donation_text' => __('12.4K People Donated', 'alone-addons'),
                    ],
                ],
                'title_field' => '{{{ heading }}}',
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

        $this->end_controls_section();
    }

    protected function register_additional_section_controls()
    {
        $this->start_controls_section(
            'section_additional_options',
            [
                'label' => __('Additional Options', 'alone-addons'),
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => __('Transition Duration', 'alone-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'alone-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Autoplay Speed', 'alone-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => __('Infinite Loop', 'alone-addons'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
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
            'content_padding',
            [
                'label' => __('Content Padding', 'alone-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_design_sub_heading_section_controls()
    {
        $this->start_controls_section(
            'section_design_sub_heading',
            [
                'label' => __('Sub Heading', 'alone-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sub_heading_color',
            [
                'label' => __('Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--sub-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_heading_typography',
                'selector' => '{{WRAPPER}} .be-salado-slider--sub-heading',
            ]
        );

        $this->add_control(
            'sub_heading_background',
            [
                'label' => __('Background Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--sub-heading' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_heading_padding',
            [
                'label' => __('Padding', 'alone-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--sub-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'sub_heading_border_radius',
            [
                'label' => __('Border Radius', 'alone-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--sub-heading' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_design_heading_section_controls()
    {
        $this->start_controls_section(
            'section_design_heading',
            [
                'label' => __('Heading', 'alone-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => __('Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .be-salado-slider--heading',
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label' => __('Margin', 'alone-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_design_description_section_controls()
    {
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
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .be-salado-slider--description',
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label' => __('Margin', 'alone-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_design_button_section_controls()
    {
        $this->start_controls_section(
            'section_design_button',
            [
                'label' => __('Button', 'alone-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .be-salado-slider--button',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'alone-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'alone-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button');

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
                    '{{WRAPPER}} .be-salado-slider--button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_background',
                'label' => __('Background', 'alone-addons'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .be-salado-slider--button',
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
            'button_text_color_hover',
            [
                'label' => __('Text Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_background_hover',
                'label' => __('Background', 'alone-addons'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .be-salado-slider--button:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function register_design_people_donation_section_controls()
    {
        $this->start_controls_section(
            'section_design_people_donation',
            [
                'label' => __('People Donation', 'alone-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'people_donation_text_color',
            [
                'label' => __('Text Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .be-salado-slider--people-donation-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'people_donation_typography',
                'selector' => '{{WRAPPER}} .be-salado-slider--people-donation-text',
            ]
        );


        $this->end_controls_section();
    }

    protected function register_design_image_section_controls()
    {
        $this->start_controls_section(
            'section_design_image',
            [
                'label' => __('Main Image', 'alone-addons'),
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
                    '{{WRAPPER}} .be-salado-slider--image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_design_navigation_section_controls()
    {
        $this->start_controls_section(
            'section_design_navigation',
            [
                'label' => __('Navigation', 'alone-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'navigation_size',
            [
                'label' => __('Button Size', 'alone-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 30,
                        'max' => 120,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'navigation_icon_size',
            [
                'label' => __('Icon Size', 'alone-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-swiper-button svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'navigation_border_radius',
            [
                'label' => __('Border Radius', 'alone-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],

                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_navigation');

        $this->start_controls_tab(
            'tabs_navigation_normal',
            [
                'label' => __('Normal', 'alone-addons'),
            ]
        );

        $this->add_control(
            'navigation_icon_color',
            [
                'label' => __('Icon Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .elementor-swiper-button svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'navigation_background',
            [
                'label' => __('Background Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_navigation_hover',
            [
                'label' => __('Hover', 'alone-addons'),
            ]
        );

        $this->add_control(
            'navigation_icon_color_hover',
            [
                'label' => __('Icon Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button:hover i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .elementor-swiper-button:hover svg' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'navigation_background_hover',
            [
                'label' => __('Background Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function register_design_pagination_section_controls()
    {
        $this->start_controls_section(
            'section_design_pagination',
            [
                'label' => __('Pagination', 'alone-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'pagination_height',
            [
                'label' => __('Height', 'alone-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label' => __('Progress Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'pagination_bg_color',
            [
                'label' => __('Background Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-progressbar' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_controls()
    {
        $this->register_layout_section_controls();
        $this->register_additional_section_controls();

        $this->register_design_layout_section_controls();
        $this->register_design_sub_heading_section_controls();
        $this->register_design_heading_section_controls();
        $this->register_design_description_section_controls();
        $this->register_design_button_section_controls();
        $this->register_design_people_donation_section_controls();
        $this->register_design_image_section_controls();
        $this->register_design_navigation_section_controls();
        $this->register_design_pagination_section_controls();
    }

    protected function swiper_data()
    {
        $settings = $this->get_settings_for_display();

        $swiper_data = array(
            'slidesPerView' => 1,
            'spaceBetween' => 0,
            'speed' => $settings['speed'],
            'loop' => $settings['loop'] == 'yes' ? true : false,
            'navigation' => array(
                'nextEl' => '.elementor-swiper-button-next',
                'prevEl' => '.elementor-swiper-button-prev',
            ),
            'pagination' => array(
                'el' => '.be-salado-slider-pagination',
                'type' => 'progressbar',
                'clickable' => true,
            ),
        );

        if ($settings['autoplay'] === 'yes') {
            $swiper_data['autoplay'] = array(
                'delay' => $settings['autoplay_speed'],
            );
        }

        return json_encode($swiper_data);
    }

    protected function render_icon($icon)
    {
        $icon_html = '';

        if (!empty($icon['value'])) {
            if ('svg' !== $icon['library']) {
                $icon_html = '<i class="' . esc_attr($icon['value']) . '" aria-hidden="true"></i>';
            } else {
                $icon_html = file_get_contents($icon['value']['url']);
            }
        }

        return $icon_html;
    }

    protected function render_navigation()
    {
        $settings = $this->get_settings_for_display();

?>
        <div class="be-salado-slider--navigation-wrapper">
            <div class="elementor-swiper-button elementor-swiper-button-prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="CurrentColor">
                    <path d="M21.0001 12.0004C21.0001 12.1993 20.9211 12.3901 20.7804 12.5307C20.6398 12.6714 20.449 12.7504 20.2501 12.7504H5.56041L11.0307 18.2198C11.1004 18.2895 11.1557 18.3722 11.1934 18.4632C11.2311 18.5543 11.2505 18.6519 11.2505 18.7504C11.2505 18.849 11.2311 18.9465 11.1934 19.0376C11.1557 19.1286 11.1004 19.2114 11.0307 19.281C10.961 19.3507 10.8783 19.406 10.7873 19.4437C10.6962 19.4814 10.5986 19.5008 10.5001 19.5008C10.4016 19.5008 10.304 19.4814 10.2129 19.4437C10.1219 19.406 10.0392 19.3507 9.96948 19.281L3.21948 12.531C3.14974 12.4614 3.09443 12.3787 3.05668 12.2876C3.01894 12.1966 2.99951 12.099 2.99951 12.0004C2.99951 11.9019 3.01894 11.8043 3.05668 11.7132C3.09443 11.6222 3.14974 11.5394 3.21948 11.4698L9.96948 4.71979C10.1102 4.57906 10.3011 4.5 10.5001 4.5C10.6991 4.5 10.89 4.57906 11.0307 4.71979C11.1715 4.86052 11.2505 5.05139 11.2505 5.25042C11.2505 5.44944 11.1715 5.64031 11.0307 5.78104L5.56041 11.2504H20.2501C20.449 11.2504 20.6398 11.3294 20.7804 11.4701C20.9211 11.6107 21.0001 11.8015 21.0001 12.0004Z" />
                </svg>
            </div>
            <div class="elementor-swiper-button elementor-swiper-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="CurrentColor">
                    <path d="M20.7806 12.531L14.0306 19.281C13.8899 19.4218 13.699 19.5008 13.5 19.5008C13.301 19.5008 13.1101 19.4218 12.9694 19.281C12.8286 19.1403 12.7496 18.9494 12.7496 18.7504C12.7496 18.5514 12.8286 18.3605 12.9694 18.2198L18.4397 12.7504H3.75C3.55109 12.7504 3.36032 12.6714 3.21967 12.5307C3.07902 12.3901 3 12.1993 3 12.0004C3 11.8015 3.07902 11.6107 3.21967 11.4701C3.36032 11.3294 3.55109 11.2504 3.75 11.2504H18.4397L12.9694 5.78104C12.8286 5.64031 12.7496 5.44944 12.7496 5.25042C12.7496 5.05139 12.8286 4.86052 12.9694 4.71979C13.1101 4.57906 13.301 4.5 13.5 4.5C13.699 4.5 13.8899 4.57906 14.0306 4.71979L20.7806 11.4698C20.8504 11.5394 20.9057 11.6222 20.9434 11.7132C20.9812 11.8043 21.0006 11.9019 21.0006 12.0004C21.0006 12.099 20.9812 12.1966 20.9434 12.2876C20.9057 12.3787 20.8504 12.4614 20.7806 12.531Z" />
                </svg>
            </div>
        </div>
    <?php
    }

    protected function render_pagination()
    {
        echo '<div class="be-salado-slider-pagination elementor-swiper-pagination"></div>';
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['slides_list'])) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'be-salado-slider-wrapper');
        $this->add_render_attribute('swiper', 'class', 'elementor-swiper swiper-container be-salado-slider');
        $this->add_render_attribute('swiper', 'data-swiper', esc_attr($this->swiper_data()));

    ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <div <?php echo $this->get_render_attribute_string('swiper'); ?>>
                <div class="swiper-wrapper">
                    <?php foreach ($settings['slides_list'] as $index => $item) :
                        $button_target = $item['button_link']['is_external'] ? ' target="_blank"' : '';
                        $button_nofollow = $item['button_link']['nofollow'] ? ' rel="nofollow"' : '';
                        $button_url = ! empty($item['button_link']['url']) ? $item['button_link']['url'] : '#';
                    ?>
                        <div class="swiper-slide">
                            <div class="be-salado-slider--slide">
                                <div class="be-salado-slider--content">
                                    <?php if (! empty($item['sub_heading'])) : ?>
                                        <span class="be-salado-slider--sub-heading"><?php echo esc_html($item['sub_heading']); ?></span>
                                    <?php endif; ?>

                                    <?php if (! empty($item['heading'])) : ?>
                                        <h2 class="be-salado-slider--heading"><?php echo esc_html($item['heading']); ?></h2>
                                    <?php endif; ?>

                                    <?php if (! empty($item['description'])) : ?>
                                        <p class="be-salado-slider--description"><?php echo esc_html($item['description']); ?></p>
                                    <?php endif; ?>
                                    <div class="be-salado-slider--button-wrapper">
                                        <?php if (! empty($item['button_text'])) : ?>
                                            <a href="<?php echo esc_url($button_url); ?>" class="be-salado-slider--button" <?php echo $button_target . $button_nofollow; ?>>
                                                <?php echo esc_html($item['button_text']); ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M20.7806 12.531L14.0306 19.281C13.8899 19.4218 13.699 19.5008 13.5 19.5008C13.301 19.5008 13.1101 19.4218 12.9694 19.281C12.8286 19.1403 12.7496 18.9494 12.7496 18.7504C12.7496 18.5514 12.8286 18.3605 12.9694 18.2198L18.4397 12.7504H3.75C3.55109 12.7504 3.36032 12.6714 3.21967 12.5307C3.07902 12.3901 3 12.1993 3 12.0004C3 11.8015 3.07902 11.6107 3.21967 11.4701C3.36032 11.3294 3.55109 11.2504 3.75 11.2504H18.4397L12.9694 5.78104C12.8286 5.64031 12.7496 5.44944 12.7496 5.25042C12.7496 5.05139 12.8286 4.86052 12.9694 4.71979C13.1101 4.57906 13.301 4.5 13.5 4.5C13.699 4.5 13.8899 4.57906 14.0306 4.71979L20.7806 11.4698C20.8504 11.5394 20.9057 11.6222 20.9434 11.7132C20.9812 11.8043 21.0006 11.9019 21.0006 12.0004C21.0006 12.099 20.9812 12.1966 20.9434 12.2876C20.9057 12.3787 20.8504 12.4614 20.7806 12.531Z" fill="white" />
                                                </svg>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (! empty($item['people_donation_text']) || ! empty($item['people_donation_images'])) : ?>
                                            <div class="be-salado-slider--people-donation">
                                                <?php if (! empty($item['people_donation_images'])) : ?>
                                                    <div class="be-salado-slider--people-images">
                                                        <?php
                                                        if (! empty($item['people_donation_images']['id'])) {
                                                            echo wp_get_attachment_image($item['people_donation_images']['id'], 'thumbnail');
                                                        } elseif (! empty($item['people_donation_images']['url'])) {
                                                            echo '<img src="' . esc_url($item['people_donation_images']['url']) . '" alt="' . esc_attr__('People image', 'alone-addons') . '">';
                                                        } else {
                                                            echo '<img src="' . esc_url(Utils::get_placeholder_image_src()) . '" alt="' . esc_attr__('Awaiting image', 'alone-addons') . '">';
                                                        }
                                                        ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (! empty($item['people_donation_text'])) : ?>
                                                    <?php echo '<div class="be-salado-slider--people-donation-text">' . $item['people_donation_text'] . '</div>'; ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="be-salado-slider--image">
                                    <div class="be-salado-slider--image-inner">
                                        <?php
                                        if (! empty($item['image_main']['id'])) {
                                            $image_size = ! empty($settings['image_main_size_size']) ? $settings['image_main_size_size'] : 'large';
                                            echo wp_get_attachment_image($item['image_main']['id'], $image_size);
                                        } else {
                                            echo '<img src="' . esc_url(Utils::get_placeholder_image_src()) . '" alt="' . esc_attr__('Awaiting image', 'alone-addons') . '">';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="be-salado-slider--actions">
                    <?php $this->render_pagination(); ?>
                    <?php $this->render_navigation(); ?>
                </div>

            </div>
        </div>
<?php
    }

    protected function content_template() {}
}
