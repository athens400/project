<?php
namespace Anax\QA;

/**
 * Middlelayer controller connecting controllers for answers, questions and comments
 *
 */
class Testmodel implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
        \Anax\MVC\TRedirectHelpers;
        
        
        
    public function initialize()
    {
        $di->set('Questions', function() use ($di) {
            $questions = new \Anax\QA\Questions();
            $questions->setDI($di);
            return $questions;
        });
    }
        
    public function latestAction($noOfQuestions = 10)
    {
        $questions = $this->questions->findLatest($noOfQuestions);
        
        foreach($questions as $question)
        {
            echo "fråga";
            $comments = $this->comments->findAll($question->id, 'Q');
            foreach($comments as $comment)
            {
                echo "kommentar";
            }
            $answers = $this->answers->findAll($question->id);
            foreach($answers as $answer)
            {
                echo "svar";
                $comments = $this->comments->findAll($answer->id, 'A');
                foreach($comments as $comment)
                {
                    "kommentar";
                }
            }
        }
    }
      
    public function testAction()
    {
        echo "QA-TEST";
    }
        
}