<?php

// restrict fopen/include/require to our site only
ini_set('open_basedir', realpath(__DIR__.'/../'));

date_default_timezone_set('UTC');

set_error_handler(function($errno, $errstr, $errfile, $errline){
  
  switch($errno) {
    case E_WARNING: {
      return strpos($errstr, 'include(') === 0;
    }
  }
  
  return false;
});
