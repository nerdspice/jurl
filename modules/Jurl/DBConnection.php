<?php

namespace Jurl;

use Zodiac\Utilities\INIParser;
use Zodiac\Utilities\Converter;
use Viocon\Container;
use PDO;

class DBConnection extends \Pixie\Connection {
  protected $db_conn_opts = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_PERSISTENT => true,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
  );
  
  public function __construct($db_path, $alias = null) {
    $config = array(
      'driver'=>'sqlite',
      'database'=>$db_path,
      'options'=>$this->db_conn_opts
    );

    $driver = $config['driver'];
    $adapter = ucfirst(strtolower($driver));
    $container = new Container();
    
    // override all instantiations to Pixie's Adapter
    $container->set('\\Pixie\\QueryBuilder\\Adapters\\'.$adapter, '\\Jurl\\'.$adapter.'Adapter');
    
    parent::__construct($driver, $config, $alias, $container);
  }
}
