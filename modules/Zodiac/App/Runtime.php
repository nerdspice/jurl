<?php

namespace Zodiac\App;

interface Runtime {
  public static function main($argv);
  public static function initRuntime();
}
