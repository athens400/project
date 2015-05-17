<div class="tags-grid">
<?php foreach($tags as $tag) : ?>
    <a href="<?=$this->url->create("qa/list/tagged/{$tag->tag}")?>">
        <div class="tags-grid-item">
            <div class="tag-tag"><i class="fa fa-tags"></i> <?=$tag->tag?></div>
            <div class="tag-counter"><?=$tag->counter?></div>
        </div>
    </a>
<?php endforeach;?>
</div>