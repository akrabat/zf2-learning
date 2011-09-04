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

// create the PHP class definition
$class = new Zend\CodeGenerator\Php\PhpClass();
$class->setName('DiDefinition');
$class->setExtendedClass('ArrayDefinition');
$class->setMethod(array(
    'name' => '__construct',
    'body' => 'parent::__construct(' . var_export($definition->toArray(), true) . ');'
));

// Generate the code
$codeGenerator = new Zend\CodeGenerator\Php\PhpFile();
$codeGenerator->setNamespace('My');
$codeGenerator->setUse('\Zend\Di\Definition\ArrayDefinition');
$codeGenerator->setClass($class);
file_put_contents(__DIR__ . '/My/DiDefinition.php', $codeGenerator->generate());

//var_dump($codeGenerator->generate());


// Now use it:
use Zend\Di\DependencyInjector,
    Zend\Di\Definition,
    Zend\Di\Definition\Builder;
 
$di = new DependencyInjector;
$diDefAggregate = new Definition\AggregateDefinition();
 
// first add in provided Definitions, for example
$diDefAggregate->addDefinition(new My\DiDefinition());
//$diDefAggregate->addDefinition(new Another\DiDefinition());
$diDefAggregate->addDefinition(new Definition\RuntimeDefinition());
 
$di->setDefinition($diDefAggregate);

// Test
echo PHP_EOL . 'DI: $album = $di->get(\'My\Album\', array(\'Jonathan Coulton\')' . PHP_EOL;
$album = $di->get('My\Album', array('name' => 'Jonathan Coulton'));
var_dump($album);