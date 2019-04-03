<?php

// java-like Main class initialization
class App extends \Zodiac\App\Main {
  
  public static function main($argv) {
    // user code starts here
    
    // the Jurl namespace is where all site-specific
    // code/modules are pulled together
    $app = new \Jurl\App($argv);
    $app->run();
  }
  
}
