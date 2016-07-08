<?php

	/**
	 * Add custom post type
	 */
	function events_add_custom_post_type() {

		$options = events_get_theme_options();
		$labels = array(
			'name'               => _x( 'Events', 'post type general name', 'events' ),
			'singular_name'      => _x( 'Event', 'post type singular name', 'events' ),
			'add_new'            => _x( 'Add New', 'events', 'events' ),
			'add_new_item'       => __( 'Add New Event', 'events' ),
			'edit_item'          => __( 'Edit Event', 'events' ),
			'new_item'           => __( 'New Event', 'events' ),
			'all_items'          => __( 'All Events', 'events' ),
			'view_item'          => __( 'View Event', 'events' ),
			'search_items'       => __( 'Search Events', 'events' ),
			'not_found'          => __( 'No events found', 'events' ),
			'not_found_in_trash' => __( 'No events found in the Trash', 'events' ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Events', 'events' ),
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our events and event-specific data',
			'public'        => true,
			// 'menu_position' => 5,
			'menu_icon'     => 'dashicons-calendar-alt',
			'supports'      => array(
				'title',
				'editor',
				// 'excerpt',
				'revisions',
				'wpcom-markdown',
			),
			'has_archive'   => true,
			'rewrite' => array(
				'slug' => $options['page_slug'],
			),
			'map_meta_cap'  => true,
		);
		register_post_type( 'gmt-events', $args );
	}
	add_action( 'init', 'events_add_custom_post_type' );