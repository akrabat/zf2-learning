<?php

namespace HelloWorld\Controller;

use Zf2Mvc\Controller\ActionController;

class HelloController extends ActionController
{
    public function indexAction()
    {
        $response = $this->response; /* @var $response Zend\Http\Response */
        $response->setContent('Hello World');
        
    }
}