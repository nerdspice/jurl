<?php

namespace Jurl\Manager;

use Zodiac\Utilities\HTTP;
use Zodiac\Utilities\URL;

class Redirects extends Manager {
  
  protected $qb;
  
  public function init() {
    $this->qb = $this->app->getQueryBuilder();
  }
  
  public function hasRedirect($key) {
    $val = $this->qb->table('redirects')->find($key, 'name');
    return !!$val;
  }
  
  public function getByOriginal($url) {
    $val = $this->qb->table('redirects')->find($url, 'original');
    return $val ? $val->name : false;
  }
  
  public function doRedirect($key) {
    $val = $this->qb->table('redirects')->find($key, 'name');
    if(!$val || !$val->original || !URL::isHttpUrl($val->original)) return false;
    HTTP::redirect($val->original);
  }
  
  public function saveRedirect($key, $url, $expires = null) {
    $this->qb->table('redirects')->insert(array('name'=>$key, 'original'=>$url));
  }
}