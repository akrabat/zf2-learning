<?php

namespace Application;

use Zend\Config\Config,
    Zf2Mvc\Application,
    Zf2Mvc\Router\Http\Literal,
    Zend\Di,
    Zend\Di\Definition,
    Zend\Di\Definition\Builder,
    Zend\Di\DependencyInjector;

class Bootstrap
{
    protected $config;
    
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function bootstrap(Application $app)
    {
        $app->setLocator($this->setupLocator());
        $app->setRouter($this->setupRoutes($app->getLocator()));
        $this->setupEvents($app);
    }

    protected function setupLocator()
    {
        /**
         * Instantiate and configure a DependencyInjector instance, or 
         * a ServiceLocator, and return it.
         */

        $definition = new Definition\AggregateDefinition;
        $di = new DependencyInjector;
        $di->setDefinition($definition);
        
        $config = new Di\Configuration($this->config->di);
        $config->configure($di);
        $di->getDefinition()->addDefinition(new Definition\RuntimeDefinition);
        
        return $di;
    }

    protected function setupRoutes(DependencyInjector $di)
    {
        /**
         * Pull the routing table from configuration, and pass it to the
         * router composed in the Application instance.
         */
        $router = $di->get('router');
        return $router;
    }

    protected function setupEvents(Application $app)
    {
        /**
         * Wire events into the Application's EventManager, and/or setup
         * static listeners for events that may be invoked.
         */
    }
}