<?php

namespace Zodiac\Template;

trait PageTitle {
  protected $page_title = '';
  
  public function pageTitle($title = null) {
    if(!is_null($title)) $this->page_title = $title;
    return $this->page_title;
  }
}

