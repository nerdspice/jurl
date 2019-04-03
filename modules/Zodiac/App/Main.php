<?php

namespace Zodiac\App;

class Main implements Runtime {
  
  // extend and ovrride me
  public static function main($argv) {
    throw new \Exception('You must extend and override '.get_class().'::main() with your own class');
  }
  
  final public static function initRuntime() {
    $argv = self::getArgv();
    static::main($argv);
  }
  
  private static function getArgv() {
    return @$_SERVER['argv'] ?: array(
      (@$_SERVER['SCRIPT_NAME'] ?: '')
    );
  }
}
