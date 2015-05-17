<div class="comments">
<?php foreach($comments as $comment) : ?>
    <div class="comment">
        <div class="comment_text">
            <i class="fa fa-comment-o"></i> &#8211; <?=$comment->text?> &#8211; 
            <a href="<?=$this->url->create("users/id/{$comment->userId}")?>"><?=$comment->acronym?></a>
        </div>
    </div>
<?php endforeach;?>
    <div class="comment"></div>
</div>