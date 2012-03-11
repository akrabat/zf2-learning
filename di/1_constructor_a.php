<?php
// Test that DI works (instantiates a DatabaseAdapter) and also check that
// newInstance() creates a different object

namespace My;

include __DIR__ . "/../load_zf.php";

class DatabaseAdapter
{
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
$userTable = new \My\UserTable(new \My\DatabaseAdapter());
var_dump($userTable);
unset($userTable);

echo PHP_EOL. 'DI one: $userTable = $di->get(\'My\UserTable\')' . PHP_EOL;
$di = new \Zend\Di\Di();
$userTable = $di->get('My\UserTable');
var_dump($userTable);

echo PHP_EOL. 'DI two: $userTable2 = $di->newInstance(\'My\UserTable\')' . PHP_EOL;
$userTable2 = $di->newInstance('My\UserTable');
var_dump($userTable2);

echo PHP_EOL. 'DI three: $userTableAgain = $di->get(\'My\UserTable\')' . PHP_EOL;
$userTableAgain = $di->get('My\UserTable');
var_dump($userTableAgain);
