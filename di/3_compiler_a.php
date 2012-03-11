<?php
// Test compiling the DI defintions via codescanning

include __DIR__ . "/../load_zf.php";

// register the My/ namespace
$autoLoader->registerNamespace('My', __DIR__ . '/My/');


// Compilation
$compiler = new Zend\Di\Definition\CompilerDefinition();
$compiler->addDirectory(__DIR__ . '/My/');
$compiler->compile();
$definition = $compiler->toArrayDefinition();


// Test
echo PHP_EOL . 'DI: $userTable = $di->get(\'My\UserTable\', array(\'dsn\'=>\'mysql:dbname=db1\')' . PHP_EOL;
$definitions = new Zend\Di\DefinitionList($definition);
$di = new \Zend\Di\Di($definitions);

$userTable = $di->get('My\UserTable', array('dsn'=>'mysql:dbname=db1'));
var_dump($userTable);

// What the complication does it look like?
echo PHP_EOL . 'ver_exported definition:' . PHP_EOL;
echo var_export($definition->toArray(), true);
