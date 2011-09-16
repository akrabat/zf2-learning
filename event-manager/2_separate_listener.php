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
    protected $eventHandlerForMyTarget = null;
    protected $eventHandlerForMySpecificTarget = null;
    
    public function listenForMyTargetEvent()
    {
        $eventManager = EventManager\StaticEventManager::getInstance();
        $this->eventHandlerForMyTarget = $eventManager->attach('MyTarget', 'eventName', array($this, 'eventReceiverMethod'));
    }

    public function listenForMySpecificTargetEvent()
    {
        $eventManager = EventManager\StaticEventManager::getInstance();
        $this->eventHandlerForMySpecificTarget = $eventManager->attach('MySpecificTarget', 'eventName', array($this, 'eventReceiverMethod'));
    }
    
    public function eventReceiverMethod(EventManager\Event $e)
    {
        echo "An event has happened! Event name = '" . $e->getName() . "'\n";
    }
    
    public function __destruct()
    {
        $eventManager = EventManager\StaticEventManager::getInstance();
        if ($this->eventHandlerForMyTarget) {
            echo "detaching eventHandlerForMyTarget\n";
            $eventManager->detach($this->eventHandlerForMyTarget);
        }
        if ($this->eventHandlerForMySpecificTarget) {
            echo "detaching eventHandlerForMySpecificTarget";
            $eventManager->detach($this->eventHandlerForMySpecificTarget);
        }
    }
}


echo "\nListen for MyTarget\n";
$listener = new MyListener();
$listener->listenForMyTargetEvent();

$target = new MySpecificTarget();
$target->doSomethingThatTriggersAnEvent();


unset($listener); $listener = null;


echo "\nListen for MySpecificTarget\n";
$listener = new MyListener();
$listener->listenForMySpecificTargetEvent();

$target->doSomethingThatTriggersAnEvent();
