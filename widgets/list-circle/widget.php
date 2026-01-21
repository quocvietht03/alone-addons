<?php

namespace AloneAddons\Widgets\List_Circle;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

class Be_List_Circle extends Widget_Base
{

    public function get_name()
    {
        return 'be-list-circle';
    }

    public function get_title()
    {
        return __('List Circle', 'alone-addons');
    }

    public function get_icon()
    {
        return 'eicon-circle-o';
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
        $this->register_items_section_controls();
        $this->register_style_section_controls();
    }

    protected function register_items_section_controls()
    {
        $this->start_controls_section(
            'section_items',
            [
                'label' => __('Items', 'alone-addons'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_text',
            [
                'label' => __('Text', 'alone-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Item Text', 'alone-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_color',
            [
                'label' => __('Background Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#0066cc',
            ]
        );

        $repeater->add_control(
            'item_link',
            [
                'label' => __('Link', 'alone-addons'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $this->add_control(
            'items_list',
            [
                'label' => __('Items', 'alone-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_text' => __('Collective Action', 'alone-addons'),
                        'item_color' => '#6192AC',
                    ],
                    [
                        'item_text' => __('Public Awareness', 'alone-addons'),
                        'item_color' => '#DB6341',
                    ],
                    [
                        'item_text' => __('Social Equity', 'alone-addons'),
                        'item_color' => '#3F6F8F',
                    ],
                    [
                        'item_text' => __('Civic Participation', 'alone-addons'),
                        'item_color' => '#10A943',
                    ],
                    [
                        'item_text' => __('Youth Power', 'alone-addons'),
                        'item_color' => '#5FA5A5',
                    ],
                    [
                        'item_text' => __('Community Voices', 'alone-addons'),
                        'item_color' => '#3F6F8F',
                    ],
                    [
                        'item_text' => __('Policy Change', 'alone-addons'),
                        'item_color' => '#7D9F71',
                    ],
                ],
                'title_field' => '{{{ item_text }}}',
            ]
        );

        $this->add_responsive_control(
            'widget_size',
            [
                'label' => __('Widget Size', 'alone-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 900,
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 400,
                        'max' => 930,
                        'step' => 10,
                    ],
                ],
                'description' => __('Size of the widget (both width and height). Circle radius will be half of this value.', 'alone-addons'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'enable_rotation',
            [
                'label' => __('Enable Rotation', 'alone-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'alone-addons'),
                'label_off' => __('No', 'alone-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => __('Enable or disable the rotation animation', 'alone-addons'),
            ]
        );

        $this->add_control(
            'rotation_speed',
            [
                'label' => __('Rotation Speed (seconds)', 'alone-addons'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 60,
                ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 180,
                        'step' => 5,
                    ],
                ],
                'description' => __('Time for one complete rotation (higher = slower)', 'alone-addons'),
                'condition' => [
                    'enable_rotation' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function register_style_section_controls()
    {
        $this->start_controls_section(
            'section_style_items',
            [
                'label' => __('Items', 'alone-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_typography',
                'selector' => '{{WRAPPER}} .be-list-circle-items-wrapper .be-list-circle-item .be-list-circle-item-text',
            ]
        );

        $this->add_control(
            'item_text_color',
            [
                'label' => __('Text Color', 'alone-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .be-list-circle-items-wrapper .be-list-circle-item .be-list-circle-item-text' => 'color: {{VALUE}};',
                ],
            ]
        );

   

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (empty($settings['items_list'])) {
            return;
        }

        $enable_rotation = isset($settings['enable_rotation']) && $settings['enable_rotation'] === 'yes' ? 'yes' : 'no';
        $rotation_speed = !empty($settings['rotation_speed']['size']) ? $settings['rotation_speed']['size'] : 60;
        
        // Get responsive widget sizes
        $widget_size = !empty($settings['widget_size']['size']) ? $settings['widget_size']['size'] : 900;
        $widget_size_tablet = !empty($settings['widget_size_tablet']['size']) ? $settings['widget_size_tablet']['size'] : 600;
        $widget_size_mobile = !empty($settings['widget_size_mobile']['size']) ? $settings['widget_size_mobile']['size'] : 300;
        
        $items_count = count($settings['items_list']);

        // Calculate circle radius as half of widget size for each breakpoint
        $circle_radius = $widget_size / 2;
        $circle_radius_tablet = $widget_size_tablet / 2;
        $circle_radius_mobile = $widget_size_mobile / 2;

        $this->add_render_attribute('wrapper', 'class', 'be-list-circle-wrapper');
        $this->add_render_attribute('wrapper', 'data-enable-rotation', esc_attr($enable_rotation));
        $this->add_render_attribute('wrapper', 'data-rotation-speed', esc_attr($rotation_speed));
        $this->add_render_attribute('wrapper', 'data-items-count', esc_attr($items_count));
        
        // Add responsive styles and CSS variables
        $size_styles = 'width: ' . esc_attr($widget_size) . 'px; height: ' . esc_attr($widget_size) . 'px;';
        $size_styles .= ' --circle-radius: ' . esc_attr($circle_radius) . 'px;';
        if (!empty($widget_size_tablet)) {
            $size_styles .= ' --widget-size-tablet: ' . esc_attr($widget_size_tablet) . 'px;';
            $size_styles .= ' --circle-radius-tablet: ' . esc_attr($circle_radius_tablet) . 'px;';
        }
        if (!empty($widget_size_mobile)) {
            $size_styles .= ' --widget-size-mobile: ' . esc_attr($widget_size_mobile) . 'px;';
            $size_styles .= ' --circle-radius-mobile: ' . esc_attr($circle_radius_mobile) . 'px;';
        }
        $this->add_render_attribute('wrapper', 'style', $size_styles);
    
?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <!-- Circle rings -->
            <div class="be-list-circle-rings-wrapper">
                <div class="be-list-circle-ring be-list-circle-ring-outer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="930" height="930" viewBox="0 0 930 930" fill="none">
                        <path d="M474.468 930C337.844 930 200.689 870.697 111.753 767.944C76.1194 726.747 48.1237 678.854 28.5964 625.576C-15.0077 506.768 -8.49867 371.099 46.4301 253.3C97.4732 143.715 184.649 62.737 291.816 25.2772C357.339 2.35703 431.728 -4.71085 525.976 2.99651C591.665 8.38156 639.753 18.9497 681.93 37.3262C740.312 62.7369 794.444 106.76 847.446 171.852C886.135 219.409 909.382 260.907 920.507 302.54C933.425 350.77 930.802 400.548 926.352 455.947C921.237 519.626 915.027 581.554 895.301 639.442C849.172 774.944 724.006 884.496 576.389 918.523C542.981 926.231 508.708 929.966 474.436 929.966L474.468 930ZM117.864 762.525C227.19 888.871 410.74 948.343 574.629 910.546C719.556 877.092 842.432 769.66 887.662 636.784C907.057 579.804 913.234 518.414 918.282 455.274C922.666 400.649 925.289 351.611 912.703 304.66C901.877 264.205 879.128 223.683 841.202 177.068C789.064 113.02 735.928 69.7712 678.741 44.8653C637.428 26.859 590.138 16.4928 525.346 11.175C432.259 3.53502 358.899 10.502 294.473 33.0182C189.364 69.7712 103.883 149.234 53.7361 256.801C-0.229481 372.613 -6.63894 505.994 36.1683 622.682C55.3634 675.018 82.8609 722.07 117.831 762.525H117.864Z" fill="#3c322f1a" />
                    </svg>
                </div>
                <div class="be-list-circle-ring be-list-circle-ring-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" width="880" height="880" viewBox="0 0 880 880" fill="none">
                        <path d="M448.959 880C319.681 880 189.899 823.885 105.745 726.656C72.027 687.675 45.5364 642.357 27.059 591.943C-14.2009 479.522 -8.04175 351.147 43.9338 239.682C92.2327 135.988 174.721 59.364 276.127 23.9182C338.127 2.23031 408.517 -4.45758 497.698 2.8354C559.855 7.93094 605.358 17.9309 645.267 35.3195C700.51 59.364 751.732 101.02 801.884 162.613C838.493 207.613 860.49 246.879 871.018 286.274C883.241 331.912 880.758 379.013 876.549 431.434C871.708 491.689 865.832 550.287 847.167 605.064C803.518 733.281 685.081 836.943 545.401 869.14C513.788 876.433 481.358 879.968 448.928 879.968L448.959 880ZM111.527 721.529C214.976 841.082 388.657 897.357 543.735 861.592C680.87 829.936 797.14 728.281 839.939 602.548C858.29 548.631 864.136 490.542 868.912 430.797C873.06 379.109 875.542 332.707 863.633 288.281C853.389 250.001 831.863 211.657 795.976 167.548C746.641 106.943 696.362 66.02 642.249 42.4532C603.158 25.415 558.41 15.606 497.102 10.5742C409.019 3.34496 339.603 9.93735 278.641 31.243C179.183 66.02 98.2979 141.211 50.8471 242.994C-0.217144 352.58 -6.28201 478.79 34.2238 589.204C52.3869 638.727 78.406 683.249 111.496 721.529H111.527Z" fill="#3c322f1a" />
                    </svg>
                </div>
            </div>
            <!-- Items wrapper -->
            <div class="be-list-circle-items-wrapper">


                <?php
                $items_count = count($settings['items_list']);
                // Circle radius is calculated as half of widget height
                foreach ($settings['items_list'] as $index => $item) :
                    $item_link = !empty($item['item_link']['url']) ? $item['item_link']['url'] : '';
                    $item_target = !empty($item['item_link']['is_external']) ? ' target="_blank"' : '';
                    $item_nofollow = !empty($item['item_link']['nofollow']) ? ' rel="nofollow"' : '';
                    $item_color = !empty($item['item_color']) ? $item['item_color'] : '#0066cc';

                    // Calculate position in circle for each breakpoint
                    $angle = ($index * 2 * M_PI) / $items_count;
                    
                    // Desktop positions
                    $x_desktop = cos($angle) * $circle_radius;
                    $y_desktop = sin($angle) * $circle_radius;
                    
                    // Tablet positions
                    $x_tablet = cos($angle) * $circle_radius_tablet;
                    $y_tablet = sin($angle) * $circle_radius_tablet;
                    
                    // Mobile positions
                    $x_mobile = cos($angle) * $circle_radius_mobile;
                    $y_mobile = sin($angle) * $circle_radius_mobile;
                ?>
                    <div class="be-list-circle-item"
                        data-index="<?php echo esc_attr($index); ?>"
                        style="--background-color: <?php echo esc_attr($item_color); ?>; 
                               --x-desktop: <?php echo esc_attr($x_desktop); ?>px; 
                               --y-desktop: <?php echo esc_attr($y_desktop); ?>px;
                               --x-tablet: <?php echo esc_attr($x_tablet); ?>px; 
                               --y-tablet: <?php echo esc_attr($y_tablet); ?>px;
                               --x-mobile: <?php echo esc_attr($x_mobile); ?>px; 
                               --y-mobile: <?php echo esc_attr($y_mobile); ?>px;
                               left: calc(50% + var(--x-desktop)); 
                               top: calc(50% + var(--y-desktop));">
                        <?php if (!empty($item_link)) : ?>
                            <a href="<?php echo esc_url($item_link); ?>" class="be-list-circle-item-link" <?php echo $item_target . $item_nofollow; ?>>
                                <svg xmlns="http://www.w3.org/2000/svg" width="245" height="196" viewBox="0 0 245 196" fill="none">
                                    <path d="M158.848 4.83509C172.513 8.58443 186.01 14.619 198.869 23.2298C221.535 38.4087 238.92 61.3319 243.115 84.8164C249.846 122.438 223.196 155.685 193.025 174.004C112.624 222.778 -16.6516 185.514 1.77508 87.3352C13.0887 27.0102 88.0934 -14.6231 158.848 4.83509Z" fill="#6192AC" />
                                </svg>
                                <span class="be-list-circle-item-text"><?php echo esc_html($item['item_text']); ?></span>
                            </a>
                        <?php else : ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="245" height="196" viewBox="0 0 245 196" fill="none">
                                <path d="M158.848 4.83509C172.513 8.58443 186.01 14.619 198.869 23.2298C221.535 38.4087 238.92 61.3319 243.115 84.8164C249.846 122.438 223.196 155.685 193.025 174.004C112.624 222.778 -16.6516 185.514 1.77508 87.3352C13.0887 27.0102 88.0934 -14.6231 158.848 4.83509Z" fill="#6192AC" />
                            </svg>
                            <span class="be-list-circle-item-text"><?php echo esc_html($item['item_text']); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
<?php
    }

    protected function content_template() {}
}
