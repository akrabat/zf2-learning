<?php


include __DIR__ . "/../load_zf.php";
// register the My/ namespace
$autoLoader->registerNamespace('My', __DIR__ . '/My/');



$stmt = new \My\Db\Statement\Sqlsrv();   
var_dump($stmt);