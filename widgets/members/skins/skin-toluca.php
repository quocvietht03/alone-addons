<?php
namespace AloneAddons\Widgets\Members\Skins;

use Elementor\Widget_Base;
use Elementor\Skin_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Toluca extends Skin_Base {

	protected function _register_controls_actions() {
		add_action( 'elementor/element/be-members/section_layout/before_section_end', [ $this, 'register_layout_controls' ] );
		add_action( 'elementor/element/be-members/section_design_layout/before_section_end', [ $this, 'registerd_design_layout_controls' ] );
        add_action( 'elementor/element/be-members/section_design_layout/after_section_end', [ $this, 'register_design_box_section_controls' ] );
		add_action( 'elementor/element/be-members/section_design_layout/after_section_end', [ $this, 'register_design_image_section_controls' ] );
        add_action( 'elementor/element/be-members/section_design_layout/after_section_end', [ $this, 'register_design_content_section_controls' ] );

	}

	public function get_id() {
		return 'skin-toluca';
	}


	public function get_title() {
		return __( 'Toluca', 'alone-addons' );
	}


	public function register_layout_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'prefix_class' => 'elementor-grid%s-',
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'alone-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

    $this->add_control(
			'show_thumbnail',
			[
				'label' => __( 'Thumbnail', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'medium',
				'exclude' => [ 'custom' ],
				'condition' => [
					'skin_toluca_show_thumbnail!'=> '',
				],
			]
		);

		$this->add_responsive_control(
			'item_ratio',
			[
				'label' => __( 'Image Ratio', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1.2,
				],
				'range' => [
					'px' => [
						'min' => 0.3,
						'max' => 2,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-member__thumbnail' => 'padding-bottom: calc( {{SIZE}} * 100% );',
				],
				'condition' => [
					'skin_toluca_show_thumbnail!'=> '',
				],
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Title', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_position',
			[
				'label' => __( 'Position', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_socials',
			[
				'label' => __( 'Socials', 'alone-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'alone-addons' ),
				'label_off' => __( 'Hide', 'alone-addons' ),
				'default' => 'yes',
			]
		);

	}

	public function registerd_design_layout_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->add_control(
			'column_gap',
			[
				'label' => __( 'Columns Gap', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--grid-column-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'row_gap',
			[
				'label' => __( 'Rows Gap', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 35,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => '--grid-row-gap: {{SIZE}}{{UNIT}}',
				],
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
					'{{WRAPPER}} .elementor-member' => 'text-align: {{VALUE}};',
				],
			]
		);

	}

  public function register_design_box_section_controls( Widget_Base $widget ) {
		$this->parent = $widget;

    $this->start_controls_section(
			'section_design_box',
			[
				'label' => __( 'Box', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'box_border_width',
			[
				'label' => __( 'Border Width', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-member' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'box_border_radius',
			[
				'label' => __( 'Border Radius', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-member' => 'border-radius: {{SIZE}}{{UNIT}}',
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
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-member' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => __( 'Content Padding', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-member__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'bg_effects_tabs' );

		$this->start_controls_tab( 'classic_style_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .elementor-member',
			]
		);

		$this->add_control(
			'box_bg_color',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-member' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'box_border_color',
			[
				'label' => __( 'Border Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-member' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'classic_style_hover',
			[
				'label' => __( 'Hover', 'alone-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_hover',
				'selector' => '{{WRAPPER}} .elementor-member:hover',
			]
		);

		$this->add_control(
			'box_bg_color_hover',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-member:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'box_border_color_hover',
			[
				'label' => __( 'Border Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-member:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

  }

	public function register_design_image_section_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->start_controls_section(
			'section_design_image',
			[
				'label' => __( 'Image', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'skin_toluca_show_thumbnail!'=> '',
				],
			]
		);

		$this->add_control(
			'img_border_radius',
			[
				'label' => __( 'Border Radius', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-member__thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'thumbnail_effects_tabs' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_filters',
				'selector' => '{{WRAPPER}} .elementor-member__thumbnail img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => __( 'Hover', 'alone-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_hover_filters',
				'selector' => '{{WRAPPER}} .elementor-member:hover .elementor-member__thumbnail img',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

  public function register_design_content_section_controls( Widget_Base $widget ) {
		$this->parent = $widget;

    $this->start_controls_section(
			'section_design_content',
			[
				'label' => __( 'Content', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_title_style',
			[
				'label' => __( 'Title', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'skin_toluca_show_title!' => '',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-member__title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'skin_toluca_show_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'default' => '',
				'selector' => '{{WRAPPER}} .elementor-member__title',
				'condition' => [
					'skin_toluca_show_title!' => '',
				],
			]
		);

		$this->add_control(
			'heading_position_style',
			[
				'label' => __( 'Position', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'skin_toluca_show_position!' => '',
				],
			]
		);

		$this->add_control(
			'position_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-member__position' => 'color: {{VALUE}};',
				],
				'condition' => [
					'skin_toluca_show_position!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'position_typography',
				'default' => '',
				'selector' => '{{WRAPPER}} .elementor-member__position',
				'condition' => [
					'skin_toluca_show_position!' => '',
				],
			]
		);

		$this->add_control(
			'heading_socials_style',
			[
				'label' => __( 'Socials', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'skin_toluca_show_socials!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_socials' );

		$this->start_controls_tab(
			'tab_socials_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

    $this->add_control(
			'socials_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-member__socials a' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_socials_hover',
			[
				'label' => __( 'Hover', 'alone-addons' ),
			]
		);

    $this->add_control(
			'socials_color_hover',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-member__socials a:hover' => 'color: {{VALUE}};',
				],
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

    	$this->end_controls_section();
  	}

	protected function render_post() {
		$settings = $this->parent->get_settings_for_display();

		?>
		<article id="post-<?php the_ID();  ?>" <?php post_class( 'elementor-member' ); ?>>
			<?php if( '' !== $this->parent->get_instance_value_skin('show_thumbnail') ) { ?>
				<div class="elementor-member__thumbnail">
					<?php the_post_thumbnail( $this->parent->get_instance_value_skin('thumbnail_size') ); ?>
				</div>
			<?php } ?>

			<div class="elementor-member__content">
				<?php
					if( '' !== $this->parent->get_instance_value_skin('show_title') ) {
						the_title( '<h3 class="elementor-member__title"><a href="' . get_the_permalink() . '">', '</a></h3>' );
					}

					if( '' !== $this->parent->get_instance_value_skin('show_position') ) {
						echo $this->parent->render_position();
					}
				?>
                <div class="elementor-member__infor">
                    <?php
                        if( '' !== $this->parent->get_instance_value_skin('show_socials') ) {
                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="currentColor">
                                    <path d="M16.1939 6.87447C15.1878 6.87447 14.2813 6.43996 13.6521 5.74879L7.99307 9.25369C8.14415 9.64046 8.22794 10.0605 8.22794 10.5C8.22794 10.9397 8.14415 11.3597 7.99307 11.7463L13.6521 15.2514C14.2813 14.5602 15.1878 14.1256 16.1939 14.1256C18.0893 14.1256 19.6312 15.6675 19.6312 17.5629C19.6312 19.4582 18.0893 21 16.1939 21C14.2986 21 12.7566 19.4581 12.7566 17.5627C12.7566 17.1232 12.8406 16.7031 12.9915 16.3164L7.33265 12.8115C6.70348 13.5026 5.79697 13.9373 4.79081 13.9373C2.89544 13.9373 1.35352 12.3952 1.35352 10.5C1.35352 8.60466 2.89544 7.06273 4.79081 7.06273C5.79697 7.06273 6.70348 7.49724 7.33265 8.18857L12.9915 4.68367C12.8406 4.2969 12.7566 3.87681 12.7566 3.43718C12.7566 1.54197 14.2986 4.3869e-05 16.1939 4.3869e-05C18.0893 4.3869e-05 19.6312 1.54197 19.6312 3.43718C19.6312 5.33254 18.0893 6.87447 16.1939 6.87447ZM14.01 17.5627C14.01 18.7669 14.9897 19.7466 16.1939 19.7466C17.3981 19.7466 18.3778 18.7669 18.3778 17.5627C18.3778 16.3585 17.3981 15.3788 16.1939 15.3788C14.9897 15.3788 14.01 16.3585 14.01 17.5627ZM4.79081 8.3161C3.58646 8.3161 2.60673 9.29583 2.60673 10.5C2.60673 11.7042 3.58646 12.6839 4.79081 12.6839C5.995 12.6839 6.97457 11.7042 6.97457 10.5C6.97457 9.29583 5.995 8.3161 4.79081 8.3161ZM14.01 3.43734C14.01 4.64153 14.9897 5.62126 16.1939 5.62126C17.3981 5.62126 18.3778 4.64153 18.3778 3.43734C18.3778 2.23315 17.3981 1.25342 16.1939 1.25342C14.9897 1.25342 14.01 2.23315 14.01 3.43734Z"/>
                                </svg>';
                            echo $this->parent->render_socials();
                        }
                    ?>
                </div>
			</div>
		</article>
		<?php
	}

	public function render() {

		$query = $this->parent->query_posts();

		if ( $query->have_posts() ) {

			$this->parent->render_loop_header();

				while ( $query->have_posts() ) {
					$query->the_post();

					$this->render_post();

				}

			$this->parent->render_loop_footer();

		} else {
		    // no posts found
		}

		wp_reset_postdata();
	}

	protected function content_template() {

	}

}
