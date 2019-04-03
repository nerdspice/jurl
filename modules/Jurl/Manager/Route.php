<?php

namespace Jurl\Manager;

use Zodiac\Utilities\URL;
use Zodiac\Utilities\Arr;

class Route extends Manager {
  const HOME_ROUTE = 'shortener';

  protected $current_route = '';
  protected $router = array();
  
  public function init() {
    $this->setupRequestPath();
    $this->router = $this->getRouterDB();
    $this->current_route = $this->parseCurrentRoute();
  }
  
  public function getRouterDB() {
    $router = $this->app->getRoutes();
    return Arr::indexBy($router, 'url');
  }
  
  public function getCurrentRoute() {
    return $this->current_route;
  }
  

  
  public function parseRoutePath($str) {
    $path = explode('#', $str);
    $path = explode('?', $path[0]);
    $path = explode('/', $path[0]);
    $path = array_filter($path);
    return array_merge($path);
  }
  
  public function getRouteParts() {
    return $this->parseRoutePath(@$_SERVER['REQUEST_PATH']);
  }
  
  function getRoutePart($idx) {
    $parts = $this->getRouteParts();
    if(!empty($parts[$idx]))
      return $parts[$idx];
    else return false;
  }
  
  public function parseCurrentRoute() {
    $router = $this->router;
    $path = $this->getRouteParts();
    if($path) {
      $tmp = array_shift($path);
      if(isset($router[$tmp])) return $tmp;
      else return false;
    } else return $this->app->getDefaultRoute();
    return false;
  }
  
  public function setupRequestPath() {
    $S = &$_SERVER;
    $base = substr(URL::getBaseUrl(false), 0, -1);
    $uri = explode('?', @$S['REQUEST_URI']);
    $uri = $uri[0];
    $path = preg_replace('#^'.preg_quote($base, '#').'#', '', $uri, 1);
    $S['REQUEST_PATH'] = $path;
  }
}
