<?php

namespace Jurl;

use Zodiac\Utilities\URL;
use Zodiac\Utilities\SAPI;

class LazyMode {
  
  public static function engage() {
    SAPI::normalizeServerVars();
  }
}

