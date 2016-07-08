<?php

/**
 * Theme Options v1.1.0
 * Adjust theme settings from the admin dashboard.
 * Find and replace `YourTheme` with your own namepspacing.
 *
 * Created by Michael Fields.
 * https://gist.github.com/mfields/4678999
 *
 * Forked by Chris Ferdinandi
 * http://gomakethings.com
 *
 * Free to use under the MIT License.
 * http://gomakethings.com/mit/
 */


	/**
	 * Theme Options Fields
	 * Each option field requires its own uniquely named function. Select options and radio buttons also require an additional uniquely named function with an array of option choices.
	 */

	function articles_settings_field_page_slug() {
		$options = articles_get_theme_options();
		?>
		<input type="text" name="articles_theme_options[page_slug]" id="page_slug" value="<?php echo esc_attr( $options['page_slug'] ); ?>" />
		<label class="description" for="page_slug"><?php _e( 'The articles page slug', 'articles' ); ?></label>
		<?php
	}

	function articles_settings_field_page_title() {
		$options = articles_get_theme_options();
		?>
		<input type="text" name="articles_theme_options[page_title]" id="page_title" value="<?php echo esc_attr( $options['page_title'] ); ?>" />
		<label class="description" for="page_title"><?php _e( 'The articles archive page title', 'articles' ); ?></label>
		<?php
	}

	function articles_settings_field_page_hide_title() {
		$options = articles_get_theme_options();
		?>
		<input type="checkbox" name="articles_theme_options[page_hide_title]" id="page_hide_title" <?php checked( 'on', $options['page_hide_title'] ); ?>>
		<label class="description" for="page_hide_title"><?php _e( 'Hide "all articles" page title visually', 'keel' ); ?></label>
		<?php
	}

	function articles_settings_field_page_text() {
		$options = articles_get_theme_options();
		?>
		<textarea class="large-text" name="articles_theme_options[page_text]" id="page_text" cols="50" rows="10"><?php echo stripslashes( esc_textarea( articles_get_jetpack_markdown( $options, 'page_text' ) ) ); ?></textarea>
		<label class="description" for="page_text"><?php _e( 'The articles archive page text', 'articles' ); ?></label>
		<?php
	}

	function articles_settings_field_article_message() {
		$options = articles_get_theme_options();
		?>
		<textarea class="large-text" name="articles_theme_options[article_message]" id="article_message" cols="50" rows="10"><?php echo stripslashes( esc_textarea( articles_get_jetpack_markdown( $options, 'article_message' ) ) ); ?></textarea>
		<label class="description" for="page_text"><?php _e( 'Message to display after individual articles', 'articles' ); ?></label>
		<?php
	}



	/**
	 * Theme Option Defaults & Sanitization
	 * Each option field requires a default value under articles_get_theme_options(), and an if statement under articles_theme_options_validate();
	 */

	// Get the current options from the database.
	// If none are specified, use these defaults.
	function articles_get_theme_options() {
		$saved = (array) get_option( 'articles_theme_options' );
		$defaults = array(
			'page_slug' => 'articles',
			'page_title' => 'Articles',
			'page_hide_title' => 'off',
			'page_text' => '',
			'page_text_markdown' => '',
			'article_message' => '',
			'article_message_markdown' => '',
		);

		$defaults = apply_filters( 'articles_default_theme_options', $defaults );

		$options = wp_parse_args( $saved, $defaults );
		$options = array_intersect_key( $options, $defaults );

		return $options;
	}

	// Sanitize and validate updated theme options
	function articles_theme_options_validate( $input ) {
		$output = array();

		if ( isset( $input['page_slug'] ) && ! empty( $input['page_slug'] ) )
			$output['page_slug'] = wp_filter_nohtml_kses( $input['page_slug'] );

		if ( isset( $input['page_title'] ) && ! empty( $input['page_title'] ) )
			$output['page_title'] = wp_filter_nohtml_kses( $input['page_title'] );


		if ( isset( $input['page_hide_title'] ) )
			$output['page_hide_title'] = 'on';

		if ( isset( $input['page_text'] ) && ! empty( $input['page_text'] ) ) {
			$output['page_text'] = wp_filter_post_kses( articles_process_jetpack_markdown( $input['page_text'] ) );
			$output['page_text_markdown'] = wp_filter_post_kses( $input['page_text'] );
		}

		if ( isset( $input['article_message'] ) && ! empty( $input['article_message'] ) ) {
			$output['article_message'] = wp_filter_post_kses( articles_process_jetpack_markdown( $input['article_message'] ) );
			$output['article_message_markdown'] = wp_filter_post_kses( $input['article_message'] );
		}

		return apply_filters( 'articles_theme_options_validate', $output, $input );
	}



	/**
	 * Theme Options Menu
	 * Each option field requires its own add_settings_field function.
	 */

	// Create theme options menu
	// The content that's rendered on the menu page.
	function articles_theme_options_render_page() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Articles Options', 'articles' ); ?></h2>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'articles_options' );
					do_settings_sections( 'articles_options' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	// Register the theme options page and its fields
	function articles_theme_options_init() {

		// Register a setting and its sanitization callback
		// register_setting( $option_group, $option_name, $sanitize_callback );
		// $option_group - A settings group name.
		// $option_name - The name of an option to sanitize and save.
		// $sanitize_callback - A callback function that sanitizes the option's value.
		register_setting( 'articles_options', 'articles_theme_options', 'articles_theme_options_validate' );


		// Register our settings field group
		// add_settings_section( $id, $title, $callback, $page );
		// $id - Unique identifier for the settings section
		// $title - Section title
		// $callback - // Section callback (we don't want anything)
		// $page - // Menu slug, used to uniquely identify the page. See articles_theme_options_add_page().
		add_settings_section( 'general', null,  '__return_false', 'articles_options' );


		// Register our individual settings fields
		// add_settings_field( $id, $title, $callback, $page, $section );
		// $id - Unique identifier for the field.
		// $title - Setting field title.
		// $callback - Function that creates the field (from the Theme Option Fields section).
		// $page - The menu page on which to display this field.
		// $section - The section of the settings page in which to show the field.
		add_settings_field( 'page_slug', __( 'Page Slug', 'articles' ), 'articles_settings_field_page_slug', 'articles_options', 'general' );
		add_settings_field( 'page_title', __( 'Page Title', 'articles' ), 'articles_settings_field_page_title', 'articles_options', 'general' );
		add_settings_field( 'page_hide_title', __( 'Hide Page Title', 'articles' ), 'articles_settings_field_page_hide_title', 'articles_options', 'general' );
		add_settings_field( 'page_text', __( 'Page Text', 'articles' ), 'articles_settings_field_page_text', 'articles_options', 'general' );
		add_settings_field( 'article_message', __( 'Article Message', 'articles' ), 'articles_settings_field_article_message', 'articles_options', 'general' );
	}
	add_action( 'admin_init', 'articles_theme_options_init' );

	// Add the theme options page to the admin menu
	// Use add_theme_page() to add under Appearance tab (default).
	// Use add_menu_page() to add as it's own tab.
	// Use add_submenu_page() to add to another tab.
	function articles_theme_options_add_page() {

		// add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		// add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		// $page_title - Name of page
		// $menu_title - Label in menu
		// $capability - Capability required
		// $menu_slug - Used to uniquely identify the page
		// $function - Function that renders the options page
		// $theme_page = add_theme_page( __( 'Articles Options', 'articles' ), __( 'Options', 'articles' ), 'edit_theme_options', 'articles_options', 'articles_theme_options_render_page' );

		// $theme_page = add_menu_page( __( 'Theme Options', 'articles' ), __( 'Theme Options', 'articles' ), 'edit_theme_options', 'articles_options', 'articles_theme_options_render_page' );
		$theme_page = add_submenu_page( 'edit.php?post_type=gmt-articles', __( 'Articles Options', 'articles' ), __( 'Options', 'articles' ), 'edit_theme_options', 'articles_options', 'articles_theme_options_render_page' );
	}
	add_action( 'admin_menu', 'articles_theme_options_add_page' );



	// Restrict access to the theme options page to admins
	function articles_option_page_capability( $capability ) {
		return 'edit_theme_options';
	}
	add_filter( 'option_page_capability_articles_options', 'articles_option_page_capability' );
