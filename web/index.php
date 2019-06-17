<?php
// Tells WordPress to load the WordPress theme and output it.

define('WP_USE_THEMES', true);
// Loads the WordPress Environment and Template
//$wp_init_path = realpath( __DIR__ . '/../vendor/pantheon-systems/wordpress/wp-blog-header.php' );
//echo $wp_init_path;
require('./web/cms/wp-blog-header.php');
