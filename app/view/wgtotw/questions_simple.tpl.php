<table class="questions_simple">
    <?php if(isset($title)) : ?>
    <thead>
        <tr>
            <th colspan="2"><h3><?=$title?></h3></th>
        </tr>
    </thead>
    <?php endif;?>
    <tbody>
        <?php foreach($questions as $question) : ?>
        <tr class="question_simple">
            <td class="icon"><i class="fa fa-question-circle fa-2x"></i></td><td><a href="<?=$this->url->create("qa/question/{$question->id}")?>"><?=$question->title?></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>