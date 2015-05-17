<div class="questions">
<?php foreach($questions as $question) : ?>
    <div class="question">
        <div class="question_meta">
            <div class="question_rank">
                <div class="meta_number">0</div>
                <div class="question_meta_text">rank</div>
            </div>
            <div class="question_no_of_answers">
                <div class="meta_number"><?=$question->answers?></div>
                <div class="question_meta_text">svar</div>
            </div>
        </div>
        <div class="question_body">
            <div class="question_title"><?=$question->title?></div>
            <div class="question_tags">
            <?php foreach(explode(',', $question->tags) as $tag) : ?>
            <a href="<?=$this->url->create("qa/list/tagged/{$tag}")?>"><?=$tag?></a>
            <?php endforeach;?>
            </div>
        </div>
    </div>
<?php endforeach;?>
</div>