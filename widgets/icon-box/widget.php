<?php
namespace AloneAddons\Widgets\Icon_Box;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Be_Icon_Box extends Widget_Base {

	public function get_name() {
		return 'be-icon-box';
	}

	public function get_title() {
		return __( 'Be Icon Box', 'alone-addons' );
	}

	public function get_icon() {
		return 'eicon-icon-box';
	}

	public function get_categories() {
		return [ 'alone-addons' ];
	}

	protected function register_skins() {
		$this->add_skin( new Skins\Skin_Pumori( $this ) );
		$this->add_skin( new Skins\Skin_Baruntse( $this ) );
		$this->add_skin( new Skins\Skin_Coropuna( $this ) );
		$this->add_skin( new Skins\Skin_Ampato( $this ) );
		$this->add_skin( new Skins\Skin_Andrus( $this ) );
		$this->add_skin( new Skins\Skin_Saltoro( $this ) );
		$this->add_skin( new Skins\Skin_Cholatse( $this ) );
		$this->add_skin( new Skins\Skin_Jimara( $this ) );

	}

	protected function register_layout_section_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout', 'alone-addons' ),
			]
		);

		$this->add_control(
			'select_icon',
			[
				'label' => __( 'Icon', 'alone-addons' ),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default' => [
					'value' => 'fa fa-star',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'icon_view',
			[
				'label' => __( 'View', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'alone-addons' ),
					'stacked' => __( 'Stacked', 'alone-addons' ),
					'framed' => __( 'Framed', 'alone-addons' ),
				],
				'prefix_class' => 'elementor-icon-box--icon-view-',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'icon_shape',
			[
				'label' => __( 'Shape', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'circle',
				'options' => [
					'circle' => __( 'Circle', 'alone-addons' ),
					'square' => __( 'Square', 'alone-addons' ),
				],
				'condition' => [
					'icon_view!' => '',
					'_skin' => '',
				],
				'prefix_class' => 'elementor-icon-box--icon-shape-',
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label' => __( 'Icon Position', 'alone-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'top',
				'options' => [
					'left' => [
						'title' => __( 'Left', 'alone-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'top' => [
						'title' => __( 'Top', 'alone-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'right' => [
						'title' => __( 'Right', 'alone-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'prefix_class' => 'elementor-icon-box--icon-position-',
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'alone-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'This is the heading', 'alone-addons' ),
			]
		);

		$this->add_control(
			'title_link',
			[
				'label' => __( 'Title Link', 'alone-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '#',
			]
		);

		$this->add_control(
			'desc',
			[
				'label' => __( 'Description', 'alone-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'alone-addons' ),
				'condition' => [
					'_skin!' => 'skin-cholatse',
				],
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

		$this->add_control(
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
				'condition' => [
					'icon_position' => ['', 'top'],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'vertical_ignment',
			[
				'label' => __( 'Vertical Alignment', 'alone-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'top' => __( 'Top', 'alone-addons' ),
					'middle' => __( 'Middle', 'alone-addons' ),
					'bottom' => __( 'Bottom', 'alone-addons' ),
				],
				'condition' => [
					'_skin' => '',
					'icon_position!' => ['', 'top'],
				],
				'prefix_class' => 'elementor-icon-box--vertical-align-',
			]
		);

		$this->end_controls_section();
	}

	protected function register_design_icon_section_controls() {
		$this->start_controls_section(
			'section_design_icon',
			[
				'label' => __( 'Icon', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box__icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-icon-box__icon svg' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_size_wrap',
			[
				'label' => __( 'Wrap Size', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
					],
				],
				'condition' => [
					'icon_view!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-icon-box--icon-view-stacked .elementor-icon-box__icon,
					 {{WRAPPER}}.elementor-icon-box--icon-view-framed .elementor-icon-box__icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_border',
			[
				'label' => __( 'Border Size', 'alone-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => '',
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'condition' => [
					'icon_view' => 'framed',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-icon-box--icon-view-framed .elementor-icon-box__icon' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label' => __( 'Border Radius', 'alone-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'condition' => [
					'icon_view!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-icon-box--icon-view-stacked .elementor-icon-box__icon,
					 {{WRAPPER}}.elementor-icon-box--icon-view-framed .elementor-icon-box__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_icon' );

		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => __( 'Normal', 'alone-addons' ),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box__icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-icon-box__icon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}}.elementor-icon-box--icon-view-stacked .elementor-icon-box__icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-icon-box--icon-view-stacked .elementor-icon-box__icon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}}.elementor-icon-box--icon-view-framed .elementor-icon-box__icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-icon-box--icon-view-framed .elementor-icon-box__icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_background',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_view!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-icon-box--icon-view-stacked .elementor-icon-box__icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-icon-box--icon-view-framed .elementor-icon-box__icon' => 'background-color: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'icon_border_color',
			[
				'label' => __( 'Border Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_view' => 'framed',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-icon-box--icon-view-framed .elementor-icon-box__icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => __( 'Hover', 'alone-addons' ),
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box:hover .elementor-icon-box__icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .elementor-icon-box:hover .elementor-icon-box__icon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}}.elementor-icon-box--icon-view-stacked:hover .elementor-icon-box__icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-icon-box--icon-view-stacked:hover .elementor-icon-box__icon svg' => 'fill: {{VALUE}};',
					'{{WRAPPER}}.elementor-icon-box--icon-view-framed:hover .elementor-icon-box__icon i' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-icon-box--icon-view-framed:hover .elementor-icon-box__icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_background_hover',
			[
				'label' => __( 'Background Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_view!' => '',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-icon-box--icon-view-stacked:hover .elementor-icon-box__icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-icon-box--icon-view-framed:hover .elementor-icon-box__icon' => 'background-color: {{VALUE}};',

				],
			]
		);

		$this->add_control(
			'icon_border_color_hover',
			[
				'label' => __( 'Border Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'icon_view' => 'framed',
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-icon-box--icon-view-framed .elementor-icon-box__icon:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}


	protected function register_design_content_section_controls() {
		$this->start_controls_section(
			'section_design_content',
			[
				'label' => __( 'Content', 'alone-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'_skin' => '',
				],
			]
		);

		$this->add_control(
			'heading_title_style',
			[
				'label' => __( 'Title', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label' => __( 'Color Hover', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box__title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_title',
				'default' => '',
				'selector' => '{{WRAPPER}} .elementor-icon-box__title',
			]
		);

		$this->add_control(
			'heading_desc_style',
			[
				'label' => __( 'Description', 'alone-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => __( 'Color', 'alone-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-icon-box__desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography_desc',
				'default' => '',
				'selector' => '{{WRAPPER}} .elementor-icon-box__desc',
			]
		);

		$this->end_controls_section();
	}

	protected function register_controls() {
		$this->register_layout_section_controls();

		$this->register_design_layout_section_controls();
		$this->register_design_icon_section_controls();
		$this->register_design_content_section_controls();
	}

	public function get_instance_value_skin( $key ) {
		$settings = $this->get_settings_for_display();

		if( !empty( $settings['_skin'] ) && isset( $settings[str_replace( '-', '_', $settings['_skin'] ) . '_' . $key] ) ) {
			 return $settings[str_replace( '-', '_', $settings['_skin'] ) . '_' . $key];
		}
		return $settings[$key];
	}

	public function render_element_header() {
		$settings = $this->get_settings_for_display();

		if( $settings['_skin'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-icon-box elementor-icon-box--' . $settings['_skin'] );
		} else {
			$this->add_render_attribute( 'wrapper', 'class', 'elementor-icon-box  elementor-icon-box--default' );
		}
		?>
			<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
		<?php
	}

	public function render_element_footer() {

		?>
			</div>
		<?php
	}

	public function render_icon() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
			// add old default
			$settings['icon'] = 'fa fa-star';
		}

		if ( ! empty( $settings['icon'] ) ) {
			$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
			$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
		}

		$migrated = isset( $settings['__fa4_migrated']['select_icon'] );
		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		if ( $is_new || $migrated ) {
			Icons_Manager::render_icon( $settings['select_icon'], [ 'aria-hidden' => 'true' ] );
		} else {
			?>
				<i <?php $this->print_render_attribute_string( 'icon' ); ?>></i>
			<?php
		}
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->render_element_header();

		?>

		<div class="elementor-icon-box__icon-wrap">
			<div class="elementor-icon-box__icon">
				<?php echo $this->render_icon(); ?>
			</div>
		</div>
		<div class="elementor-icon-box__content">
			<?php
			if( $settings['title'] ) {
				echo '<h3 class="elementor-icon-box__title">'.
							'<a href="' . esc_url( $settings['title_link'] ) . '">' . $settings['title'] . '</a>' .
						'</h3>';
			}

			if( $settings['desc'] ) {
				echo '<div class="elementor-icon-box__desc">' . $settings['desc'] . '</div>';
			}

			?>
		</div>

		<?php

		$this->render_element_footer();

	}

	protected function content_template() {

	}
}
