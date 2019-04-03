<?php

namespace Jurl\Manager;

use Zodiac\Utilities\Arr;

class Settings extends Manager {
  
  protected $qb;
  
  public function init() {
    $this->qb = $this->app->getQueryBuilder();
  }
  
  public function getSettings() {
    $settings = $this->qb->table('settings')->get();
    return Arr::indexBy($settings, 'name');
  }
  
  public function get($key, $default = null) {
    $row = $this->qb->table('settings')->find($key, 'name');
    return $row ? $row->value : $default;
  }
  
}