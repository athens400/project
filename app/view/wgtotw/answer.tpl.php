<div class="answer">
    <div class="answer_header">
        <h2><?php if(isset($answer->acronym)) : ?><a href="<?=$this->url->create("users/id/{$answer->userId}")?>"><?=$answer->acronym?>s</a> <?php endif;?>svar</h2>
    </div>
    <div class="answer_text">
        <?=$answer->text?>
        <?php if($owner) : ?>
        <div class="editicon">
            - <a href="<?=$this->url->create("qa/edit/answer/{$answer->id}")?>"><i class="fa fa-wrench"></i></a>
        </div>
        <?php endif;?>
    </div>
</div>