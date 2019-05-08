<?php
// Tells WordPress to load the WordPress theme and output it.

//$site_url = 'http' . '://' . $_SERVER['HTTP_HOST'] . '/';
//echo $site_url . 'wp/';
define('WP_USE_THEMES', true);
// Loads the WordPress Environment and Template
require( dirname( __FILE__ ) . '/wp/wp-blog-header.php' );
