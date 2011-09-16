<?php


include __DIR__ . "/../load_zf.php";
// register the My/ namespace
$autoLoader->registerNamespace('My', __DIR__ . '/My/');


use \My\Db\Statement\Sqlsrv;

$stmt = new Sqlsrv();
var_dump($stmt);
