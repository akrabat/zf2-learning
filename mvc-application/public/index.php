<?php


require_once __DIR__ . '/../library/Zend/Loader/StandardAutoloader.php';
$loader = new Zend\Loader\StandardAutoloader(array(
    'namespaces' => array(
        'Zend' =>  __DIR__ . '/../library/Zend',
        
        // should be able to automate registration of modules...
        'Zf2Mvc' =>  __DIR__ . '/../modules/Zend/Zf2Mvc/src/Zf2Mvc',
        'Application' =>  __DIR__ . '/../modules/Application/src/Application',
        'HelloWorld' =>  __DIR__ . '/../modules/HelloWorld/src/HelloWorld',
    ),
));
$loader->register();


$env = getenv('APPLICATION_ENV');
if (!$env) {
    $env = 'production';
}

$config = new Zend\Config\Ini(__DIR__ . '/../modules/Application/configs/application.ini', $env);
$app = new Zf2Mvc\Application();
$bootstrap = new Application\Bootstrap($config);
$bootstrap->bootstrap($app);

$response = $app->run();
$response->send();