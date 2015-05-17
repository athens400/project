<?php
namespace Anax\QA;

/**
 * A controller for comments and admin related events.
 *
 */
class CommentsController implements \Anax\DI\IInjectionAware
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
        $this->comments = new \Anax\QA\Comment();
        $this->comments->setDI($this->di);
    }

    /**
     * Find comments for question or answer
     *
     * @param int $qId
     * @param int $aId
     *
     * @return objects
     */
    public function findAction($qId = null, $aId = 0)
    {
        return $this->comments->findAll($qId, $aId);
    }
    
    /**
     * List all commments where qId and/or aId.
     *
     * @param int $qId
     * @param int $aId
     *
     * @return void
     */
    public function viewAction($qId = null, $aId = 0)
    {
        $this->views->add('wgtotw/comments', [
            'comments' => $this->comments->findAll($qId, $aId),
        ]);
    }
    
    /**
     * Show form to add comment.
     *
     * @param string $pageId to associate the comment with
     * @param string $redirect to after comment is added
     *
     * @return void
     */
    public function addAction($qId = null, $aId = 0)
    {
        if($this->authenticateUser())
        {
            $form = new \Anax\HTMLForm\CFormComments($qId, $aId);
            $form->setDI($this->di);
            $check = $form->check();
            
            if($check === true) {
                
                $now = gmdate('Y-m-d H:i:s');
                
                $this->comments->save([
                    'text'      => $form->value('text'),
                    'qId'       => $qId,
                    'aId'       => $aId,
                    'created'   => $now,
                    'userId'    => $this->getUserId()
                ]);
                
                $this->redirectTo();
            }
            
            $this->di->views->add('wgtotw/form/form', [
                'content'   => $form->getHTML(),
                'class'     => 'commentform'
            ]);
        }
    }
    
    
    /**
     * Delete comment
     *
     * @param int $id to identify comment to remove
     *
     * @return void
     */
    public function deleteAction ($param = null, $col = null)    // Add allowed array for $col
    {
        $this->comments->delete($param, $col);
    }
}