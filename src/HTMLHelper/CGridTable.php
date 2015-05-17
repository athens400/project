<?php
namespace Anax\HTMLHelper;

/**
 * Create grid layout
 *
 */
class CGridTable
{
    use \Anax\DI\TInjectable;
    
    private $html = "<table class='gen-grid'>";
    
    public function makeGrid($tags, $url, $columns = 5)
    {
        $count = 0;
        foreach($tags as $tag)
        {
            $tagName = $tag->tag;
            $tagCounter = $tag->counter;
            $tagId = $tag->id;
            $link = $url . "/{$tagName}";
            
            $count++;
            $this->html .= $count == 1 ? "<tr class='gen-grid-row'>" : null;
            $this->html .= <<<EOD
<td class="gen-grid-item"><a href="{$link}">
    <div class="gen-grid-item-header"><i class="fa fa-tags"></i> {$tagName}</div>
    <div class="gen-grid-item-body">{$tagCounter}st frågor</div>
</a></td>
EOD;
            if($count == $columns)
            {
                $this->html .= "</tr>";
                $count = 0;
            }
            
        }
        $this->html .= $count == 0 ? "</tr></table>" : "</table>";
    }
    
    public function getHTML()
    {
        return $this->html;
    }
    
}