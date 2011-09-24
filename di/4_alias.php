<?php

include __DIR__ . "/../load_zf.php";

// register the My/ namespace
$autoLoader->registerNamespace('My', __DIR__ . '/My/');



$di = new Zend\Di\DependencyInjector();
$im = $di->getInstanceManager();

$im->addAlias('artist', 'My\Artist');
$im->addAlias('album', 'My\Album');

$im->setParameters('artist', array('name' => 'The Beatles'));


// Test
echo PHP_EOL . 'DI: $artist = $di->get("artist");' . PHP_EOL;
$artist = $di->get("artist");
var_dump($artist);

echo PHP_EOL . 'DI: $album = $di->get("album", array("name" => "Queen"));' . PHP_EOL;
$album = $di->get("album", array("name" => "Queen"));
var_dump($album);
