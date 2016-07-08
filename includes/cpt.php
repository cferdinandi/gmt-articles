<?php

	/**
	 * Add custom post type
	 */
	function articles_add_custom_post_type() {

		$options = articles_get_theme_options();
		$labels = array(
			'name'               => _x( 'Articles', 'post type general name', 'articles' ),
			'singular_name'      => _x( 'Article', 'post type singular name', 'articles' ),
			'add_new'            => _x( 'Add New', 'articles', 'articles' ),
			'add_new_item'       => __( 'Add New Article', 'articles' ),
			'edit_item'          => __( 'Edit Article', 'articles' ),
			'new_item'           => __( 'New Article', 'articles' ),
			'all_items'          => __( 'All Articles', 'articles' ),
			'view_item'          => __( 'View Article', 'articles' ),
			'search_items'       => __( 'Search Articles', 'articles' ),
			'not_found'          => __( 'No articles found', 'articles' ),
			'not_found_in_trash' => __( 'No articles found in the Trash', 'articles' ),
			'parent_item_colon'  => '',
			'menu_name'          => __( 'Articles', 'articles' ),
		);
		$args = array(
			'labels'        => $labels,
			'description'   => 'Holds our articles and article-specific data',
			'public'        => true,
			// 'menu_position' => 5,
			'menu_icon'     => 'dashicons-format-aside',
			'supports'      => array(
				'title',
				'editor',
				'excerpt',
				'revisions',
				'thumbnail',
				'comments',
				'wpcom-markdown',
			),
			'has_archive'   => true,
			'taxonomies'    => array(
				'topic',
			),
			'rewrite'       => array(
				'slug' => $options['page_slug'],
			),
			'map_meta_cap'  => true,
		);
		register_post_type( 'gmt-articles', $args );
	}
	add_action( 'init', 'articles_add_custom_post_type' );



	/**
	 * Create custom "Topic" taxonomy for articles
	 */
	function articles_create_taxonomies() {
		$labels = array(
			'name'              => _x( 'Topics', 'taxonomy general name' ),
			'singular_name'     => _x( 'Topic', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Topics' ),
			'all_items'         => __( 'All Topics' ),
			'parent_item'       => __( 'Parent Topic' ),
			'parent_item_colon' => __( 'Parent Topic:' ),
			'edit_item'         => __( 'Edit Topic' ),
			'update_item'       => __( 'Update Topic' ),
			'add_new_item'      => __( 'Add New Topic' ),
			'new_item_name'     => __( 'New Topic Name' ),
			'menu_name'         => __( 'Topics' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'topic' ),
		);

		register_taxonomy( 'topic', array( 'gmt-articles' ), $args );

	}
	add_action( 'init', 'articles_create_taxonomies', 0 );