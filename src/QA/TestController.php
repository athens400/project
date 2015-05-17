<?php
namespace Anax\QA;

/**
 * A controller for comments and admin related events.
 *
 */
class TestController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
        \Anax\MVC\TRedirectHelpers;
	
    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->questions = new Questions();
        $this->questions->setDI($this->di);
        $this->answers = new Answers();
        $this->answers->setDI($this->di);
        $this->comments = new Comments();
        $this->comments->setDI($this->di);
    }
    
    /**
     * List all questions.
     *
     * @return void
     */
    public function viewAction($pageId = null)
    {
        $questions = $this->questions->findLatest();
        
        foreach($questions as $question)
        {
        $this->views->add('wgtotw/question', [
            'question' => $question,
        ]);
        }
    }
    
    public function testAction()
    {
        echo "TEST";
    }
    
    public function latestAction($noOfQuestions = 10)
    {
        $questions = $this->questions->findLatest(11);
        var_dump($questions);
        foreach($questions as $question)
        {
            $this->di->views->add('wgtotw/question', [
                'question' => $question
            ]);
            $comments = $this->comments->findAll($question->id, 'Q');
            foreach($comments as $comment)
            {
                $this->di->views->add('wgtotw/comment', [
                'comment' => $comment
                ]);
            }
            $answers = $this->answers->findAll($question->id);
            foreach($answers as $answer)
            {
                $this->di->views->add('wgtotw/answer', [
                    'answer' => $answer
                ]);
                $comments = $this->comments->findAll($answer->id, 'A');
                foreach($comments as $comment)
                {
                    $this->di->views->add('wgtotw/comment', [
                    'comment' => $comment
                    ]);
                }
            }
        }
    }
    
}