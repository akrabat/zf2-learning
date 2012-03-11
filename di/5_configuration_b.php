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

$data = array(
    'instance' => array (
        'alias' => array (
            'users' => 'My\UserTable',
            'adapter' => 'My\DatabaseAdapter',
        ),

        'users' => array (
            'parameters' => array (
                'db' => 'adapter',
            ),
        ),
        'adapter' => array (
            'parameters' => array (
                'dsn' => 'mysql:dbname=ini',
            ),
        ),
    ),
);
$diConfig = new \Zend\Di\Configuration($data);

$di = new \Zend\Di\Di();
$diConfig->configure($di);


// Test 1
echo PHP_EOL . 'DI: $adapter = $di->get("adapter");' . PHP_EOL;
$adapter = $di->get("adapter");
var_dump($adapter);

// Test 2
echo PHP_EOL . 'DI: $users = $di->get("users");' . PHP_EOL;
$users = $di->get("users");
var_dump($users);


