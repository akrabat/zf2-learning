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

    public function triggerEvent1()
    {
        $returnedResults = $this->eventManager->trigger('event1', $this);
        foreach ($returnedResults as $result) {
            echo "Result: $result\n";
        }
    }
    
    public function getEventManager()
    {
        return $this->eventManager;
    }
}


class MyListener implements EventManager\HandlerAggregate
{
    protected $eventHandlers = array();
    
    public function attach(EventManager\EventCollection $events)
    {
        $this->handlers[] = $events->attach('event1', array($this, 'doSomething'));
    }
    
    public function detach(EventManager\EventCollection $events)
    {
        foreach ($this->handlers as $key => $handler) {
            $events->detach($handler);
            unset($this->handlers[$key]);
        }
        $this->handlers = array();
    }
   
    public function doSomething(EventManager\Event $e)
    {
        echo "An event1 has happened! Event name = '" . $e->getName() . "'\n";
        return "Answer";
    }
    
    
}


$target = new MyTarget();

// Attach the target's event manager to the listener
$listener = new MyListener();
$listener->attach($target->getEventManager());

// Now we can trigger some events
$target->triggerEvent1();

