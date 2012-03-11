<?php
// Test loading DI config from an ini file
namespace My;

include __DIR__ . "/../load_zf.php";

class DatabaseAdapter
{
    protected $dsn;

    public function __construct($dsn)
    {
        $this->dsn = $dsn;
    }
}

class UserTable
{
    protected $db;
    
    public function __construct (DatabaseAdapter $db)
    {
        $this->db = $db;
    }
}

$reader = new \Zend\Config\Reader\Ini();
$data = $reader->fromFile(__DIR__ . '/5_configuration.ini');
$config = new \Zend\Config\Config($data['production']);

$diConfig = new \Zend\Di\Configuration($config->di);

$di = new \Zend\Di\Di();
$diConfig->configure($di);

// Test
echo PHP_EOL . 'DI: $users = $di->get("users");' . PHP_EOL;
$users = $di->get("users");
var_dump($users);


