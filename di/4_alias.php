<?php

include __DIR__ . "/../load_zf.php";

// register the My/ namespace
$autoLoader->registerNamespace('My', __DIR__ . '/My/');



$di = new Zend\Di\Di();
$im = $di->instanceManager();

$im->addAlias('adapter', 'My\DatabaseAdapter');
$im->addAlias('users', 'My\UserTable');

$im->setParameters('adapter', array('dsn' => 'mysql:dbname=db1'));


// Test
echo PHP_EOL . 'DI: $adapter = $di->get("adapter");' . PHP_EOL;
$adapter = $di->get("adapter");
var_dump($adapter);

echo PHP_EOL . 'DI: $users = $di->get("users", array("dsn" => "mysql:dbname=db1"));' . PHP_EOL;
$users = $di->get("users", array("dsn" => "mysql:dbname=db1"));
var_dump($users);
