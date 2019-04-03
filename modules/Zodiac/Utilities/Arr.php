<?php

namespace Zodiac\Utilities;

class Arr {
  public static function flatten($arr) {
    return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($arr)), false);
  }
  
  public static function indexBy($arr, $field='id') {
    if(!$arr) $arr = array();
    $ret = array();
    foreach($arr as $obj) {
      if(!isset($obj->{$field})) continue;
      $ret[$obj->{$field}] = $obj;
    }
    return $ret;
  }
  
  public static function extract($arr, $key_field='id', $val_field='name') {
  if(!$arr) $arr = array();
  $ret = array();
  foreach($arr as $obj) {
    $k = is_array($obj) ? @$obj[$key_field] : @$obj->{$key_field};
    $v = is_array($obj) ? @$obj[$val_field] : @$obj->{$val_field};
    $ret[$k] = $v;
  }
  return $ret;
}
}
