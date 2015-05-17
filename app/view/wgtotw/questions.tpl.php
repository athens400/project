<article class="questions-list">
<?php if(isset($title)) : ?>
<h2><?=$title?></h2>
<?php endif;?>
<table class="questions">
<?php foreach($questions as $question) : ?>
    <tr class="question">
        
        <td class="question_no_of_answers">
            <div class="meta_number"><?=$question->answers?></div>
            <div class="question_meta_text">svar</div>
        </td>
        
        <td class="question_body">
            <div class="question_title"><a href="<?=$this->url->create("qa/question/{$question->id}")?>"><?=$question->title?></a></div>
            <div class="question_tags">
            <?php foreach(explode(',', $question->tags) as $tag) : ?>
            <a href="<?=$this->url->create("qa/list/tagged/{$tag}")?>"><div class="question_tag"><i class="fa fa-tags"></i> <?=$tag?></div></a>
            <?php endforeach;?>
            </div>
        </td>
    </tr>
<?php endforeach;?>
</table>
</article>