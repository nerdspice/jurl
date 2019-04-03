<?php

// composer-based autoloader
@include_once(__DIR__.'/../vendor/autoload.php');

// our custom autoloader
spl_autoload_register(function($cls){
  $cls  = str_replace('\\', '/', $cls);
  $path = __DIR__.'/../modules/';
  $file = $path.$cls.'.php';
  include($file);
}, true, true);
