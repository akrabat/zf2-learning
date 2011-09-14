<?php


define('ZF2_PATH', 
    (getenv('ZF2_PATH') ? getenv('ZF2_PATH') : realpath(__DIR__ . '/../library/Zend'))
);

require_once ZF2_PATH . '/Loader/ClassMapAutoloader.php';

$autoLoader = new \Zend\Loader\ClassMapAutoloader(array(__DIR__ . '/.classmap.php'));

// register with the SPL autoloader
$autoLoader->register(); 


$namespaceTest = new MyNamespace\Test();
var_dump($namespaceTest);
$subNamespaceTest = new MyNamespace\Sub_Test();
var_dump($subNamespaceTest);

$prefixTest = new MyVendor_Sub_Test();
var_dump($prefixTest);
