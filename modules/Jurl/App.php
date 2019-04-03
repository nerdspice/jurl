<?php

namespace Jurl;

use Zodiac\Utilities\SAPI;
use Zodiac\Utilities\URL;
use Zodiac\Utilities\HTTP;
use Zodiac\Utilities\Rando;

class App {
  
  const TEMPLATE_PATH  = __DIR__.'/../../templates';
  const DB_FILE = __DIR__.'/../../db/site.db';
  
  protected $db_connection;
  protected $database;
  protected $query_builder;
  protected $settings_manager;
  protected $template_manager;
  protected $route_manager;
  protected $redirects_manager;
  
  
  public function __construct($argv) {
    $this->db_connection = new DBConnection(static::DB_FILE);
    $this->query_builder = $this->db_connection->getQueryBuilder();
    $this->database = new Database($this);
    
    $this->settings_manager  = new Manager\Settings($this);
    $this->template_manager  = new Manager\Template($this, static::TEMPLATE_PATH, array('app'=>$this));
    $this->route_manager     = new Manager\Route($this);
    $this->redirects_manager = new Manager\Redirects($this);
  }

  public function run() {
    LazyMode::engage();
    $this->initManagers();
    
    $routes = $this->route_manager->getRouterDB();
    $route = $this->route_manager->getCurrentRoute();
    $route = @$routes[$route];
    $url_key = $this->route_manager->getRoutePart(0);
    
    if($route) $this->template_manager->render($route->template);
    elseif($this->redirects_manager->hasRedirect($url_key)) $this->redirects_manager->doRedirect($url_key);
    
    if(!$route) $this->do404();
  }
  
  public function getKeySize() {
    return intval($this->settings_manager->get('key_size', '6'));
  }
  
  public function getSpecialChars() {
    return trim($this->settings_manager->get('url_special_chars','-_'));
  }

  public function getRoutes() {
    return $this->query_builder->table('router')->get();
  }
  
  public function getDefaultRoute() {
    return $this->settings_manager->get('default_route', 'shortener');
  }
  
  public function getSiteBaseUrl($abs = false) {
    return URL::getBaseUrl($abs);
  }
  
  public function isPostRequest() {
    return HTTP::isRequestMethod('POST');
  }
  
  public function getFilteredPost($key) {
    return htmlentities(trim(@$_POST[$key]));
  }
  
  public function checkRedirectUrl($url) {
    $errors = array();
    if(!URL::isHttpUrl($url)) $errors[] = 'That doesn\'t appear to be a valid url.';
    $site_host = strtolower(parse_url($this->getSiteBaseUrl(true), PHP_URL_HOST));
    $host = strtolower(parse_url($url, PHP_URL_HOST));
    if($host===$site_host) $errors[] = 'Think you\'re clever, eh?';
    return $errors;
  }
  
  public function saveNewRedirect($url = '') {
    if(!$url) $url = trim(@$_POST['url']);
    
    $key = $this->redirects_manager->getByOriginal($url);
    if(!$key) {
      $key = $this->generateNewRedirectKey();
      $this->redirects_manager->saveRedirect($key, $url);
    }
    
    return $key;
  }
  
  public function generateNewRedirectKey() {
    $opts = array(
      'special_only'=>$this->getSpecialChars()
    );

    do {
      $key = Rando::getRandom($this->getKeySize(), $opts);
    } while($this->redirects_manager->hasRedirect($key));
    return $key;
  }
  
  public function do404() {
    header('HTTP/1.1 404 Not Found');
    die('Whoopsies, that page isn\'t here. Try going back to the <a href="/">Home Page</a>.');
  }
    
  public function getQueryBuilder() {
    return $this->query_builder;
  }
  
  public function getManager($mgr) {
    return $this->{$mgr.'_manager'};
  }
  
  public function getDatabase() {
    return $this->database;
  }
  
  protected function initManagers() {
    $this->settings_manager->init();
    $this->route_manager->init();
    $this->redirects_manager->init();
  }
  
}
