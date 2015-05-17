<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormComments extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;


    /**
     * Constructor
     *
     */
    public function __construct($qId = null, $aId = null, $comment = null)
    {
        parent::__construct([], [
            'text' => [
                'type'          => 'text',
                'value'         => (isset($comment) ? (isset($comment->text) ? $comment->text : null) : null),
                'placeholder'   => 'Kommentera',
                'validation'    => ['not_empty'],
            ],
            "submit_comment{$qId}{$aId}" => [
                'type'          => 'submit',
                'value'         => 'Kommentera',
                'name'          => 'SUBMIT',
                'callback'      => [$this, 'callbackSubmit'],
            ]
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
        die();
        return false;
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
        return true;
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
