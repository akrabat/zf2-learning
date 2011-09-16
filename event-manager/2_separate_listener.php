<?php

include __DIR__ . "/../load_zf.php";

use Zend\EventManager;

class MyTarget
{
    /**
	 * @var EventManager
	 */
	protected $eventManager;
    
    public function __construct()
    {
        $this->eventManager = new EventManager\EventManager(array(__CLASS__, get_called_class()));
    }
}

class MySpecificTarget extends MyTarget
{
    public function doSomethingThatTriggersAnEvent()
    {
        $this->eventManager->trigger('eventName', $this, array(1, 2, 3));
    }
}


class MyListener
{
    public function listenForMyTargetEvent()
    {
        $eventManager = EventManager\StaticEventManager::getInstance();
        $eventManager->attach('MyTarget', 'eventName', array($this, 'eventReceiverMethod'));
    }
    
    public function eventReceiverMethod(EventManager\Event $e)
    {
        echo "An event has happened!\n";
        var_dump($e->getName());
        var_dump($e->getParams());
    }
}


$listener = new MyListener();
$listener->listenForMyTargetEvent();



$target = new MySpecificTarget();
$target->doSomethingThatTriggersAnEvent();
