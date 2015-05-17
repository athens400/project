<?php
namespace Anax\HTMLHelper;

/**
 * Preparing QA with HTML elements
 *
 */
class QAHTMLHelper
{
    use \Anax\DI\TInjectable;
    
    private $html = null;
    
    public function setHTMLq($question)
    {
        $this->html .= <<<EOD
<div class="question">
    <div class="question_header">
        FRÅGA
        <span class="question_id">{$question->id}</span>
        <span class="question_title">{$question->title}</span>
    </div>
    <div class="question_text">{$question->text}</div>
</div>
EOD;
    }
    
    public function setHTMLa($answer)
    {
        $this->html .= <<<EOD
<div class="answer">
    <div class="answer_header">
        SVAR
    </div>
    <div class="answer_text">{$answer->text}</div>
</div>
EOD;
    }
    
    public function setHTMLc($comment)
    {
        $this->html .= <<<EOD
<div class="comment">
    <div class="comment_header">
        KOMMENTAR
    </div>
    <div class="comment_text">{$comment->text}</div>
</div>
EOD;
    }
    
    public function getHTML()
    {
        return $this->html;
    }
    
}