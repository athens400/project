<?php
namespace Anax\Users;

/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
        \Anax\MVC\TRedirectHelpers,
        \Anax\Authenticate\TAuthenticate,
        \Anax\Users\TGravatar;
	
    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->session();
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
    }

    /**
     * Default action
     */
    public function indexAction()
    {
        $this->listAction();
    }
    
    /**
     * Login in user
     *
     * @return void
     */
    public function loginAction()
    {
        $this->theme->setTitle("Login");
        $this->views->addString($this->message->getMessage(), 'flash');
        
        $form = new \Anax\HTMLForm\CFormLogin();
        $check = $form->check();
        
        if($check === true) 
        {
            $user = $this->users->login([
                'acronym' => $form->value('acronym'),
                'password' => $form->value('password')
            ]);
            $this->redirectTo('');
        }
        $this->di->views->add('wgtotw/page', [
            'content'   => $form->getHTML(),
            'output'    => ($this->authenticate->isAuthenticated() ? "Du är inloggad." : null)
        ])              ->addString('users-login', 'bodyClass');
    }
    
    /**
     * Logout user
     *
     * @return void
     */
    public function logoutAction()
    {
        $this->users->logout();
        $this->redirectTo('');
    }
    
    /**
     * List all users.
     *
     * @return void
     */
    public function listAction()
    {
        $this->theme->setTitle("Alla användare");
        $users = $this->users->findAll();
        
        $this->views->add('wgtotw/plain', [
        'content'  => $this->htmlTable($users)
        ]);
    }

    public function idAction($id = null)
    {
        $user = $this->users->find($id);
        
        $owner = $this->isOwner($user->id) ? true : ($this->isAdmin() ? true : false);
        
        $this->theme->setTitle("Användarinformation");
        $this->views->add('wgtotw/user', [
            'user' => $user,
            'owner' => $owner,
            'gravatar' => $this->getGravatarUrl($user->email),
            'title' => "Användarinformation",
        ]);
        
        $this->views->addString('user', 'bodyClass');
        
        $this->dispatcher->forward([
            'controller' => 'questions',
            'action'     => 'createdBy',
            'params'     => [$id]
        ]);
    }
    
    public function simpleAction($noOfUsers = 5, $region = 'featured-3')
    {
        $this->views->add('wgtotw/users_simple', [
        'title' => 'Aktivast användare',
        'users' => $this->users->findMostActive($noOfUsers)
        ], $region);
    }
    
    
    
    /**
     * Add new user.
     *
     * @param string $acronym of user to add.
     *
     * @return void
     */
    public function addAction($fail = null)
    {
        $this->di->session();
        
        $addUserFail = $fail ? ($this->session->has('addUserFail') ? $this->session->get('addUserFail') : null) : null;
        
        $form = new \Anax\HTMLForm\CFormUser($addUserFail);
        $form->setDI($this->di);
        $check = $form->check();
        
        if($check === true) {
            if($this->users->userExists($form->value('acronym'))) {
                $addUserFail = new \StdClass();         // Standard 'empty' class, mocks user object if add user is fail
                $addUserFail->name = $form->value('name'); 
                $addUserFail->email = $form->value('email');
                
                $this->session->set('addUserFail', $addUserFail);
                $this->message->notice('Akronymen "' . $form->value('acronym') . '" är upptagen.');
                $this->redirectTo('users/add/fail');
            } else { 
                if($this->session->has('addUserFail')) {
                    $this->session->set('addUserFail', null);
                }
            
                $now = gmdate('Y-m-d H:i:s');
     
                $this->users->save([
                    'acronym' => $form->value('acronym'),
                    'name' => $form->value('name'),
                    'email' => $form->value('email'),
                    'password' => password_hash($form->value('password'), PASSWORD_DEFAULT),
                    'created' => $now,
                    'updated' => $now,
                    'active' => $now,
                ]);
                $this->message->success('Du är nu registrerad och kan logga in.');
                $this->redirectTo('users/login');
            }
        }
        
        $this->theme->setTitle("Registrera användare");
        $this->views->addString($this->message->getMessage(), 'flash');
        $this->di->views->add('wgtotw/page', [
            'title' => "Registrera användare",
            'content' => $form->getHTML()
        ]);
    }
    
    /**
     * Update user.
     *
     * @param integer $id of user to update.
     *
     * @return void
     */
    public function updateAction($id = null)
    {
        if($id == null) { $this->redirectTo('users/list'); }
        $this->di->session();
        
        $user = $this->users->find($id);
        
        if($this->isOwner($id) or $this->isAdmin())
        {
            $form = new \Anax\HTMLForm\CFormUser($user, true);
            $form->setDI($this->di);
            $check = $form->check();

            if($check === true) {
                $redirect = null;
                $now = gmdate('Y-m-d H:i:s');
                $this->users->save([ 
                                    'id'       => $id,
                                    'acronym'  => $form->value('acronym'),
                                    'name'     => $form->value('name'),
                                    'email'    => $form->value('email'),
                                    'password' => password_hash($form->value('password'), PASSWORD_DEFAULT),
                                    'updated' => $now,
                            ]);
                $this->redirectTo("users/id/$id/");
            }

            $this->theme->setTitle("Uppdatera användare");
            $this->di->views->add('grid/page', [
                'title' => "Uppdatera användare",
                'content' => $form->getHTML()
            ]);
        }
        else
        {
            $this->message->notice('Du är inte inloggad eller har inte tillåtelse att ändra innehållet');
            $this->redirectTo('users/login');
        }
    }
    
    /**
     * Delete user.
     *
     * @param integer $id of user to delete.
     *
     * @return void
     */
    public function deleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }
        
        if($this->isOwner($id) or $this->isAdmin())
        {
            if($id == 1)
            {
                $this->message->error('Du kan inte ta bort admin');
                $this->redirectTo('');
            }
            $res = $this->users->delete($id);
            $this->logoutAction();
        }
        else
        {
            $this->message->notice('Du är inte inloggad eller har inte tillåtelse att ändra innehållet');
            $this->redirectTo('users/login');
        }
    }
    
    private function htmlTable($users, $columns = 4)
    {
        $html = "<table class='gen-grid'>";
        $count = 0;
        foreach($users as $user)
        {
            $link = $this->url->create("users/id") . "/{$user->id}";
            $count++;
            
            $html .= $count == 1 ? "<tr class='gen-grid-row'>" : null;
            
            $html .= <<<EOD
<td class="gen-grid-item"><a href="{$link}">
    <div class="gen-grid-item-header"><i class="fa fa-user"></i> {$user->acronym}</div>
    <div class="gen-grid-item-body">{$user->counter}st frågor</div>
</a></td>
EOD;

            if($count == $columns)
            {
                $html .= "</tr>";
                $count = 0;
            }
            
        }
        $html .= $count == 0 ? "</tr></table>" : "</table>";
        
        return $html;
    }
}
