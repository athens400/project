<?php
namespace Anax\Tags;

/**
 * A controller for comments and admin related events.
 *
 */
class TagsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable,
        \Anax\MVC\TRedirectHelpers,
        \Anax\Authenticate\TAuthenticate;
	
    private $pattern = [
            '/\s/',
            '/å|Å/',
            '/ä|Ä/',
            '/ö|Ö/',
            '/^[^a-z0-9]+/i',
            '/[^a-z0-9]+$/i',
            '/[^a-z0-9-]/i'
        ];
        
    private $replace = [
            '-',
            'a',
            'a',
            'o',
            '',
            '',
            ''
        ];
    
    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->tags = new \Anax\Tags\Tag();
        $this->tags->setDI($this->di);
    }
    
    /**
     * Default action
     */
    public function indexAction()
    {
        $this->listAction();
    }
    
    /**
     * View tags where question id
     *
     * @param int $questionId
     *
     * @return void
     */
    public function viewAction($questionId = null)
    {
        $this->views->add('wgtotw/tags', [
            'tags'  => $this->tags->findWhereQId($questionId)
            ]);
    }
    
    /**
     * Save tags
     *
     * @param string $tags
     * @param int $questionId
     *
     * @return void
     */
    public function saveAction($tags = null, $questionId = null)
    {
        $this->tags->save($tags, $questionId);
    }
    
    /**
     * Delete question-tag relation
     *
     * @param int $questionId
     *
     * @return void
     */
    public function deleteQ2TAction($questionId = null)
    {
        $this->tags->deleteWhereQuestionId($questionId);
    }
    
    /**
     * Display simple tags list
     *
     * @param int $noOfTags
     * @param string $region to display in
     *
     * @return void
     */
    public function simpleAction($noOfTags = 5, $region = 'featured-2')
    {
        $this->views->add('wgtotw/tags_simple', [
        'title' => 'Populära taggar',
        'tags' => $this->tags->findPopular($noOfTags)
        ], $region);
    }
    
    /**
     * Display tags list
     *
     * @return void
     */
    public function listAction()
    {
        $this->theme->setTitle("Taggar");
        $tags = $this->tags->findAll();
        
        $this->views->add('wgtotw/plain', [
        'content'  => $this->htmlTable($tags)
        ]);
    }
    
    private function htmlTable($tags, $columns = 4)
    {
        $html = "<table class='gen-grid'>";
        $count = 0;
        foreach($tags as $tag)
        {
            $link = $this->url->create("qa/list/tagged") . "/{$tag->tag}";
            $count++;
            
            $html .= $count == 1 ? "<tr class='gen-grid-row'>" : null;
            
            $html .= <<<EOD
<td class="gen-grid-item"><a href="{$link}">
    <div class="gen-grid-item-header"><i class="fa fa-tags"></i> {$tag->tag}</div>
    <div class="gen-grid-item-body">{$tag->counter}st frågor</div>
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