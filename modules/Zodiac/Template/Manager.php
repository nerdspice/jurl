<?php

namespace Zodiac\Template;

class Manager {
  use \Zodiac\Utilities\MemCache;
  
  public function __construct($globals = array()) {
    $this->cache = is_array($globals) ? $globals : array($globals);
  }
  
  public function setGlobal($key, $val) {
    return $this->setCache($key, $val);
  }
  
  public function getGlobal($key, $default = null) {
    return $this->getCache($key, $default);
  }
  
  protected function filterTemplateArgs(&$args) {
    if(is_object($args)) $args = (array)$args;
    if(!is_array($args)) $args = array($args);
    
    $new_args = $this->cache + $args;
    $new_args['view'] = $this;
    $new_args['arguments'] = array_merge($args);
    
    $args = $new_args;
  }
}
