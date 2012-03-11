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
    protected $artist;
    
    public function setDatabaseAdapter(DatabaseAdapter $artist)
    {
        $this->artist = $artist;
    }

}

// Test it
echo "Sanity check: manual instantiation:\n";
$userTable = new \My\UserTable();
$databaseAdapter = new \My\DatabaseAdapter('mysql:dbname=manual');
$userTable->setDatabaseAdapter($databaseAdapter);
var_dump($userTable);
unset($userTable);


echo PHP_EOL. 'Config injection of parameter: $userTable = $di->get(\'My\UserTable\')' . PHP_EOL;
$di = new \Zend\Di\Di();
$di->configure(new \Zend\Di\Configuration(array(
    'definition' => array(
        'class' => array(
            'My\UserTable' => array(
                'setDatabaseAdapter' => array('required' => true)
            )
        )
    )
)));

$di->instanceManager()->setParameters('My\DatabaseAdapter', array(
    'dsn'=>'mysql:dbname=db1',
));
$userTable = $di->get('My\UserTable');
var_dump($userTable);

// unset($di);
// $di = new \Zend\Di\Di();

echo PHP_EOL. 'Dynamic injection of parameter: $userTable2 = $di->get(\'My\UserTable\', array(\'dsn\'=>\'mysql:dbname=db2\')' . PHP_EOL;
$di->configure(new \Zend\Di\Configuration(array(
        'definition' => array(
            'class' => array(
                'My\UserTable' => array(
                    'setDatabaseAdapter' => array('required' => true)
                )
            )
        )
    )));
$userTable2 = $di->newInstance('My\UserTable', array('dsn'=>'mysql:dbname=db2'));
var_dump($userTable2);

