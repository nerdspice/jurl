<?php

namespace Jurl;

use Zodiac\Utilities\Arr;

class Database {
  
  protected $app;
  protected $qb;
  
  public function __construct($app) {
    $this->app = $app;
    $this->qb = $app->getQueryBuilder();
    $this->checkDB();
  }
  
  public function getTables() {
    $ret = array();
    $tables = $this->qb->table('sqlite_master')->get();
    return Arr::indexBy($tables, 'tbl_name');
  }
  
  public function checkDB() {
    $tables = $this->getTables();
    if(!isset($tables['settings'])) $this->createSettingsTable();
    if(!isset($tables['router'])) $this->createRouterTable();
    if(!isset($tables['redirects'])) $this->createRedirectsTable();
  }
    
  protected function createSettingsTable() {
    $this->qb->query('
      CREATE TABLE settings (
        name TEXT PRIMARY KEY,
        value TEXT
      )
    ');
  }
  
  protected function createRouterTable() {
    $this->qb->query('
      CREATE TABLE router (
        url TEXT PRIMARY KEY,
        template TEXT
      )
    ');
  }
  
  protected function createRedirectsTable() {
    $this->qb->query('
      CREATE TABLE redirects (
        name TEXT PRIMARY KEY,
        original TEXT NOT NULL,
        expires TEXT
      )
    ');
    
    $this->qb->query('
      CREATE INDEX redirects_orig ON redirects (original)
    ');
  }
}