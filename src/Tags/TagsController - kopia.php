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
    
    public function saveAction()
    {
        $tags = ['tag7', 'tag8'];
        $this->tags->save($tags, 1);
    }
    
    public function tagsActions()
    {
        $tags = "#tag1 #tag4 #tag2. #tag3, tag4 #tag5! ? ; : * ' ¨ ´ + /";
        echo "tags";
    }
    
    public function testAction()
    {
        $tags = "#tag1 #tag4 #tag2. #tag3, tag4 #tag5! ? ; : * ' ¨ ´ + /";
        //$tags = "#tag-1-";
        $tagsarray
        
        
        echo "$tags <br/>";
        $pattern = [
            '/^[-]/',
            '/[-]$/',
            '/[\#+]+[^a-z0-9-]/i'
        ];
        
        $replace = [
            '',
            '',
            ''
        ];
        $all = "/^[-]|[^a-z0-9-]|[-]$/i";
        
        $tags = preg_replace($pattern, $replace, $tags);
        echo "$tags <br/>";
        
        echo preg_match('/^#/', $tags);
    }
    
}