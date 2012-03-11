<?php

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


$di = new \Zend\Di\Di();
$di->instanceManager()->addTypePreference('Zend\Di\Locator', $di);
$im = $di->instanceManager();

$im->addAlias('adapter', 'My\DatabaseAdapter');
$im->addAlias('users', 'My\UserTable');

$im->setParameters('My\DatabaseAdapter', array('dsn' => 'mysql:dbname=db1'));

// Test
echo PHP_EOL . 'DI: $adapter = $di->get("adapter");' . PHP_EOL;
$adapter = $di->get("adapter");
var_dump($adapter);

echo PHP_EOL . 'DI: $users = $di->get("users");' . PHP_EOL;
$users = $di->get("users");
var_dump($users);
