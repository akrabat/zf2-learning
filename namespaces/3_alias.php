<?php


include __DIR__ . "/../load_zf.php";
// register the My/ namespace
$autoLoader->registerNamespace('My', __DIR__ . '/My/');


use \My\Db\Statement\Sqlsrv as DbStatement;
use \My\Db\Adapter\Sqlsrv as DbAdapter;

$stmt = new DbStatement();
$adapter = new DbAdapter();


var_dump($adapter);
var_dump($stmt);
