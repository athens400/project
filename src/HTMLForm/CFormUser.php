<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormUser extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;


    /**
     * Constructor
     *
     */
    public function __construct($user = null)
    {
        parent::__construct([], [
            'acronym' => [
                'type'          => 'text',
                'label'         => 'Akronym',
                'value'         => (isset($user) ? (isset($user->acronym) ? $user->acronym : null) : null),
                'required'      => true,
                'validation'    => ['not_empty'],
            ],
            'email' => [
                'type'          => 'text',
                'label'         => 'Email',
                'value'         => (isset($user) ? (isset($user->email) ? $user->email : null) : null),
                'required'      => true,
                'validation'    => ['not_empty', 'email_adress'],
            ],
            'name' => [
                'type'          => 'text',
                'label'         => 'Namn',
                'value'         => (isset($user) ? (isset($user->name) ? $user->name : null) : null),
                'required'      => true,
                'validation'    => ['not_empty'],
            ],
            'password' => [
                'type'          => 'password',
                'label'         => 'Lösenord',
                'value'         => '',
                'required'      => true,
                'validation'    => ['not_empty'], 
            ],
            'passwordMatch' => [
                'type'          => 'password',
                'label'         => 'Bekräfta lösenord',
                'value'         => '',
                'required'      => true,
                'validation'    => ['not_empty', 'match' => 'password'],
            ],
            'submit' => [
                'type'          => 'submit',
                'value'         => 'Spara',
                'callback'      => [$this, 'callbackSubmit'],
            ],
        ]);
    }



    /**
     * Customise the check() method.
     *
     * @param callable $callIfSuccess handler to call if function returns true.
     * @param callable $callIfFail    handler to call if function returns true.
     */
    public function check($callIfSuccess = null, $callIfFail = null)
    {
        return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
    }



    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmit()
    {
        return true;
    }



    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFail()
    {
        $this->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
        return false;
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
        return true;
        //$this->redirectTo();
    }



    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {   
        $this->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        $this->redirectTo();
    }
}
