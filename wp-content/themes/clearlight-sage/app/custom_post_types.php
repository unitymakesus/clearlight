<?php

namespace App;

/**
 * This file adds custom post types to the theme.
 */

add_action( 'init', function() {
	register_post_type( 'gallery',
		array('labels' => array(
				'name' => 'Galleries',
				'singular_name' => 'Gallery',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Gallery',
				'edit' => 'Edit',
				'edit_item' => 'Edit Gallery',
				'new_item' => 'New Gallery',
				'view_item' => 'View Gallery',
				'search_items' => 'Search Galleries',
				'not_found' =>  'Nothing found in the Database.',
				'not_found_in_trash' => 'Nothing found in Trash',
				'parent_item_colon' => ''
			), /* end of arrays */
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'menu_position' => 8,
			'menu_icon' => 'dashicons-images-alt',
			'capability_type' => 'page',
			'hierarchical' => true,
			'supports' => array( 'title', 'editor', 'revisions', 'page-attributes', 'thumbnail' ),
			'public' => true,
			'has_archive' => false,
			'rewrite' => true,
			'query_var' => true
		)
	);
});
