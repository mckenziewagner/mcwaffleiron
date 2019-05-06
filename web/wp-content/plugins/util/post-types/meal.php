<?php

/**
 * Registers the `meal` post type.
 */
function meal_init() {
	register_post_type( 'meal', array(
		'labels'                => array(
			'name'                  => __( 'Meals', 'util' ),
			'singular_name'         => __( 'Meal', 'util' ),
			'all_items'             => __( 'All Meals', 'util' ),
			'archives'              => __( 'Meal Archives', 'util' ),
			'attributes'            => __( 'Meal Attributes', 'util' ),
			'insert_into_item'      => __( 'Insert into meal', 'util' ),
			'uploaded_to_this_item' => __( 'Uploaded to this meal', 'util' ),
			'featured_image'        => _x( 'Featured Image', 'meal', 'util' ),
			'set_featured_image'    => _x( 'Set featured image', 'meal', 'util' ),
			'remove_featured_image' => _x( 'Remove featured image', 'meal', 'util' ),
			'use_featured_image'    => _x( 'Use as featured image', 'meal', 'util' ),
			'filter_items_list'     => __( 'Filter meals list', 'util' ),
			'items_list_navigation' => __( 'Meals list navigation', 'util' ),
			'items_list'            => __( 'Meals list', 'util' ),
			'new_item'              => __( 'New Meal', 'util' ),
			'add_new'               => __( 'Add New', 'util' ),
			'add_new_item'          => __( 'Add New Meal', 'util' ),
			'edit_item'             => __( 'Edit Meal', 'util' ),
			'view_item'             => __( 'View Meal', 'util' ),
			'view_items'            => __( 'View Meals', 'util' ),
			'search_items'          => __( 'Search meals', 'util' ),
			'not_found'             => __( 'No meals found', 'util' ),
			'not_found_in_trash'    => __( 'No meals found in trash', 'util' ),
			'parent_item_colon'     => __( 'Parent Meal:', 'util' ),
			'menu_name'             => __( 'Meals', 'util' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => false,
		'rewrite'               => array('with_front' => false),
		'query_var'             => true,
		'menu_icon'             => 'dashicons-carrot',
		'show_in_rest'          => true,
		'rest_base'             => 'meal',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	));

  // create taxonomy for meals
  register_taxonomy('meal_types', array('meal'), array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => false,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Meal Types', 'taxonomy general name' ),
      'singular_name' => _x( 'Meal Type', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Meal Types' ),
      'all_items' => __( 'All Meal Types' ),
      'parent_item' => __( 'Parent Meal Types' ),
      'parent_item_colon' => __( 'Parent Meal Type:' ),
      'edit_item' => __( 'Edit Meal Type' ),
      'update_item' => __( 'Update Meal Type' ),
      'add_new_item' => __( 'Add New Meal Type' ),
      'new_item_name' => __( 'New Meal Type Name' ),
      'menu_name' => __( 'Meal Types' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'meal-type', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => false, // This will allow URL's like "/locations/boston/cambridge/"
      'query_var' => true,
  		'show_in_rest' => true,
  		'rest_base' => 'meal_type',
  		'rest_controller_class' => 'WP_REST_Terms_Controller'
    ),
  ));

  // create taxonomy for descrtor like 'spicy' or 'gluten free'
  register_taxonomy('meal_descriptor', array('meal'), array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => false,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Meal Descriptors', 'taxonomy general name' ),
      'singular_name' => _x( 'Meal Descriptor', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Meal Descriptors' ),
      'all_items' => __( 'All Meal Descriptors' ),
      'parent_item' => __( 'Parent Meal Descriptors' ),
      'parent_item_colon' => __( 'Parent Meal Descriptor:' ),
      'edit_item' => __( 'Edit Meal Descriptor' ),
      'update_item' => __( 'Update Meal Descriptor' ),
      'add_new_item' => __( 'Add New Meal Descriptor' ),
      'new_item_name' => __( 'New Meal Descriptor Name' ),
      'menu_name' => __( 'Meal Descriptors' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'meal-descriptors', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => false, // This will allow URL's like "/locations/boston/cambridge/"
      'query_var' => true,
  		'show_in_rest' => true,
  		'rest_base' => 'meal_descriptor',
  		'rest_controller_class' => 'WP_REST_Terms_Controller'
    ),
  ));
}
add_action( 'init', 'meal_init' );

/**
 * Sets the post updated messages for the `meal` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `meal` post type.
 */
function meal_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['meal'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Meal updated. <a target="_blank" href="%s">View meal</a>', 'util' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'util' ),
		3  => __( 'Custom field deleted.', 'util' ),
		4  => __( 'Meal updated.', 'util' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Meal restored to revision from %s', 'util' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Meal published. <a href="%s">View meal</a>', 'util' ), esc_url( $permalink ) ),
		7  => __( 'Meal saved.', 'util' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Meal submitted. <a target="_blank" href="%s">Preview meal</a>', 'util' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Meal scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview meal</a>', 'util' ),
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Meal draft updated. <a target="_blank" href="%s">Preview meal</a>', 'util' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'meal_updated_messages' );
