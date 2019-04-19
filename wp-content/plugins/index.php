<?php
/*
  Plugin Name: McWaffleiron
  Plugin URI: https://pantheon.io/
  Description: MU Plugins: ACF, ACF to REST, ACF Quick Edit, Admin Cols, Utility
  Version: 1.0
  Author: cwahlfeldt
  Author URI: https://dev-mcwaffleiron.pantheonsite.io
*/

require_once('util/util.php');
//require_once('advanced-custom-fields-pro/acf.php');
//require_once('advanced-custom-fields-pro/pro/acf-pro.php');
require_once('acf-to-rest-api/class-acf-to-rest-api.php');
require_once('acf-quick-edit-fields/index.php');
require_once('wp-native-php-sessions/pantheon-sessions.php');
require_once('admin-columns-pro/admin-columns-pro.php');
include('util/acf/fields.php');
