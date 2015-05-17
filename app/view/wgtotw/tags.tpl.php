<div class="question_tags">
<?php foreach($tags as $tag) : ?>
            <a href="<?=$this->url->create("qa/list/tagged/{$tag->tag}")?>"><div class="question_tag"><i class="fa fa-tags"></i> <?=$tag->tag?></div></a>
<?php endforeach;?>
</div>