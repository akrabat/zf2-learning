<?php

include __DIR__ . "/../load_zf.php";

// register the My/ namespace
$autoLoader->registerNamespace('My', __DIR__ . '/My/');


// Compilation
$compiler = new Zend\Di\Definition\Compiler();
$compiler->addCodeScannerDirectory(
    new Zend\Code\Scanner\DirectoryScanner(__DIR__ . '/My/')
);
$definition = $compiler->compile();


// Test
echo PHP_EOL . 'DI: $album = $di->get(\'My\Album\', array(\'Jonathan Coulton\')' . PHP_EOL;
$di = new \Zend\Di\DependencyInjector();
$di->setDefinition($definition);
$album = $di->get('My\Album', array('name' => 'Jonathan Coulton'));
var_dump($album);

// What the complication does it look like?
//echo PHP_EOL . 'ver_exported definition:' . PHP_EOL;
//echo var_export($definition->toArray(), true);
