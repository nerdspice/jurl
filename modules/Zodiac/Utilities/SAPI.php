<?php

namespace Zodiac\Utilities;

class SAPI {
  public static function isCli() {
    return static::getSapi() === 'cli';
  }
  
  public static function getSapi() {
    return php_sapi_name();
  }
  
  public static function normalizeServerVars() {
    $S = &$_SERVER;
    if(!isset($S['REQUEST_URI'])) $S['REQUEST_URI'] = '';
    if(!isset($S['SERVER_NAME'])) $S['SERVER_NAME'] = '';
    if(!isset($S['SCRIPT_NAME'])) $S['SCRIPT_NAME'] = '';
    if(!isset($S['SERVER_PORT'])) $S['SERVER_PORT'] = '';
    if(!isset($S['REQUEST_METHOD'])) $S['REQUEST_METHOD'] = '';
  }
}

