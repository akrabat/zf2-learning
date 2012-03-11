<?php

include __DIR__ . "/../load_zf.php";

// register the My/ namespace
$autoLoader->registerNamespace('My', __DIR__ . '/My/');

$data = array (
    'instance' => array (
        'My\DatabaseAdapter' => array (
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
echo PHP_EOL . 'DI: $users = $di->get("My\UserTable");' . PHP_EOL;
$users = $di->get("My\UserTable");
var_dump($users);
