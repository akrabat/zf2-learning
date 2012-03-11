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


// Test
echo PHP_EOL . 'DI: $users = $di->get("users");' . PHP_EOL;
$users = $di->get("users");
var_dump($users);


