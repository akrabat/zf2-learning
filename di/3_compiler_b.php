<?php
// Test storing the compiled definitions to disk as a DI definition class
// and then using that

include __DIR__ . "/../load_zf.php";

if (file_exists(__DIR__ . '/My/DiDefinition.php')) {
    unlink(__DIR__ . '/My/DiDefinition.php');
}

// register the My/ namespace
$autoLoader->registerNamespace('My', __DIR__ . '/My/');


// Compilation
$compiler = new Zend\Di\Definition\CompilerDefinition();
$compiler->addDirectory(__DIR__ . '/My/');
$compiler->compile();
$definition = $compiler->toArrayDefinition();

// create the PHP class definition
$class = new Zend\Code\Generator\ClassGenerator();
$class->setName('DiDefinition');
$class->setExtendedClass('ArrayDefinition');

$method = new Zend\Code\Generator\MethodGenerator('__construct');
$method->setBody('parent::__construct(' . var_export($definition->toArray(), true) . ');');


$class->setMethod($method);
// Generate the code
$codeGenerator = new Zend\Code\Generator\FileGenerator();
$codeGenerator->setNamespace('My');
$codeGenerator->setUse('\Zend\Di\Definition\ArrayDefinition');
$codeGenerator->setClass($class);
file_put_contents(__DIR__ . '/My/DiDefinition.php', $codeGenerator->generate());


// Set up DI
$myDefinition = new My\DiDefinition();
$definitions = new Zend\Di\DefinitionList($myDefinition);
$di = new Zend\Di\Di($definitions);


// Test
echo PHP_EOL . 'DI: $userTable = $di->get(\'My\UserTable\', array(\'dsn\'=>\'mysql:dbname=db1\')' . PHP_EOL;
$userTable = $di->get('My\UserTable', array('dsn'=>'mysql:dbname=db1'));
var_dump($userTable);
