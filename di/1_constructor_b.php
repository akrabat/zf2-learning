<?php
// Test setting dependent parameters via constructor injection

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

// Test it
echo "Manual instantiation:\n";
$userTable = new \My\UserTable(new \My\DatabaseAdapter('mysql:dbname=manual'));
var_dump($userTable);
unset($userTable);

echo PHP_EOL. 'Config injection of parameter one:'.PHP_EOL.'    $userTable = $di->get(\'My\UserTable\')' . PHP_EOL;
$di = new \Zend\Di\Di();
$di->instanceManager()->setParameters('My\DatabaseAdapter', array(
        'dsn'=>'mysql:dbname=db1'
    ));
$userTable = $di->get('My\UserTable');
var_dump($userTable);

echo PHP_EOL. 'Dynamic injection of parameter:'.PHP_EOL.'    $userTable2 = $di->get(\'My\UserTable\', array(\'dsn\'=>\'mysql:dbname=db2\')' . PHP_EOL;
$userTable2 = $di->get('My\UserTable', array('dsn'=>'mysql:dbname=db2'));
var_dump($userTable2);


echo PHP_EOL. 'And again, but with different parameters:'.PHP_EOL.'    $userTable3 = $di->get(\'My\UserTable\', array(\'dsn\'=>\'mysql:dbname=db3\')' . PHP_EOL;
$userTable3 = $di->get('My\UserTable', array('dsn'=>'mysql:dbname=db3'));
var_dump($userTable3);


echo PHP_EOL. 'Get a new UserTable, but the same dbAdapter as used for $userTable2:'.PHP_EOL.'    $userTable4 = $di->newInstance(\'My\UserTable\', array(\'dsn\'=>\'mysql:dbname=db2\')' . PHP_EOL;
$userTable4 = $di->get('My\UserTable', array('dsn'=>'mysql:dbname=db2'));
var_dump($userTable4);

