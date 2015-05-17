<?php
namespace Anax\QA;

/**
 * A controller for comments and admin related events.
 *
 */
class AnswersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
        \Anax\MVC\TRedirectHelpers,
        \Anax\Authenticate\TAuthenticate;
	
    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->answers = new \Anax\QA\Answer();
        $this->answers->setDI($this->di);
    }
    
    /**
     * Find answers based on question id
     *
     * @param int $questionId
     * 
     * @return objects
     */
    public function findAction($questionId)
    {
        return $this->answers->findAll($questionId);
    }
    
    /**
     * List all answers.
     *
     * @return void
     */
    public function viewAction($answerId = null)
    {
        
        $this->views->add('wgtotw/answer', [
            'answer' => $this->answers->find($answerId),
        ]);
    }
    
    /**
     * Display all answers and corresponding comments based on question id
     *
     * @param int $questionId
     *
     * return void
     */
    public function viewAllAction($questionId = null)
    {
        $answers = $this->answers->findAll($questionId);
        
        foreach($answers as $answer)
        {
        $this->views->add('wgtotw/answer', [
            'answer' => $answer,
            'owner' => ($this->isOwner($answer->userId) ? true : ($this->isAdmin() ? true : false))
        ]);
        
        $this->dispatcher->forward([
                'controller'    => 'comments',
                'action'        => 'view',
                'params'        => [$questionId, $answer->id]
            ]);
            
        $this->dispatcher->forward([
                'controller'    => 'comments',
                'action'        => 'add',
                'params'        => [$questionId, $answer->id]
            ]);
        
        }
    }
    
    /**
     * Add answer
     * 
     * @param int $questionId
     *
     * @return void
     */
    public function addAction($qId)
    {
        $form = new \Anax\HTMLForm\CFormAnswer();
        $form->setDI($this->di);
        $check = $form->check();
        if($check === true) 
        {
            if($this->authenticateUser())
            {
            $now = gmdate('Y-m-d H:i:s');
            
            $this->answers->save([
                'text'      => $this->textFilter->doFilter($form->value('text'), 'markdown'),
                'qId'       => $qId,
                'created'   => $now,
                'userId'    => $this->getUserId()
            ]);
            
            $this->redirectTo();
            }
            else 
            { 
                $this->message->notice('Du är inte inloggad!');
            }
        }

        $this->di->views->add('wgtotw/form/form', [
            'content' => $form->getHTML(),
            'title'   => 'Ditt svar',
            'class'   => 'answer-form'
        ]);
        
        $this->views->addString($this->message->getMessage(), 'flash');
    }
    
    /**
     * Edit answer
     *
     * @param int $answerId
     *
     * @return void
     */
    public function editAction($answerId = null)
    {
        $answer = $this->answers->find($answerId);
        
        $form = new \Anax\HTMLForm\CFormAnswer($answer);
        $form->setDI($this->di);
        $check = $form->check();
        if($check === true) 
        {
            if($this->authenticateUser())
            {
            $now = gmdate('Y-m-d H:i:s');
            
            $this->answers->save([
                'id'        => $answerId,
                'text'      => $this->textFilter->doFilter($form->value('text'), 'markdown'),
            ]);
            
            //$url = $this->url->create((isset($redirect) ? $redirect : $pageId));
            $this->response->redirect('');
            }
            else 
            { 
                die("Not authorized (REPLACE WITH FLASH MESSAGE)");
            }
        }

        $this->di->views->add('comment/form', [
            'content' => $form->getHTML(),
            'title'   => 'Ditt svar',
        ]);
    }
    
    /**
     * Delete answer
     *
     * @param mixed $param value
     * @param string $col column
     *
     * @return void
     */
    public function deleteAction($param = null, $col = null)
    {
        if($this->authenticateUser())
        {
            $this->answers->delete($param, $col);
        }
    }
}