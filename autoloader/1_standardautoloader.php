<?php

define('ZF2_PATH', 
    (getenv('ZF2_PATH') ? getenv('ZF2_PATH') : realpath(__DIR__ . '/../library/Zend'))
);

require_once ZF2_PATH . '/Loader/StandardAutoloader.php';

$autoLoader = new Zend\Loader\StandardAutoloader(array(
    'prefixes' => array(
        'MyVendor' => __DIR__ . '/MyVendor',
    ),
    'namespaces' => array(
        'MyNamespace' => __DIR__ . '/MyNamespace',
    ),
    'fallback_autoloader' => false,
));

// register our StandardAutoloader with the SPL autoloader
$autoLoader->register(); 


$namespaceTest = new MyNamespace\Test();
var_dump($namespaceTest);

$subNamespaceTest = new MyNamespace\Sub_Test();
var_dump($subNamespaceTest);

$prefixTest = new MyVendor_Sub_Test();
var_dump($prefixTest);

$underscoreTest = new MyNamespace\A\Another_Sub\Test();
var_dump($underscoreTest);

$underscoreTest = new MyNamespace\A_b\Another_Sub\Test();
var_dump($underscoreTest);
