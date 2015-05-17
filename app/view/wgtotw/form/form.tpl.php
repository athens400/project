<article class="form<?=(isset($class) ? " $class" : null)?>">
<?=(isset($title) ? "<h1>{$title}</h1>" : null )?>
<?=$content?>
<?php if(isset($output)) : ?>
    <div class="output">
        <?=$output?>
    </div>
<?php endif;?>
</article>
