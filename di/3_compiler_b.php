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
$class->setNamespaceName('My');
$class->setName('DiDefinition');
$class->setExtendedClass('\Zend\Di\Definition\ArrayDefinition');
$class->setMethod(array(
    'name' => '__construct',
    'body' => 'parent::__construct(' . var_export($definition->toArray(), true) . ');'
));

// Generate the code
$codeGenerator = new Zend\CodeGenerator\Php\PhpFile();
$codeGenerator->setClass($class);
//file_put_contents(__DIR__ . '/My/DiDefinition.php', $codeGenerator->generate());

var_dump($codeGenerator->generate());
