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
        $this->eventManager->trigger(__FUNCTION__ . '.post', $this, $params);
        
        return $data;
    }
    
}


class MyLogger
{
    public function attach(EventManager\EventCollection $events)
    {
        $events->attach('getData.pre', array($this, 'log'), 100);
    }
    
    public function log(EventManager\Event $e)
    {
        $name = $e->getName();
        $id = $e->getParam('id');
        echo "Logging: event: $name, id: $id\n";
    }
}

class MyCache
{
    public function attach(EventManager\EventCollection $events)
    {
        $events->attach('getData.pre', array($this, 'getCache'));
        $events->attach('getData.post', array($this, 'saveCache'));
    }
    
    public function getCache(EventManager\Event $e)
    {
        $id = $e->getParam('id');
        if ($id == 23) {
            echo "We have a cache for $id already\n";
            return array(1,2,3);
        }
        return null;
    }
    
    public function saveCache(EventManager\Event $e)
    {
        $id = $e->getParam('id');
        echo "Saving cache for id $id\n";
        return null;
    }
}


$model = new MyModel();

// Attach the cache's listeners to the model
$logger = new MyLogger();
$logger->attach($model->getEventManager());

// Attach the logger's listener to the model
$cache = new MyCache();
$cache->attach($model->getEventManager());

// Now we get our data
$model->getData(1);
$model->getData(23);
$model->getData(2);

