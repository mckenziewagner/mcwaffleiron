<?php
/**
 * mcwaffleiron functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mcwaffleiron
 */

if ( ! function_exists( 'mcwaffleiron_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mcwaffleiron_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on mcwaffleiron, use a find and replace
		 * to change 'mcwaffleiron' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'mcwaffleiron', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
    add_theme_support('post-thumbnails');
    add_image_size( '720', 720, 9999 );
    add_image_size( '320', 320, 9999 );

		// This theme uses wp_nav_menu() in one location.
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage')
    ]);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'mcwaffleiron_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'mcwaffleiron_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mcwaffleiron_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'mcwaffleiron_content_width', 640 );
}
add_action( 'after_setup_theme', 'mcwaffleiron_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mcwaffleiron_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'mcwaffleiron' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'mcwaffleiron' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'mcwaffleiron_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
//ini_set('xdebug.max_nesting_level', 9999);

//
// enqueue scripts/styles
add_action( 'wp_enqueue_scripts', function() {
  wp_enqueue_script('mcwaffleiron-script', get_template_directory_uri() . '/public/bundle.js');
	wp_enqueue_style('mcwaffleiron-style', get_template_directory_uri() . '/public/bundle.css');
});

//
// enqueue admin styles
add_action( 'admin_enqueue_scripts', function() {
    wp_enqueue_style( 'admin-style',get_template_directory_uri() . '/src/styles/admin.css');
});

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
//require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
//require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
//require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
*/

// defining the sub-directory so that it can be easily accessed from elsewhere as well.
/*define( 'WPSE_PAGE_TEMPLATE_SUB_DIR', 'page-templates' );

function wpse312159_page_template_add_subdir( $templates = array() ) {
    // Generally this doesn't happen, unless another plugin / theme does modifications
    // of their own. In that case, it's better not to mess with it again with our code.
    if( empty( $templates ) || ! is_array( $templates ) || count( $templates ) < 3 )
        return $templates;

    $page_tpl_idx = 0;
    if( $templates[0] === get_page_template_slug() ) {
        // if there is custom template, then our page-{slug}.php template is at the next index 
        $page_tpl_idx = 1;
    }

    $page_tpls = array( WPSE_PAGE_TEMPLATE_SUB_DIR . '/' . $templates[$page_tpl_idx] );

    // As of WordPress 4.7, the URL decoded page-{$slug}.php template file is included in the
    // page template hierarchy just before the URL encoded page-{$slug}.php template file.
    // Also, WordPress always keeps the page id different from page slug. So page-{slug}.php will
    // always be different from page-{id}.php, even if you try to input the {id} as {slug}.
    // So this check will work for WordPress versions prior to 4.7 as well.
    if( $templates[$page_tpl_idx] === urldecode( $templates[$page_tpl_idx + 1] ) ) {
        $page_tpls[] = WPSE_PAGE_TEMPLATE_SUB_DIR . '/' . $templates[$page_tpl_idx + 1];
    }

    array_splice( $templates, $page_tpl_idx, 0, $page_tpls );

    return $templates;
}
add_filter( 'page_template_hierarchy', 'wpse312159_page_template_add_subdir' );
 */
// helper function for new menu items
function _custom_nav_menu_item( $title, $url, $order, $parent = 0 ){
  $item = new stdClass();
  $item->ID = 1000000 + $order + $parent;
  $item->db_id = $item->ID;
  $item->title = $title;
  $item->url = $url;
  $item->menu_order = $order;
  $item->menu_item_parent = $parent;
  $item->type = '';
  $item->object = '';
  $item->object_id = '';
  $item->classes = array();
  $item->target = '';
  $item->attr_title = '';
  $item->description = '';
  $item->xfn = '';
  $item->status = '';
  return $item;
}

// add taxonomy to events menu
add_filter( 'wp_get_nav_menu_items', function($items, $menu) {
  if ($menu->slug == 'primary-navigation') {
    foreach ($items as $item) {
      if ($item->title == 'Events') {
        $event_types = (array)get_terms('event_types');
        $reversed = array_reverse($event_types);
        $pos = 1;
        foreach ($reversed as $type) {
          $items[] = _custom_nav_menu_item($type->name, '/events/' . $type->slug, $pos++, $item->ID);
        }
      }
    }
  }

  return $items;
}, 20, 2);

function format_phone($data) {
  if (preg_match('/(\d{3})(\d{3})(\d{4})$/', $data, $matches)) {
    $result = $matches[1] . '.' .$matches[2] . '.' . $matches[3];
    return $result;
  }
}

function hex_to_rgba($hex, $alpha = false) {
  $hex      = str_replace('#', '', $hex);
  $length   = strlen($hex);
  $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
  $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
  $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
  if ( $alpha ) {
    $rgb['a'] = $alpha;
  }
  return 'rgba(' . $rgb['r'] . ', ' . $rgb['g'] . ', ' . $rgb['b'] . ', ' . $rgb['a'] ?? 1 . ')';
}

function add_async_attribute($tag, $handle) {
   // add script handles to the array below
   $scripts_to_async = array('mcwaffleiron-script');
   
   foreach($scripts_to_async as $async_script) {
      if ($async_script === $handle) {
         return str_replace(' src', ' async="async" src', $tag);
      }
   }
   return $tag;
}
add_filter('script_loader_tag', 'add_async_attribute', 10, 2);
//require_once('lib/routes.php');
