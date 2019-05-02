<?php
/*
 * Routes are better than template heirarchy... sorry wordpress
 */

$vend_path = realpath( __DIR__ . '/../../../../../vendor' );
$loader = require_once $vend_path . '/autoload.php';

Use eftec\bladeone\BladeOne as Bladeone;
Use upstatement\routes\Routes as Routes;

$views = realpath(__DIR__ . '/../src/views'); // it uses the folder /views to read the templates
$cache = wp_upload_dir()['basedir'] . '/cache'; // it uses the folder /cache to compile the result. 
$blade = new BladeOne($views,$cache,BladeOne::MODE_AUTO);

Routes::map('events/:event', function($params) {
  echo json_encode($params);
});

// mock template heirarchy
$template = false;
if ( is_embed() && $template                 = 'embed' ) :
elseif ( is_404() && $template               = '404' ) :
elseif ( is_search() && $template            = 'search' ) :
elseif ( is_front_page() && $template        = 'page' ) :
elseif ( is_home() && $template              = 'page' ) :
elseif ( is_post_type_archive() && $template = 'post_type_archive' ) :
elseif ( is_tax() && $template               = 'tax' ) :
elseif ( is_attachment() && $template        = 'attachment' ) :
elseif ( is_single() && $template            = 'single' ) :
elseif ( is_page() && $template              = 'page' ) :
elseif ( is_singular() && $template          = 'singular' ) :
elseif ( is_category() && $template          = 'category' ) :
elseif ( is_tag() && $template               = 'tag' ) :
elseif ( is_author() && $template            = 'author' ) :
elseif ( is_date() && $template              = 'date' ) :
elseif ( is_product() && $template           = 'product' ) :
elseif ( is_archive() && $template           = 'archive' ) :
else :
  $template                                  = 'page';
endif;
if ($template === 'tax') {
  $term = get_queried_object()->taxonomy;
  $template = str_replace('_', '-', $term);
}
if ($template === 'single') {
  $type = get_post_type(get_the_ID());
  if ($type == 'product') {$template = 'product';}
}
if ($template === 'product-cat') {
  $template = 'products';
}
//echo $template;

// render template
echo $blade->run($template);
