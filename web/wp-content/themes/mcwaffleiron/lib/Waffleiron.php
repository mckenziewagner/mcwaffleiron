<?php

$vend_path = realpath(__DIR__ . '/../../../../../vendor');
require_once $vend_path . '/autoload.php';

class Waffleiron {
  public static function run($template, $data = array('data' => array(
    'data0',
    'data1',
    'data2' => array('nested'),
    'data3',
    'data4',
    'data5' => true,
    'data6',
    'data7' => 'data can be any php type',
  ))) {
    $views = realpath(__DIR__ . '/../src/views');
    $cache = wp_upload_dir()['basedir'] . '/cache';
    $blade = new eftec\bladeone\BladeOne($views,$cache,eftec\bladeone\BladeOne::MODE_AUTO);
    echo $blade->run($template, $data);
  }
}
