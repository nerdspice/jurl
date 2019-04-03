<?php

namespace Zodiac\Utilities;

class HTTP {
  
  public static function isRequestMethod($method) {
    return strtolower(trim(@$_SERVER['REQUEST_METHOD'])) === strtolower(trim($method));
  }
  
  public static function cacheOff() {
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
  }
  
  public static function redirect($to, $status = 302) {
    @ob_clean();
    switch($status) {
      case 301: header('HTTP/1.1 301 Moved Permanently'); break;
      case 302: default: header('HTTP/1.1 302 Found'); break;
    }

    static::cacheOff();
    header('Location: '.$to);
    exit;
  }
}
