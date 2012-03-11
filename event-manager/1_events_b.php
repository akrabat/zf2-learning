<?php

include __DIR__ . "/../load_zf.php";

use Zend\EventManager\EventManager,
    Zend\EventManager\Event;

$callback = function ($event) {
    echo "Responding to doIt.pre!\n";
    var_dump(get_class($event->getTarget()));
    var_dump($event->getName());
    var_dump($event->getParams());
};

class MyTarget
{
    /**
	 * @var EventManager
	 */
    public $eventManager;
    
    public function __construct()
    {
        $this->eventManager = new EventManager(__CLASS__);
    }
   
    public function doIt()
    {
        $event = new Event();
        $event->setTarget($this);
        $event->setParam('one', 1);
        $event->setParam('two', 2);
        $this->eventManager->trigger('doIt.pre', $event);
    }
}


echo "\nLocal attachment\n";
$obj = new MyTarget();
$handle = $obj->eventManager->attach('doIt.pre', $callback);

$obj->doIt();
$obj->eventManager->detach($handle);

echo "\nStatic attachment\n";
$events = \Zend\EventManager\StaticEventManager::getInstance();
$events->attach('MyTarget', 'doIt.pre', $callback);

$obj->doIt();