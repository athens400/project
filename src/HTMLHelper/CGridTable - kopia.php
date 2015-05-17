<?php
namespace Anax\HTMLHelper;

/**
 * Create grid layout
 *
 */
class CGridTable
{
    use \Anax\DI\TInjectable;
    
    private $html = "<div class='gen-grid'>";
    
    public function makeGrid($tags, $url, $columns = 5)
    {
        $count = 0;
        foreach($tags as $tag)
        {
            $tagName = $tag->tag;
            $tagCounter = $tag->counter;
            $tagId = $tag->id;
            $url = $url . "/{$tagName}";
            
            $count++;
            $this->html .= $count == 1 ? "<div class='gen-grid-row'>" : null;
            $this->html .= <<<EOD
<a href="{$url}"><div class="gen-grid-item">
    <div class="gen-grid-item-header"><i class="fa fa-tags"></i> {$tagName}</div>
    <div class="gen-grid-item-body">{$tagCounter}st frågor</div>
</div></a>
EOD;
            if($count == $columns)
            {
                $this->html .= "</div>";
                $count = 0;
            }
            
        }
        $this->html .= $count == 0 ? "</div></div>" : "</div>";
    }
    
    public function getHTML()
    {
        return $this->html;
    }
    
}