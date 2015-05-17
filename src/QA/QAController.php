<?php
namespace Anax\QA;

/**
 * Middlelayer controller connecting controllers for answers, questions and comments
 *
 */
class QAController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
        \Anax\MVC\TRedirectHelpers,
        \Anax\Authenticate\TAuthenticate;
        
    public function initialize()
    {
        $this->htmlhelper = new \Anax\HTMLHelper\QAHTMLHelper();
        $this->htmlhelper->setDI($this->di);
    }
     
    /**
     * Default action
     *
     *@return void
     */
    public function indexAction()
    {
        $this->theme->setTitle("Frågor");
	
        $this->listAction('latest');
    }
     
     /**
      * List latest questions      //Obsolete
      *
      * @param int $noOfQuestions
      *
      * @return void
      */
    public function latestAction($noOfQuestions = 10)
    {
        $questions = $this->dispatcher->forward([
            'controller' => 'questions',
            'action'     => 'latest',
            'params'     => [$noOfQuestions]
        ]);
        foreach($questions as $question)
        {
            $this->htmlhelper->setHTMLq($question);
            $comments = $this->dispatcher->forward([
                'controller' => 'comments',
                'action'     => 'find',
                'params'     => [$question->id]
            ]);
            foreach($comments as $comment)
            {
                $this->htmlhelper->setHTMLc($comment);
            }
            $answers = $this->dispatcher->forward([
                'controller' => 'answers',
                'action'     => 'find',
                'params'     => [$question->id]
            ]);
            foreach($answers as $answer)
            {
                $this->htmlhelper->setHTMLa($answer);
                $comments = $this->dispatcher->forward([
                'controller' => 'comments',
                'action'     => 'find',
                'params'     => [$question->id, $answer->id]
                ]);
                foreach($comments as $comment)
                {
                    $this->htmlhelper->setHTMLc($comment);
                }
            }
        }

        return $this->htmlhelper->getHTML();
    }
    
    /**
     * Dispatch list action request to QuestionsController
     *
     * @param string $list action
     * @param mixed $param1
     * @param mixed $param2
     *
     * @return void
     */
    public function listAction($list = 'latest', $param1 = null, $param2 = null)
    {
        
        $this->dispatcher->forward([
            'controller' => 'questions',
            'action'     => $list,
            'params'     => [$param1, $param2]
        ]);
        
        
        $this->views->add('wgtotw/sidemenu', [
            'links'  => [
                'Nyast frågor'          => $this->url->create("qa/list/latest"),
                'Frågor med flest svar' => $this->url->create("qa/list/answered"),
                'Ställ en fråga'        => $this->url->create("qa/add/question")
                ],
            ], 'sidebar'
        );
    }
    
    /**
     * Show question with answers and comments
     *
     * @param int $questionId
     *
     * @return void
     */
    public function questionAction($questionId = null)
    {
        is_null($questionId) ? die("Vi kan inte hitta frågan utan ett id") : null;
        
        $this->views->addString('question', 'bodyClass')
                    ->addString($this->message->getMessage(), 'flash');
        
        $this->dispatcher->forward([
            'controller'    => 'questions',
            'action'        => 'view',
            'params'        => [$questionId]
        ]);
        
        $this->dispatcher->forward([
            'controller'    => 'tags',
            'action'        => 'view',
            'params'        => [$questionId]
        ]);
            
        $this->dispatcher->forward([
            'controller'    => 'comments',
            'action'        => 'view',
            'params'        => [$questionId]
        ]);
        
        
        $this->dispatcher->forward([
            'controller'    => 'comments',
            'action'        => 'add',
            'params'        => [$questionId]
        ]);
        
        
        $answers = $this->dispatcher->forward([
            'controller'    => 'answers',
            'action'        => 'viewAll',
            'params'        => [$questionId]
        ]);
     
        $this->dispatcher->forward([
            'controller'    => 'answers',
            'action'        => 'add',
            'params'        => [$questionId]
        ]);
        
        $this->views->add('wgtotw/sidemenu', [
            'links'  => [
                'Nyast frågor'          => $this->url->create("qa/list/latest/10"),
                'Frågor med flest svar' => $this->url->create("qa/list/answered/10"),
                'Ställ en fråga'        => $this->url->create("qa/add/question")
                ],
            ], 'sidebar'
        );
    }
    
    /**
     * Add something
     *
     * @param string $whatToAdd controller
     * @param int $qId
     * @param int $aId
     *
     * @return void
     */
    public function addAction($whatToAdd = 'question', $qId = null, $aId = null)
    {
        $this->dispatcher->forward([
            'controller'    => "{$whatToAdd}s",
            'action'        => 'add',
            'params'        => [$qId, $aId]
        ]);
    }
    
    /**
     * Edit something
     *
     * @param string $whatToEdit controller
     * @param int $id
     *
     * @return void
     */
    public function editAction($whatToEdit = null, $id)
    {
        $this->dispatcher->forward([
            'controller'    => "{$whatToEdit}s",
            'action'        => 'edit',
            'params'        => [$id]
        ]);
    }
     
    /**
     * Delete something. Deleting question deletes tag-relations, answers and comments as well
     *
     * @param string $whatToDelete controller.
     * @param mixed $param1
     * @param miced $param2
     *
     * @return void
     */
    public function deleteAction($whatToDelete = null, $param1 = null, $param2 = null)
    {
        if($whatToDelete == 'question')
        {
            $this->dispatcher->forward([
                'controller'    => 'tags',
                'action'        => 'deleteQ2T',
                'params'        => [$param1]
            ]);
            
            $this->dispatcher->forward([
                'controller'    => 'questions',
                'action'        => 'delete',
                'params'        => [$param1]
            ]);
            
            $this->deleteAction('answer', $param1, 'qId');
            $this->deleteAction('comment', $param1, 'qId');
            
        }
        else
        {
            $this->dispatcher->forward([
                'controller'    => "{$whatToDelete}s",
                'action'        => 'delete',
                'params'        => [$param1, $param2]
            ]);
        }
    }        
}