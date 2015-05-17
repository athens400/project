<?php

namespace Anax\DI;

class CDIFactory extends CDIFactoryDefault
{
    public function __construct()
	{   
		parent::__construct();
		$this->set('form', '\Mos\HTMLForm\CForm');
        
        $this->set('authenticate', function () {
            $authenticate = new \Anax\Authenticate\CAuthenticate();
            $authenticate->setDI($this);
            return $authenticate;
        });
        
        $this->set('CommentsController', function() {
            $controller = new \Anax\QA\CommentsController();
            $controller->setDI($this);
            return $controller;
        });

        $this->set('AnswersController', function() {
            $controller = new \Anax\QA\AnswersController();
            $controller->setDI($this);
            return $controller;
        });

        $this->set('QuestionsController', function() {
            $controller = new \Anax\QA\QuestionsController();
            $controller->setDI($this);
            return $controller;
        });

        $this->set('QaController', function() {
            $controller = new \Anax\QA\QAController();
            $controller->setDI($this);
            return $controller;
        });

        $this->set('TagsController', function() {
            $controller = new \Anax\Tags\TagsController();
            $controller->setDI($this);
            return $controller;
        });

        $this->set('UsersController', function () {
            $controller = new \Anax\Users\UsersController();
            $controller->setDI($this);
            return $controller;
        });
                
        $this->set('message', function() {
            $message = new \Ath400\Flash\CFlashAnax();
            $message->setDI($this);
            return $message;
        });
        
	}
}