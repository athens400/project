<?php

namespace Anax\HTMLForm;

/**
 * Anax base class for wrapping sessions.
 *
 */
class CFormQuestion extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;


    /**
     * Constructor
     *
     */
    public function __construct($question = null, $tags = null)
    {
        parent::__construct([], [
            'title' => [
                'type'          => 'text',
                'label'         => 'Titel',
                'value'         => (isset($question) ? (isset($question->title) ? $question->title : null) : null),
                'required'      => true,
                'validation'    => ['not_empty'],
            ],
            'text' => [
                'type'          => 'textarea',
                'label'         => '',
                'value'         => (isset($question) ? (isset($question->text) ? $question->text : null) : null),
                'required'      => true,
                'validation'    => ['not_empty'],
            ],
            'tags' => [
                'type'          => 'text',
                'label'         => 'Taggar (börja varje tagg med #)',
                'value'         => (isset($tags) ? $tags : null),
                'required'      => true,
            ],
            'submit' => [
                'type'          => 'submit',
                'value'         => 'Ställ fråga',
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
