<?php

define('ZF2_PATH', 
    (getenv('ZF2_PATH') ? getenv('ZF2_PATH') : realpath(__DIR__ . '/library/Zend'))
);

require_once ZF2_PATH . '/Loader/StandardAutoloader.php';
$autoLoader = new Zend\Loader\StandardAutoloader();

// register our StandardAutoloader with the SPL autoloader
$autoLoader->register(); 

// register the Zend namespace
$autoLoader->registerNamespace('Zend', ZF2_PATH);

