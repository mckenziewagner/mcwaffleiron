<?php
/**
 * Plugin Name:     Util
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          YOUR NAME HERE
 * Author URI:      YOUR SITE HERE
 * Text Domain:     util
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Util
 */

// include post types
require('post-types/meal.php');
require('post-types/menu.php');
require('post-types/sample_menu.php');

/*
function delete_post_type(){
    unregister_post_type( 'sample_menu' );
}
add_action('init','delete_post_type');
*/

// set options page
if (function_exists('acf_add_options_page')) {
	acf_add_options_page();
}

// change name of products to boxed meals
add_filter('woocommerce_register_post_type_product', function($args) {
  $labels = array(
    'name'               => __('To-Go', 'togo'),
    'singular_name'      => __('To-Go', 'togo'),
    'menu_name'          => _x('To-Go', 'Admin menu name', 'togo'),
    'add_new'            => __('Add To-Go', 'togo'),
    'add_new_item'       => __('Add New To-Go', 'togo'),
    'edit'               => __('Edit', 'togo'),
    'edit_item'          => __('Edit To-Go', 'togo'),
    'new_item'           => __('New To-Go', 'togo'),
    'view'               => __('View To-Go', 'togo'),
    'view_item'          => __('View To-Go', 'togo'),
    'search_items'       => __('Search To-Go', 'togo'),
    'not_found'          => __('No To-Go found', 'togo'),
    'not_found_in_trash' => __('No To-Go found in trash', 'togo'),
    'parent'             => __('Parent To-Go', 'togo')
  );

  $args['labels'] = $labels;
  $args['description'] = __('Add a new classic to-go to be sold on the site.', 'togo');
  return $args;
});

add_action('admin_menu', function() {
  remove_menu_page('edit.php');
  remove_menu_page('edit-comments.php');
});

// reorder the menu
add_filter('menu_order', function($menu_ord) {
  if (!$menu_ord) return true;

  return array(
    'index.php', // Dashboard
    'separator1', // First separator
    'upload.php',
    'edit.php?post_type=page', // Pages
    'edit.php?post_type=meal', // Pages
    'edit.php?post_type=menu', // Pages
    'edit.php?post_type=sample_menu', // Pages
    'edit.php?post_type=product', // Pages
    'separator2', // First separator
    'themes.php',
    'plugins.php',
    'users.php',
    'tools.php',
    'options-general.php',
    'separator3',
    'separator4',
    'edit.php?post_type=acf-field-group', // Pages
    'edit.php?post_type=shop_order' // Pages
  );
});

add_action('save_post_product', function($post_id) {
  if (!(get_field('_price', $post_id))) {
    return;
  }

  $price = get_field('_price', $post_id);
  update_field('_regular_price', $price, $post_id);
}, 100);

add_action( 'admin_enqueue_scripts', function() {
  wp_enqueue_style( 'admin_css', plugin_dir_url(__FILE__) . 'styles/admin.css', false, '1.0.0' );
});

function filter_plugin_updates( $value ) {
    unset( $value->response['akismet/akismet.php'] );
    return $value;
}
add_filter('site_transient_update_plugins', 'filter_plugin_updates');

// Remove update notifications
function remove_update_notifications( $value ) {

    if ( isset( $value ) && is_object( $value ) ) {
		// remove for admin colmuns pro
        unset( $value->response[ 'admin-columns-pro/admin-columns-pro.php' ] );
    }

    return $value;
}
add_filter( 'site_transient_update_plugins', 'remove_update_notifications' );
