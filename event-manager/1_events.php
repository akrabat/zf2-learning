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
        $this->eventManager = new EventManager\EventManager();
    }
    
    public function attachAListener()
    {
        $this->eventManager->attach('eventName', array($this, 'eventReceiverMethod'));
    }
    
    public function eventReceiverMethod(EventManager\Event $e)
    {
        echo "An event has happened!\n";
        var_dump($e->getName());
        var_dump($e->getParams());
    }
    
    
    public function doSomethingThatTriggersAnEvent()
    {
        $this->eventManager->trigger('eventName', $this, array(1, 2, 3));
    }
}

echo "\nLocal attachment\n";
$obj = new MyTarget();
$obj->attachAListener();
$obj->doSomethingThatTriggersAnEvent();

echo "\nStatic attachment\n";
$obj = new MyTarget();
$eventManager = EventManager\StaticEventManager::getInstance();
$eventManager->attach('MyTarget', 'eventName', array($obj, 'eventReceiverMethod'));
$obj->doSomethingThatTriggersAnEvent();