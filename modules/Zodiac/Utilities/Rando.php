<?php

namespace Zodiac\Utilities;

use Zodiac\Utilities\Filter;

class Rando {
  
  protected static $default_opts = array(
    'upper'=>true,
    'numbers'=>true,
    'special'=>false,
    'upper_only'=>false,
    'lower'=>true,
    'all'=>false, // use full alphabet (sets upper, lower, numbers, special to true; upper_only to false)
    'max_len'=>16384,
    'exclude'=>'', // exclude characters from the character set
    'alpha'=>'', // specify a character set to use instead of the default
    'special_only'=>'' // use these special characters only instead of the default
  );
  
  public static function getRandom($len = 1, $opts = array()) {
    $opts = (array)$opts; // cast to array incase we're handed an object
    extract($opts += self::$default_opts);
    unset($opts);
    
    $chars = '';
    
    if($alpha) {
      $chars = @strval($alpha);
    } else {
      if($all) {
        $upper = $lower = $numbers = $special = true;
        $upper_only = false;
      }
      
      $chars = $lower ? 'abcdefghijklmnopqrstuvwxyz' : '';
      $upper_alpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      if($upper_only) $chars = $upper_alpha;
      elseif($upper) $chars .= $upper_alpha;
      if($numbers) $chars .= '0123456789';
      if($special && !$special_only) $chars .= '!@#$%^&*()_+=-[]\\;\',./{}|:"<>?`';
      elseif($special_only) $chars .= $special_only;
    }
    
    if($exclude) $chars = Filter::removeChars($exclude, $chars);
    $chars = Filter::strUnique($chars);

    $ret = '';
    $len = abs(intval($len));
    $max_len = abs(intval($max_len));
    
    if($len > $max_len)
       $len = $max_len;

    $str_len = strlen($chars)-1;
    if($str_len>=0 && $len) {
      do {
        $rand = rand(0, $str_len);
        $ret .= $chars[$rand];
      } while(--$len);
    }

    return $ret;
  }
}
