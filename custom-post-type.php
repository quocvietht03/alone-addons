<?php
/**
 * Register post types
 *
 * @package Alone
 */

/**
 * Class Alone_Custom_Post_Type
 */
class Alone_Custom_Post_Type {

	/**
	 * Construction function
	 *
	 * @since 2.0.0
	 *
	 * @return Alone_Custom_Post_Type
	 */

	/**
	 * Check if active post type
	 *
	 * @var bool
	 */
	private $give_posts_option = 'give_posts_slug';
	private $project_option = 'project_slug';
	private $team_option = 'team_slug';



	public function __construct() {
		if ( post_type_exists( 'give_posts' ) && post_type_exists( 'project' ) && post_type_exists( 'team' ) ) {
			return;
		}

		add_action( 'admin_init', array( $this, 'settings_api_init' ) );
		add_action( 'current_screen', array( $this, 'settings_save' ) );

		// Register custom post type and custom taxonomy
		add_action( 'init', array( $this, 'register_custom_post_type' ), 10);
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add custom fields
		add_action( 'add_meta_boxes', array( $this, 'add_custom_fields' ) );
		add_action('save_post', array( $this, 'save_custom_fields' ) );

	}

	/**
	 * Register custom post type
	 *
	 * @since  1.0.0
	 *
	 * @return void
	 */
	public function register_custom_post_type() {
		/**
		 * Register Give Posts CPT
		 */
		if ( ( ! post_type_exists( 'give_posts' ) && ! get_option( $this->give_posts_option ) ) ) {
			// Register post type
			$labels = array(
				"name" => __( "Give Posts", "alone-addons" ),
				"singular_name" => __( "Give Post", "alone-addons" )
			);

			$give_posts_permalinks = get_option( 'give_posts_permalinks' );
			$give_posts_base = empty( $give_posts_permalinks['give_posts_base'] ) ? _x( 'give_posts', 'slug', 'alone-addons' ) : $give_posts_permalinks['give_posts_base'];

			$args = array(
				"label" => __( "Give Post", "alone-addons" ),
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => true,
				"rest_base" => "",
				"rest_controller_class" => "WP_REST_Posts_Controller",
				"has_archive" => false,
				"show_in_menu" => true,
				"show_in_nav_menus" => true,
				"menu_icon" => "dashicons-heart",
				"delete_with_user" => false,
				"exclude_from_search" => false,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"rewrite" => [
					"slug" => $give_posts_base,
					"with_front" => true
				],
				"query_var" => true,
				"supports" => array( "title", "editor", "excerpt", "thumbnail" ),
			);
			register_post_type( "give_posts", $args );

			// Register category
			$labels = array(
				"name" => __( "Categories", "alone-addons" ),
				"singular_name" => __( "Category", "alone-addons" ),
				"menu_name" => __( "Categories", "alone-addons" ),
				"all_items" => __( "All Categories", "alone-addons" ),
			);

			$give_posts_tax_permalinks = get_option( 'give_posts_taxt_permalinks' );
			$give_posts_tax_base = empty( $give_posts_tax_permalinks['give_posts_tax_base'] ) ? _x( 'give_posts-category', 'slug', 'alone-addons' ) : $give_posts_tax_permalinks['give_posts_tax_base'];

			$args = array(
				"label" => __( "Categories", "alone-addons" ),
				"labels" => $labels,
				"public" => true,
				"publicly_queryable" => true,
				"hierarchical" => true,
				"show_ui" => true,
				"show_in_menu" => true,
				"show_in_nav_menus" => true,
				"query_var" => true,
				"rewrite" => [
					"slug" => $give_posts_tax_base,
					"with_front" => true
				],
				"show_admin_column" => true,
				"show_in_rest" => true,
				"rest_base" => "give_posts_category",
				"rest_controller_class" => "WP_REST_Terms_Controller",
				"show_in_quick_edit" => true,
			);
			register_taxonomy( "give_posts_category", array( "give_posts" ), $args );

			// Register tags
			$labels = array(
				"name" => __( "Tags", "alone-addons" ),
				"singular_name" => __( "Tag", "alone-addons" ),
				"menu_name" => __( "Tags", "alone-addons" ),
				"all_items" => __( "All Tags", "alone-addons" ),
			);

			$args = array(
				"label" => __( "Tags", "alone-addons" ),
				"labels" => $labels,
				"public" => true,
				"publicly_queryable" => true,
				"hierarchical" => false,
				"show_ui" => true,
				"show_in_menu" => true,
				"show_in_nav_menus" => true,
				"query_var" => true,
				"rewrite" => false,
				"show_admin_column" => true,
				"show_in_rest" => true,
				"rest_base" => "give_posts_tag",
				"rest_controller_class" => "WP_REST_Terms_Controller",
				"show_in_quick_edit" => true,
			);
			register_taxonomy( "give_posts_tag", array( "give_posts" ), $args );
		}

		/**
		 * Register project CPT
		 */
		if ( ( ! post_type_exists( 'project' ) && ! get_option( $this->project_option ) ) ) {
			// Register post type
			$labels = array(
				"name" => __( "Projects", "alone-addons" ),
				"singular_name" => __( "Project", "alone-addons" )
			);

			$project_permalinks = get_option( 'project_permalinks' );
			$project_base = empty( $project_permalinks['project_base'] ) ? _x( 'project', 'slug', 'alone-addons' ) : $project_permalinks['project_base'];

			$args = array(
				"label" => __( "Projects", "alone-addons" ),
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => true,
				"rest_base" => "",
				"rest_controller_class" => "WP_REST_Posts_Controller",
				"has_archive" => false,
				"show_in_menu" => true,
				"show_in_nav_menus" => true,
				"menu_icon" => "dashicons-portfolio",
				"delete_with_user" => false,
				"exclude_from_search" => false,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"rewrite" => [
					"slug" => $project_base,
					"with_front" => true
				],
				"query_var" => true,
				"supports" => [ "title", "editor", "thumbnail" ],
			);
			register_post_type( "project", $args );

			// Register category
			$labels = array(
				"name" => __( "Categories", "alone-addons" ),
				"singular_name" => __( "Category", "alone-addons" ),
				"menu_name" => __( "Categories", "alone-addons" ),
				"all_items" => __( "All Categories", "alone-addons" ),
			);

			$project_tax_permalinks = get_option( 'project_taxt_permalinks' );
			$project_tax_base = empty( $project_tax_permalinks['project_tax_base'] ) ? _x( 'project-category', 'slug', 'alone-addons' ) : $project_tax_permalinks['project_tax_base'];

			$args = array(
				"label" => __( "Categories", "alone-addons" ),
				"labels" => $labels,
				"public" => true,
				"publicly_queryable" => true,
				"hierarchical" => true,
				"show_ui" => true,
				"show_in_menu" => true,
				"show_in_nav_menus" => true,
				"query_var" => true,
				"rewrite" => [
					"slug" => $project_tax_base,
					"with_front" => true
				],
				"show_admin_column" => true,
				"show_in_rest" => true,
				"rest_base" => "project_category",
				"rest_controller_class" => "WP_REST_Terms_Controller",
				"show_in_quick_edit" => true,
			);
			register_taxonomy( "project_category", array( "project" ), $args );

			// Register tags
			$labels = array(
				"name" => __( "Tags", "alone-addons" ),
				"singular_name" => __( "Tag", "alone-addons" ),
				"menu_name" => __( "Tags", "alone-addons" ),
				"all_items" => __( "All Tags", "alone-addons" ),
			);

			$args = array(
				"label" => __( "Tags", "alone-addons" ),
				"labels" => $labels,
				"public" => true,
				"publicly_queryable" => true,
				"hierarchical" => false,
				"show_ui" => true,
				"show_in_menu" => true,
				"show_in_nav_menus" => true,
				"query_var" => true,
				"rewrite" => false,
				"show_admin_column" => false,
				"show_in_rest" => false,
				"rest_base" => "project_tag",
				"rest_controller_class" => "WP_REST_Terms_Controller",
				"show_in_quick_edit" => false,
			);
			register_taxonomy( "project_tag", array( "project" ), $args );

		}

		/**
		 * Register team CPT
		 */
		if ( ( ! post_type_exists( 'team' ) && ! get_option( $this->team_option ) ) ) {
			// Register post type
			$labels = array(
				"name" => __( "Teams", "alone-addons" ),
				"singular_name" => __( "Team", "alone-addons" )
			);

			$team_permalinks = get_option( 'team_permalinks' );
			$team_base = empty( $team_permalinks['team_base'] ) ? _x( 'team', 'slug', 'alone-addons' ) : $team_permalinks['team_base'];

			$args = array(
				"label" => __( "Team", "alone-addons" ),
				"labels" => $labels,
				"description" => "",
				"public" => true,
				"publicly_queryable" => true,
				"show_ui" => true,
				"show_in_rest" => true,
				"rest_base" => "",
				"rest_controller_class" => "WP_REST_Posts_Controller",
				"has_archive" => false,
				"show_in_menu" => true,
				"show_in_nav_menus" => true,
				"menu_icon" => "dashicons-groups",
				"delete_with_user" => false,
				"exclude_from_search" => false,
				"capability_type" => "post",
				"map_meta_cap" => true,
				"hierarchical" => false,
				"rewrite" => [
					"slug" => $team_base,
					"with_front" => true
				],
				"query_var" => true,
				"supports" => array( "title", "editor", "thumbnail" ),
			);
			register_post_type( "team", $args );

			// Register category
			$labels = array(
				"name" => __( "Categories", "alone-addons" ),
				"singular_name" => __( "Category", "alone-addons" ),
				"menu_name" => __( "Categories", "alone-addons" ),
				"all_items" => __( "All Categories", "alone-addons" ),
			);

			$team_tax_permalinks = get_option( 'team_taxt_permalinks' );
			$team_tax_base = empty( $team_tax_permalinks['team_tax_base'] ) ? _x( 'team-category', 'slug', 'alone-addons' ) : $team_tax_permalinks['team_tax_base'];

			$args = array(
				"label" => __( "Categories", "alone-addons" ),
				"labels" => $labels,
				"public" => true,
				"publicly_queryable" => true,
				"hierarchical" => true,
				"show_ui" => true,
				"show_in_menu" => true,
				"show_in_nav_menus" => true,
				"query_var" => true,
				"rewrite" => [
					"slug" => $team_tax_base,
					"with_front" => true
				],
				"show_admin_column" => true,
				"show_in_rest" => true,
				"rest_base" => "team_category",
				"rest_controller_class" => "WP_REST_Terms_Controller",
				"show_in_quick_edit" => true,
			);
			register_taxonomy( "team_category", array( "team" ), $args );

		}

		/**
		 * Add thumbnail support to tribe_organizer
		 */
		if ( class_exists( 'Tribe__Events__Main' ) ) {
			add_post_type_support( 'tribe_organizer', 'thumbnail' );
		}
	}

	/**
	 * Enqueue scripts
	 */
	public function enqueue_admin_scripts() {
		$screen = get_current_screen();

		if ( $screen->post_type == 'project' ) {
			if ( ! did_action( 'wp_enqueue_media' ) ) {
				wp_enqueue_media();
			}

			wp_enqueue_script( 'alone-meta-field-gallery', plugins_url( '/assets/js/meta-field-gallery.js', __FILE__ ), [ 'jquery' ], false, true );

		}


		wp_enqueue_style( 'alone-backend', plugins_url( '/assets/css/backend.css', __FILE__ ) );

	}

	/**
	 * Input field
	 */
	public function input_field( $label, $name, $value = '', $desc = '' ) {

		$label_html = $label ? '<label for="label_field">' .$label. '</label>' : '';
		$desc_html = $desc ? '<div class="desc-field">' . $desc . '</div>' : '';

		$html = '<div class="bt-field bt-field-input">
					' . $label_html . '
					<div class="bt-content">
						<input type="text" name="' . esc_attr($name) . '" value="' . esc_attr($value) . '" />
						' . $desc_html . '
					</div>
				</div>';

		printf($html);

	}

	/**
	 * Texarea field
	 */
	public function textarea_field( $label, $name, $value = '', $desc = '' ) {

		$label_html = $label ? '<label for="label_field">' .$label. '</label>' : '';
		$desc_html = $desc ? '<div class="desc-field">' . $desc . '</div>' : '';

		$html = '<div class="bt-field bt-field-input">
					' . $label_html . '
					<div class="bt-content">
						<textarea name="' . esc_attr($name) . '" rows="4" cols="50">' . $value . '</textarea>
						' . $desc_html . '
					</div>
				</div>';

		printf($html);

	}

	/**
	 * Select field
	 */
	public function select_field( $label, $name, $options, $value = '', $desc = '' ) {

		$label_html = $label ? '<label for="label_field">' .$label. '</label>' : '';
		$desc_html = $desc ? '<div class="desc-field">' . $desc . '</div>' : '';
		$opitons_html = '';

		if( ! empty( $options ) ) {
			foreach( $options as $key => $option ) {
				if( $value == $key ) {
					$opitons_html .= '<option value="' . esc_attr( $key ) . '" selected="selected">' . $option . '</option>';
				} else {
					$opitons_html .= '<option value="' . esc_attr( $key ) . '">' . $option . '</option>';
				}

			}

		}

		$html = '<div class="bt-field bt-field-select">
					' . $label_html . '
					<div class="bt-content">
						<select name="' . esc_attr($name) . '">
							' . $opitons_html . '
						</select>
						' . $desc_html . '
					</div>
				</div>';

		printf($html);

	}

	/**
	 * Gallery field
	 */
	public function gallery_field( $label, $name, $value = '', $desc = '' ) {

		$label_html = $label ? '<label for="label_field">' .$label. '</label>' : '';
		$desc_html = $desc ? '<div class="desc-field">' . $desc . '</div>' : '';

		/* array with image IDs for hidden field */
		$hidden = array();
		$images_html = '';

		$images = get_posts( array(
								'post_type' => 'attachment',
								'orderby' => 'post__in',
								'order' => 'ASC',
								'post__in' => explode(',',$value),
								'numberposts' => -1,
								'post_mime_type' => 'image'
							) );

		if( $images ) {
			foreach( $images as $image ) {
				$hidden[] = $image->ID;
				$image_src = wp_get_attachment_image_src( $image->ID, array( 80, 80 ) );
				$images_html .= '<li data-id="' . $image->ID .  '">
									<span style="background-image:url(' . $image_src[0] . ')"></span>
									<a href="#" class="btn-remove mtf-btn-remove">×</a>
								</li>';
			}

		}

		$html = '<div class="bt-field bt-field-gallery">
					' . $label_html . '
					<div class="bt-content">
						<ul class="image-gallery mtf-image-gallery">' . $images_html . '</ul>
						<div style="clear:both"></div>
						<input type="hidden" name="'.$name.'" value="' . join(',',$hidden) . '" />
						<a href="#" class="button btn-upload mtf-btn-upload">' . esc_html__( 'Add Images', 'alone-addons' ) . '</a>
						' . $desc_html . '
					</div>
				</div>';

		printf($html);
	}

	/**
	 * Render field
	 */
	public function render_meta_box_field( $options = array() ) {
		global $post;

		if( !empty( $options ) ) {
			foreach( $options as $option ) {
				$type = $option['type'] . '_field';

				$meta_value = get_post_meta($post->ID, $option['meta_key'], true);

				if( $type == 'input_field' || $type == 'textarea_field' || $type == 'gallery_field' ) {

					$this->$type( $option['label'], $option['meta_key'], $meta_value, $option['desc'] );

				} elseif( $type == 'select_field' ) {

					$this->$type( $option['label'], $option['meta_key'], $option['options'], $meta_value, $option['desc'] );

				}

			}
		}

	}

	/**
	 * Add custom fields for CPT
	 */
	public function add_custom_fields() {
		add_meta_box(
			'alone_gallery_box',
			esc_html__('Image Gallery', 'alone-addons'),
			array( $this, 'gallery_box_field_html' ),
			array( 'project' ),
			'side'
		);

		add_meta_box(
			'alone_give_posts_box',
			esc_html__('Form Settings', 'alone-addons'),
			array( $this, 'give_posts_box_field_html' ),
			array( 'give_posts_forms' ),
			'side'
		);

	}

	/**
	 * HTML code to display image gallery option
	 * for the image gallery box.
	 */
	public function gallery_box_options() {
		$options = array(
			array(
				'type' => 'gallery',
				'label' => false,
				'desc' => false,
				'meta_key' => 'bearsthems_gallery_field'
			),
		);

		return apply_filters( 'alone_meta_box_gallery_fields', $options );
	}

	public function gallery_box_field_html() {

		$options = $this->gallery_box_options();

		$this->render_meta_box_field( $options );

	}

	/**
	 * HTML code to display give_posts options
	 * for the give_posts box.
	 */
	public function give_posts_box_options() {
		$options = array(
			array(
				'type' => 'select',
				'label' => esc_html__( 'Style', 'alone-addons' ),
				'options' => array(
					''  => esc_html__( 'Default', 'alone-addons' ),
					'1' => esc_html__( 'Custom style 1', 'alone-addons' ),
					'2' => esc_html__( 'Custom style 2', 'alone-addons' ),
					'3' => esc_html__( 'Custom style 3', 'alone-addons' ),
					'4' => esc_html__( 'Custom style 4', 'alone-addons' ),
					'5' => esc_html__( 'Custom style 5', 'alone-addons' ),
				),
				'desc' => esc_html__( 'Select style display.', 'alone-addons' ),
				'meta_key' => 'give_posts_style_display_field'
			),
		);

		return apply_filters( 'alone_meta_box_give_posts_fields', $options );
	}

	public function give_posts_box_field_html() {

		$options = $this->give_posts_box_options();

		$this->render_meta_box_field( $options );

	}

	/**
	 * Save custom fields for CPT
	 */
	public function save_custom_fields( $post_id ) {
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
			return $post_id;

		require_once(ABSPATH . 'wp-admin/includes/screen.php');
		$screen = get_current_screen();

		if( empty( $screen ) ) {
			return;
		}

		if ( $screen->post_type == 'give_posts_forms' ) {

			$options = $this->give_posts_box_options();

			foreach( $options as $option ) {
				$meta_key = $option['meta_key'];
				$meta_val = isset( $_POST[$meta_key] ) ? $_POST[$meta_key] : '';

				update_post_meta( $post_id, $meta_key, $meta_val );
			}

		}

		return $post_id;
	}

	/**
	 * Add field in 'Settings' > 'Writing/Reading'
	 * for enabling CPT functionality.
	 */
	public function settings_api_init() {
		add_settings_section(
			'alone_cpt_section',
			'<span id="custom-post-type-options">' . esc_html__( 'Custom Post Type', 'alone-addons' ) . '</span>',
			array( $this, 'writing_section_html' ),
			'writing'
		);

		// Give CPT
		add_settings_field(
			$this->give_posts_option,
			'<span class="project-options">' . esc_html__( 'Give Posts', 'alone-addons' ) . '</span>',
			array( $this, 'disable_project_field_html' ),
			'writing',
			'alone_cpt_section'
		);
		register_setting(
			'writing',
			$this->give_posts_option,
			'intval'
		);

		add_settings_field(
			'give_posts_tax_slug',
			'<label for="give_posts_tax_slug">' . esc_html__( 'Give Post Category base', 'alone-addons' ) . '</label>',
			array( $this, 'give_posts_tax_slug_input' ),
			'permalink',
			'optional'
		);
		register_setting(
			'permalink',
			'give_posts_tax_slug',
			'sanitize_text_field'
		);

		// Project CPT
		add_settings_field(
			$this->project_option,
			'<span class="project-options">' . esc_html__( 'Projects', 'alone-addons' ) . '</span>',
			array( $this, 'disable_project_field_html' ),
			'writing',
			'alone_cpt_section'
		);
		register_setting(
			'writing',
			$this->project_option,
			'intval'
		);

		add_settings_field(
			'project_tax_slug',
			'<label for="project_tax_slug">' . esc_html__( 'Project Category base', 'alone-addons' ) . '</label>',
			array( $this, 'project_tax_slug_input' ),
			'permalink',
			'optional'
		);
		register_setting(
			'permalink',
			'project_tax_slug',
			'sanitize_text_field'
		);

		// Team CPT
		add_settings_field(
			$this->team_option,
			'<span class="team-options">' . esc_html__( 'Teams', 'alone-addons' ) . '</span>',
			array( $this, 'disable_team_field_html' ),
			'writing',
			'alone_cpt_section'
		);
		register_setting(
			'writing',
			$this->team_option,
			'intval'
		);

		add_settings_field(
			'team_tax_slug',
			'<label for="team_tax_slug">' . esc_html__( 'Team Category base', 'alone-addons' ) . '</label>',
			array( $this, 'team_tax_slug_input' ),
			'permalink',
			'optional'
		);
		register_setting(
			'permalink',
			'team_tax_slug',
			'sanitize_text_field'
		);

	}

	/**
	 * Show a give_posts tax slug input box.
	 */
	public function give_posts_tax_slug_input() {
		$give_posts_tax_permalinks = get_option( 'give_posts_tax_permalinks' );
		$give_posts_tax_base = isset( $give_posts_tax_permalinks['project_tax_base'] ) ? $give_posts_tax_permalinks['project_tax_base'] : '';

		?>
		<input name="give_posts_tax_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $give_posts_tax_base ); ?>" placeholder="<?php echo esc_attr_x( 'give_posts-category', 'slug', 'alone-addons' ) ?>" />
		<?php

	}

	/**
	 * Show a project tax slug input box.
	 */
	public function project_tax_slug_input() {
		$project_tax_permalinks = get_option( 'project_tax_permalinks' );
		$project_tax_base = isset( $project_tax_permalinks['project_tax_base'] ) ? $project_tax_permalinks['project_tax_base'] : '';

		?>
		<input name="project_tax_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $project_tax_base ); ?>" placeholder="<?php echo esc_attr_x( 'project-category', 'slug', 'alone-addons' ) ?>" />
		<?php

	}

	/**
	 * Show a team tax slug input box.
	 */
	public function team_tax_slug_input() {
		$team_tax_permalinks = get_option( 'team_tax_permalinks' );
		$team_tax_base = isset( $team_tax_permalinks['team_tax_base'] ) ? $team_tax_permalinks['team_tax_base'] : '';

		?>
		<input name="team_tax_slug" type="text" class="regular-text code" value="<?php echo esc_attr( $team_tax_base ); ?>" placeholder="<?php echo esc_attr_x( 'team-category', 'slug', 'alone-addons' ) ?>" />
		<?php

	}

	/**
	 * Save the settings.
	 */
	public function settings_save() {
		if ( ! is_admin() ) {
			return;
		}

		if ( ! $screen = get_current_screen() ) {
			return;
		}

		if ( 'options-permalink' != $screen->id ) {
			return;
		}

		// Give Post CPT
		$give_posts_tax_permalinks = get_option( 'give_posts_tax_permalinks' );

		if ( isset( $_POST['give_posts_tax_slug'] ) ) {
			$give_posts_tax_permalinks['give_posts_tax_base'] = $this->sanitize_permalink( trim( $_POST['give_posts_tax_slug'] ) );
		}

		update_option( 'give_posts_tax_permalinks', $give_posts_tax_permalinks );

		// Project CPT
		$project_tax_permalinks = get_option( 'project_tax_permalinks' );

		if ( isset( $_POST['project_tax_slug'] ) ) {
			$project_tax_permalinks['project_tax_base'] = $this->sanitize_permalink( trim( $_POST['project_tax_slug'] ) );
		}

		update_option( 'project_tax_permalinks', $project_tax_permalinks );

		// Team CPT
		$team_tax_permalinks = get_option( 'team_tax_permalinks' );

		if ( isset( $_POST['team_tax_slug'] ) ) {
			$team_tax_permalinks['team_tax_base'] = $this->sanitize_permalink( trim( $_POST['team_tax_slug'] ) );
		}

		update_option( 'team_tax_permalinks', $team_tax_permalinks );
	}

	/**
	 * Sanitize permalink
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	private function sanitize_permalink( $value ) {
		global $wpdb;

		$value = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $value );

		if ( is_wp_error( $value ) ) {
			$value = '';
		}

		$value = esc_url_raw( $value );
		$value = str_replace( 'http://', '', $value );

		return untrailingslashit( $value );
	}

	/**
	 * Add writing setting section
	 */
	public function writing_section_html() {
		?>
		<p>
			<?php esc_html_e( 'Use these settings to disable custom types of content on your site', 'alone-addons' ); ?>
		</p>
		<?php
	}

	/**
	 * HTML code to display a checkbox true/false option
	 * for the Give Post setting.
	 */
	public function disable_give_posts_field_html() {
		?>

		<label for="<?php echo esc_attr( $this->give_posts_option ); ?>">
			<input name="<?php echo esc_attr( $this->give_posts_option ); ?>"
				   id="<?php echo esc_attr( $this->give_posts_option ); ?>" <?php checked( get_option( $this->give_posts_option ), true ); ?>
				   type="checkbox" value="1" />
			<?php esc_html_e( 'Disable Give Post for this site.', 'alone-addons' ); ?>
		</label>

		<?php
	}

	/**
	 * HTML code to display a checkbox true/false option
	 * for the Project setting.
	 */
	public function disable_project_field_html() {
		?>

		<label for="<?php echo esc_attr( $this->project_option ); ?>">
			<input name="<?php echo esc_attr( $this->project_option ); ?>"
				   id="<?php echo esc_attr( $this->project_option ); ?>" <?php checked( get_option( $this->project_option ), true ); ?>
				   type="checkbox" value="1" />
			<?php esc_html_e( 'Disable Project for this site.', 'alone-addons' ); ?>
		</label>

		<?php
	}

	/**
	 * HTML code to display a checkbox true/false option
	 * for the Team setting.
	 */
	public function disable_team_field_html() {
		?>

		<label for="<?php echo esc_attr( $this->team_option ); ?>">
			<input name="<?php echo esc_attr( $this->team_option ); ?>"
				   id="<?php echo esc_attr( $this->team_option ); ?>" <?php checked( get_option( $this->team_option ), true ); ?>
				   type="checkbox" value="1" />
			<?php esc_html_e( 'Disable Team for this site.', 'alone-addons' ); ?>
		</label>

		<?php
	}

}

new Alone_Custom_Post_Type;
