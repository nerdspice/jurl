<?php

namespace Zodiac\Utilities;

trait MemCache {
  protected $cache = array();
  
  public function getCache($key, $default = null) {
    if(!isset($this->cache[$key]))
      return $default;
    return $this->cache[$key];
  }
  
  public function setCache($key, $val) {
    $this->cache[$key] = $val;
  }
}

