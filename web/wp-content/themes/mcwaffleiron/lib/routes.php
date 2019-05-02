<?php

require_once 'Waffleiron.php';

Routes::map('/', function() {
  $data = get_page_by_path('home');
  Waffleiron::run('page', array('data' => $data));
});
