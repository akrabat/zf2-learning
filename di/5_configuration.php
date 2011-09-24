<?php

include __DIR__ . "/../load_zf.php";

// register the My/ namespace
$autoLoader->registerNamespace('My', __DIR__ . '/My/');

$config = new Zend\Config\Ini(__DIR__ . '/5_configuration.ini', 'production');
$diConfig = new Zend\Di\Configuration($config->di);

$di = new Zend\Di\DependencyInjector($diConfig);

// Test
echo PHP_EOL . 'DI: $artist = $di->get("artist");' . PHP_EOL;
$artist = $di->get("artist");
var_dump($artist);

echo PHP_EOL . 'DI: $album = $di->get("album", array("name" => "Smile"));' . PHP_EOL;
$album = $di->get("album", array("name" => "Queen"));
var_dump($album);
