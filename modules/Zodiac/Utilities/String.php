<?php

namespace Zodiac\Utilities;

use Zodiac\Utilities\Arr;

class String {
  public static function pad($pad_len, $str = '', $align_left = true, $pad_chr = ' ') {
    $pad_len = intval($pad_len);
    $pad_chr = @$pad_chr[0] ?: ' ';
    $align = $align_left ? '-' : '';
    return sprintf('%'.$align.$pad_chr.$pad_len.'s', $str);
  }
  
  public static function concatFixed($strs = array()) {
    $args = func_get_args();
    array_shift($args);
    $args = Arr::flatten($args);
    $ret = '';

    foreach($args as $i => $flen) {
      $flen = intval($flen);
      $val = @$strs[$i];
      $ret .= self::pad($flen, $val);
    }

    return $ret;
  }
  
  public static function splitFixed($str, $off) {
    $args = Arr::flatten(func_get_args());
    $str = array_shift($args);
    $ret = array();
    array_shift($args);

    $len = strlen($str);
    $offset = $off;

    foreach($args as $flen) {
      $flen = intval($flen);
      if($offset >= $len) break;
      $s = substr($str, $offset, $flen);
      $ret[] = $s;
      $offset += $flen;
    }

    return $ret;
  }
}
