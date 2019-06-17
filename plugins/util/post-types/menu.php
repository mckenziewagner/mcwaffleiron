<?php

/**
 * Registers the `menu` post type.
 */
function menu_init() {
	register_post_type( 'menu', array(
		'labels'                => array(
			'name'                  => __( 'Menus', 'util' ),
			'singular_name'         => __( 'Menu', 'util' ),
			'all_items'             => __( 'All Menus', 'util' ),
			'archives'              => __( 'Menu Archives', 'util' ),
			'attributes'            => __( 'Menu Attributes', 'util' ),
			'insert_into_item'      => __( 'Insert into menu', 'util' ),
			'uploaded_to_this_item' => __( 'Uploaded to this menu', 'util' ),
			'featured_image'        => _x( 'Featured Image', 'menu', 'util' ),
			'set_featured_image'    => _x( 'Set featured image', 'menu', 'util' ),
			'remove_featured_image' => _x( 'Remove featured image', 'menu', 'util' ),
			'use_featured_image'    => _x( 'Use as featured image', 'menu', 'util' ),
			'filter_items_list'     => __( 'Filter menus list', 'util' ),
			'items_list_navigation' => __( 'Menus list navigation', 'util' ),
			'items_list'            => __( 'Menus list', 'util' ),
			'new_item'              => __( 'New Menu', 'util' ),
			'add_new'               => __( 'Add New', 'util' ),
			'add_new_item'          => __( 'Add New Menu', 'util' ),
			'edit_item'             => __( 'Edit Menu', 'util' ),
			'view_item'             => __( 'View Menu', 'util' ),
			'view_items'            => __( 'View Menus', 'util' ),
			'search_items'          => __( 'Search menus', 'util' ),
			'not_found'             => __( 'No menus found', 'util' ),
			'not_found_in_trash'    => __( 'No menus found in trash', 'util' ),
			'parent_item_colon'     => __( 'Parent Menu:', 'util' ),
			'menu_name'             => __( 'Menus', 'util' ),
		),
		'public'                => true,
		'hierarchical'          => false,
		'show_ui'               => true,
		'show_in_nav_menus'     => true,
		'supports'              => array( 'title', 'editor' ),
		'has_archive'           => false,
		'rewrite'               => array('with_front' => false),
		'query_var'             => true,
		'menu_icon'             => 'dashicons-welcome-add-page',
		'show_in_rest'          => true,
		'rest_base'             => 'meal-menu',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );
}
add_action( 'init', 'menu_init' );

/* // change slug */
/* add_filter( 'register_post_type_args', function ( $args, $post_type ) { */
/*     if ( 'menu' === $post_type ) { */
/* 		echo '<script>console.log(' . json_encode($post_type) . ',' . json_encode($args) . ')</script>'; */
/*         $args['rewrite']['slug'] = 'menu'; */
/*     } */

/*     return $args; */
/* }, 10, 2 ); */


/**
 * Sets the post updated messages for the `menu` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `menu` post type.
 */
function menu_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['menu'] = array(
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Menu updated. <a target="_blank" href="%s">View menu</a>', 'util' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'util' ),
		3  => __( 'Custom field deleted.', 'util' ),
		4  => __( 'Menu updated.', 'util' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Menu restored to revision from %s', 'util' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Menu published. <a href="%s">View menu</a>', 'util' ), esc_url( $permalink ) ),
		7  => __( 'Menu saved.', 'util' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Menu submitted. <a target="_blank" href="%s">Preview menu</a>', 'util' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Menu scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview menu</a>', 'util' ),
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Menu draft updated. <a target="_blank" href="%s">Preview menu</a>', 'util' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'menu_updated_messages' );
