<table class="tags_simple">
    <?php if(isset($title)) : ?>
    <thead>
        <tr>
            <th colspan="2"><h3><?=$title?></h3></th>
        </tr>
    </thead>
    <?php endif;?>
    <tbody>
        <?php foreach($tags as $tag) : ?>
        <tr class="tag_simple">
            <td class="icon"><i class="fa fa-tags fa-2x"></i></td><td><a href="<?=$this->url->create("qa/list/tagged/{$tag->tag}")?>"><?=$tag->tag?></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>