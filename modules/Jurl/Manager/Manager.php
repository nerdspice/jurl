<?php

namespace Jurl\Manager;

abstract class Manager {
  protected $app;
  protected $db;
  
  public function __construct($app) {
    $this->app = $app;
    $this->db = $app->getDatabase();
  }
  
  abstract public function init();
}