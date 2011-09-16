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
        $this->eventManager->trigger('eventName', $this);
    }
}


class MyListener
{
    public function listenForMyTargetEvent()
    {
        $eventManager = EventManager\StaticEventManager::getInstance();
        $eventManager->attach('MyTarget', 'eventName', array($this, 'eventReceiverMethod'));
    }

    public function listenForMySpecificTargetEvent()
    {
        $eventManager = EventManager\StaticEventManager::getInstance();
        $eventManager->attach('MySpecificTarget', 'eventName', array($this, 'eventReceiverMethod'));
    }
    
    public function eventReceiverMethod(EventManager\Event $e)
    {
        echo "An event has happened! Event name = '" . $e->getName() . "'\n";
        var_dump($this);
    }
}


echo "\nListen for MyTarget\n";
$listener = new MyListener();
$listener->listenForMyTargetEvent();

$target = new MySpecificTarget();
$target->doSomethingThatTriggersAnEvent();


unset($listener);


echo "\nListen for MySpecificTarget\n";
$listener = new MyListener();
$listener->listenForMySpecificTargetEvent();

$target = new MySpecificTarget();
$target->doSomethingThatTriggersAnEvent();
