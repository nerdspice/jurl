<?php

namespace Jurl\Manager;

use Zodiac\Utilities\Filter;

class Template extends \Zodiac\Template\PHP {
  use \Zodiac\Template\PageTitle;
  
  protected $app;
  
  public function __construct($app, $base_path, $globals = array()) {
    $this->app = $app;
    parent::__construct($base_path, $globals);
  }

  public function header($ret = false) {
    $args = array(
      'page_title'=>Filter::escHtml($this->pageTitle())
    );
    
    return $this->render('header.php', $args, $ret);
  }
  
  public function footer($ret = false) {
    return $this->render('footer.php', array(), $ret);
  }
}
