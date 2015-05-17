<?php
namespace Anax\QA;

/**
 * A controller for comments and admin related events.
 *
 */
class QuestionsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
        \Anax\MVC\TRedirectHelpers,
        \Anax\Authenticate\TAuthenticate;
        
    private $questionsArray = array();
	
    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->questions = new \Anax\QA\Question();
        $this->questions->setDI($this->di);
        $this->tags = new \Anax\Tags\Tag();
        $this->tags->setDI($this->di);
    }
    
    /**
     * List all questions.
     *
     * @return void
     */
    public function viewAction($questionId = null)
    {
        $question = $this->questions->findWithOwner($questionId);
        $this->theme->setTitle($question->title);
        
        $this->views->add('wgtotw/question', [
            'question' => $question,
            'owner' => ($this->isOwner($question->userId) ? true : ($this->isAdmin() ? true : false))
        ]);
    }
    
    /**
     * Add question
     *
     * @return void
     */
    public function addAction()
    {      
        $this->theme->setTitle("Ställ en fråga");
        if($this->authenticateUser())
        {
            $form = new \Anax\HTMLForm\CFormQuestion();
            $form->setDI($this->di);
            $check = $form->check();
            if($check === true) 
            {
                $now = gmdate('Y-m-d H:i:s');
                
                $this->questions->save([
                    'title'     => $form->value('title'),
                    'text'      => $this->textFilter->doFilter($form->value('text'), 'markdown'),
                    'created'   => $now,
                    'userId'    => $this->getUserId()
                ]);
                
                $this->tags->save($form->value('tags'), $this->questions->id);
                
                //$url = $this->url->create((isset($redirect) ? $redirect : $pageId));
                $this->redirectTo('qa');
            }

            $this->di->views->add('wgtotw/form/form', [
                'content' => $form->getHTML(),
                'title'   => 'Ställ en fråga',
            ])              ->addString('add-question', 'bodyClass');
        }
        else
        {
            $this->message->notice('Du är inte inloggad!');
        }
        
        $this->views->add('wgtotw/sidemenu', [
            'links'  => [
                'Nyast frågor'          => $this->url->create("qa/list/latest/10"),
                'Frågor med flest svar' => $this->url->create("qa/list/answered/10"),
                'Ställ en fråga'        => $this->url->create("qa/add/question")
                ],
            ], 'sidebar'
        );
        $this->views->addString($this->message->getMessage(), 'flash');
    }
    
    /**
     * Edit question
     *
     * @param int $questionId
     *
     * @return void
     */
    public function editAction($questionId = null)
    {
        $this->theme->setTitle("Editera fråga");
        
        $question = $this->questions->find($questionId);
        
        if($this->authenticateUser())
        {
            if($this->isOwner($question->userId) or $this->isAdmin())
            {
                $strTags = null;
                $tags = $this->tags->findWhereQId($questionId);           // Create "findAsString" and let model do the data preparation
                foreach($tags as $tag)
                {
                    $strTags .= "#{$tag->tag} ";
                }
                
                $form = new \Anax\HTMLForm\CFormQuestion($question, $strTags);
                $form->setDI($this->di);
                $check = $form->check();
                if($check === true) 
                {
                    $this->questions->save([
                        'id'        => $questionId,
                        'title'     => $form->value('title'),
                        'text'      => $this->textFilter->doFilter($form->value('text'), 'markdown'),
                    ]);
                    
                    $this->tags->save($form->value('tags'), $questionId);
                    
                    //$url = $this->url->create((isset($redirect) ? $redirect : $pageId));
                    $this->response->redirect('');
                }

                $this->di->views->add('wgtotw/form/form', [
                    'content' => $form->getHTML(),
                    'title'   => 'Editera fråga',
                ]);
            }
            else
            {
                $this->message->notice('Du har inte tillåtelse att ändra innehållet.');
            }
        }
        else
        {
            $this->message->notice('Du är inte inloggad.');
        }
        $this->views->addString($this->message->getMessage(), 'flash');
    }
    
    /**
     * Delete question
     *
     * @param int $questionId
     *
     * @return void
     */
    public function deleteAction($questionId = null)
    {
        if($this->authenticateUser())   // Authenticate admin, authenticate user belonging?
        {
            $this->questions->delete($questionId);
        }
    }
    
    /**
     * List latest questions
     *
     * @param int $noOfQuestions
     *
     * @return void
     */
    public function latestAction($noOfQuestions = null)
    {
        $this->theme->setTitle("Nyast frågor");
        
        $this->views->add('wgtotw/questions', [
        'title'     => 'Nyast frågor',
        'questions' => $this->questions->findLatest($noOfQuestions)
        ])
                    ->addString('question-list', 'bodyClass');
    }
    
    /**
     * List most answered questions
     *
     * @param int $noOfQuestions
     *
     * @return void
     */
    public function answeredAction($noOfQuestions = null)
    {
        $this->theme->setTitle("Frågor med flest svar");
        
        $this->views->add('wgtotw/questions', [
        'title'     => 'Frågor med flest svar',
        'questions' => $this->questions->findAnswered($noOfQuestions)
        ])
                    ->addString('question-list', 'bodyClass');
    }
    
    /**
     * List questions tagged with $tag
     *
     * @param string $tag
     *
     * @return void
     */
    public function taggedAction($tag = null)
    {
        $this->theme->setTitle("Taggade frågor");
        
        $this->views->add('wgtotw/questions', [
        'title'     => "Frågor taggade med {$tag}",
        'questions' => $this->questions->findWhereTag($tag)
        ]);
    }
    
    /**
     * Simple list of latest quetions
     *
     * @return void
     */
    public function simpleAction($noOfQuestions = 5, $region = 'featured-1')
    {
        $this->views->add('wgtotw/questions_simple', [
        'title' => 'Nyast frågor',
        'questions' => $this->questions->findLatest($noOfQuestions)
        ], $region);
    }
    
    public function createdByAction($userId = null)
    {
        $this->views->add('wgtotw/questions', [
        'title'     => 'Frågor',
        'questions' => $this->questions->findWhereUserId($userId)
        ], 'sidebar');
    }
}