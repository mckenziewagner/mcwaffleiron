<?php

require_once 'Waffleiron.php';
//use Spatie\Ssr\Renderer;
//use Spatie\Ssr\Engines;

Routes::map('/', function() {
  $data = get_page_by_path('home');
  Waffleiron::run('page', array('data' => $data));
});

/* Routes::map('/testing', function() { */
/*  // $data = get_page_by_path('home'); */
/*   $engine = new V8(); */
/*   $renderer = new Renderer($engine); */
/*   echo $renderer */
/*     ->entry(__DIR__.'../src/views/app/public/bundle.js') */
/*     ->render(); */
/* }); */
