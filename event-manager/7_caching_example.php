<?php

include __DIR__ . "/../load_zf.php";

use Zend\EventManager;

class MyModel
{
    /**
	 * @var EventManager
	 */
	protected $eventManager;
    
    public function __construct()
    {
        $this->eventManager = new EventManager\EventManager(array(__CLASS__, get_called_class()));
    }
    
    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function getData($id)
    {
        $params = array('id' => $id);
        
        // Trigger pre event
        $results = $this->eventManager->triggerUntil(__FUNCTION__.'.pre', $this, $params,
            function ($result) {
                // If we get an array, then we have the cached results back
                return is_array($result);
            }
        );
        if ($results->stopped()) {
            // We ended early, so last result is our data
            return $results->last();
        }
        
        // Do the work
        echo "Doing some work\n";
        sleep(2);
        $data = array(1,2,3);
        
        // Trigger post event
        $params['__RESULT__'] = $data;
        $this->events()->trigger(__FUNCTION__ . '.post', $this, $params);
        
        return $data;
    }
    
}


class MyLogger
{
    public function attach(EventManager\EventCollection $events)
    {
        $events->attach('getData.pre', array($this, 'log'));
    }
    
    public function log(EventManager\Event $e)
    {
        $name = $e->getName();
        $id = $e->getParam('id');
        echo "Logging: $name, $id\n";
    }
}


$model = new MyModel();

// Attach the logger's listener to the model
$logger = new MyLogger();
$logger->attach($model->getEventManager());

// Now we get our data
$model->getData(1);

