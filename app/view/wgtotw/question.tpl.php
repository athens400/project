<div class="question">
    <div class="question_header">
        <span class="question_title"><h1><?=$question->title?></h1></span>
    </div>
    <div class="question_text"><?=$question->text?></div>
    <div>
        <div class="owner">
            <a href="<?=$this->url->create("users/id/{$question->userId}")?>">- <?=$question->acronym?></a> ställde frågan <?=$question->created?>
        </div>
        <div class="editicon">
            <?php if($owner) : ?>
            <a href="<?=$this->url->create("qa/edit/question/{$question->id}")?>"><i class="fa fa-wrench fa-2x"></i></a>
            <?php endif;?>
        </div>
    </div>
</div>