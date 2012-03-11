<?php

include __DIR__ . "/../load_zf.php";

use Zend\EventManager\EventManager,
    Zend\EventManager\Event;


$callback = function ($event) {
    echo "An event has happened!\n";
    var_dump($event->getName());
    var_dump($event->getParams());    
};


$eventManager = new EventManager('RKA');
$eventManager->attach('eventName', $callback);


echo "\nRaise an event\n";
$eventManager->trigger('eventName', null, 
    array('one'=>1, 'two'=>2));



echo "\nStatic attachment\n";
$events = \Zend\EventManager\StaticEventManager::getInstance();
$events->attach('RKA', 'eventName', $callback);


$event = new Event();
$event->setTarget(null);
$event->setParam('one', 1);

$eventManager->trigger('eventName', $event);