<?php

define('ZF2_PATH', 
    (getenv('ZF2_PATH') ? getenv('ZF2_PATH') : realpath(__DIR__ . '/library'))
);

require_once ZF2_PATH . '/Zend/Loader/StandardAutoloader.php';
$autoLoader = new Zend\Loader\StandardAutoloader();

// register our StandardAutoloader with the SPL autoloader
$autoLoader->register(); 


