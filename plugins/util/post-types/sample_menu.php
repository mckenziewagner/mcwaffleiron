<?php

/**
 * Registers the `sample_menu` post type.
 */
function sample_menu_init() {
	register_post_type( 'sample_menu', array(
		'labels'                => array(
			'name'                  => __( 'Sample Menus', 'util' ),
			'singular_name'         => __( 'Sample Menu', 'util' ),
			'all_items'             => __( 'All Sample Menus', 'util' ),
			'archives'              => __( 'Sample Menu Archives', 'util' ),
			'attributes'            => __( 'Sample Menu Attributes', 'util' ),
			'insert_into_item'      => __( 'Insert into sample Menu', 'util' ),
			'uploaded_to_this_item' => __( 'Uploaded to this sample Menu', 'util' ),
			'featured_image'        => _x( 'Featured Image', 'sample-Menu', 'util' ),
			'set_featured_image'    => _x( 'Set featured image', 'sample-Menu', 'util' ),
			'remove_featured_image' => _x( 'Remove featured image', 'sample-Menu', 'util' ),
			'use_featured_image'    => _x( 'Use as featured image', 'sample-Menu', 'util' ),
			'filter_items_list'     => __( 'Filter sample Menus list', 'util' ),
			'items_list_navigation' => __( 'Sample Menus list navigation', 'util' ),
			'items_list'            => __( 'Sample Menus list', 'util' ),
			'new_item'              => __( 'New Sample Menu', 'util' ),
			'add_new'               => __( 'Add New', 'util' ),
			'add_new_item'          => __( 'Add New Sample Menu', 'util' ),
			'edit_item'             => __( 'Edit Sample Menu', 'util' ),
			'view_item'             => __( 'View Sample Menu', 'util' ),
			'view_items'            => __( 'View Sample Menus', 'util' ),
			'search_items'          => __( 'Search sample Menus', 'util' ),
			'not_found'             => __( 'No sample Menus found', 'util' ),
			'not_found_in_trash'    => __( 'No sample Menus found in trash', 'util' ),
			'parent_item_colon'     => __( 'Parent Sample Menu:', 'util' ),
			'menu_name'             => __( 'Sample Menus', 'util' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => 'events',
		'rewrite'               => array('slug' => 'events/sample-menus', 'with_front' => false),
		'query_var'             => true,
		'menu_icon'             => 'dashicons-pressthis',
		'show_in_rest'          => true,
		'rest_base'             => 'sample-menu',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	));

	// create taxonomy for meals
	register_taxonomy('event_types', 'sample_menu', array(
	// Hierarchical taxonomy (like categories)
	'hierarchical' => false,
	'show_admin_column' => true,
	'show_in_quick_edit' => true,
	'sort' => true,
	// This array of options controls the labels displayed in the WordPress Admin UI
	'labels' => array(
	  'name' => _x( 'Event Types', 'taxonomy general name' ),
	  'singular_name' => _x( 'Event Type', 'taxonomy singular name' ),
	  'search_items' =>  __( 'Search Event Types' ),
	  'all_items' => __( 'All Event Types' ),
	  'parent_item' => __( 'Parent Event Types' ),
	  'parent_item_colon' => __( 'Parent Event Type:' ),
	  'edit_item' => __( 'Edit Event Type' ),
	  'update_item' => __( 'Update Event Type' ),
	  'add_new_item' => __( 'Add New Event Type' ),
	  'new_item_name' => __( 'New Event Type Name' ),
	  'menu_name' => __( 'Event Types' ),
	),
	// Control the slugs used for this taxonomy
	'rewrite' => array(
	  'slug' => 'events', // This controls the base slug that will display before each term
	  'with_front' => false, // Don't display the category base before "/locations/"
	  'hierarchical' => false, // This will allow URL's like "/locations/boston/cambridge/"
	  'query_var' => true,
	  'show_in_rest' => true,
		'rest_base' => 'meal_type',
		'rest_controller_class' => 'WP_REST_Terms_Controller'
	  ),
	));
}
add_action( 'init', 'sample_menu_init' );

function wpa_show_permalinks( $post_link, $post ){
    if ( is_object( $post ) && $post->post_type == 'sample_menu' ){
        $terms = wp_get_object_terms( $post->ID, 'event_types' );
        if( $terms ){
            return str_replace( '%event_type%' , $terms[0]->slug , $post_link );
        }
    }
    return $post_link;
}
//add_filter( 'post_type_link', 'wpa_show_permalinks', 1, 2 );

/**
 * Sets the post updated messages for the `sample_menu` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `sample_menu` post type.
 */
function sample_menu_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['sample-menu'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Sample Menu updated. <a target="_blank" href="%s">View sample Menu</a>', 'util' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'util' ),
		3  => __( 'Custom field deleted.', 'util' ),
		4  => __( 'Sample Menu updated.', 'util' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Sample Menu restored to revision from %s', 'util' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Sample Menu published. <a href="%s">View sample Menu</a>', 'util' ), esc_url( $permalink ) ),
		7  => __( 'Sample Menu saved.', 'util' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Sample Menu submitted. <a target="_blank" href="%s">Preview sample Menu</a>', 'util' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Sample Menu scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview sample Menu</a>', 'util' ),
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Sample Menu draft updated. <a target="_blank" href="%s">Preview sample Menu</a>', 'util' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'sample_menu_updated_messages' );

/* $post_type = 'sample_menu'; */
/* add_filter( "manage_taxonomies_for_{$post_type}_sortable_columns", function() { */
/* 	$default = array( */
/* 		'title'    => 'title', */
/* 		'event_type'   => 'parent', */
/* 	); */

/* 	retrun $default */
/* }); */
