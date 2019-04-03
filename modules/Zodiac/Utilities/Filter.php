<?php

namespace Zodiac\Utilities;


class Filter {
  public static function strUnique($subject) {
    return implode('', array_unique(str_split($subject)));
  }
  
  public static function removeChars($exclude, $subject) {
    return str_replace(str_split($exclude), '', $subject);
  }
  
  public static function escHtml($str) {
    return htmlentities($str, ENT_QUOTES);
  }
}


