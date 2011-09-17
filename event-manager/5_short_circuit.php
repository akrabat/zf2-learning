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
        $params = compact('value1', 'value2');
        $returnedResults = $this->eventManager->triggerUntil('event1', $this, $params,
            function ($result) {
                echo "closure: $result\n";
                if($result == 'Answer1') {
                    return true;
                }
                return false;
            }
        );
        foreach ($returnedResults as $result) {
            echo "Result: $result\n";
        }
    }
    
    public function getEventManager()
    {
        return $this->eventManager;
    }
}


class MyListener
{
    public function attach(EventManager\EventCollection $events)
    {
        $events->attach('event1', array($this, 'doSomething1'));
        $events->attach('event1', array($this, 'doSomething2'));
    }
    
    public function doSomething1(EventManager\Event $e)
    {
        echo "An event1 has happened in doSomething1!\n";
        return "Answer1";
    }
    public function doSomething2(EventManager\Event $e)
    {
        echo "An event1 has happened in doSomething2!\n";
        return "Answer2";
    }
    
    
}


$target = new MyTarget();

// Attach the target's event manager to the listener
$listener = new MyListener();
$listener->attach($target->getEventManager());

// Now we can trigger some events
$target->triggerEvent1();

