<article class="article1">
<?=(isset($title) ? "<h1>{$title}</h1>" : null )?>
<?=$content?>
 
<?php if(isset($byline)) : ?>
<footer class="byline">
<?=$byline?>
</footer>
<?php endif; ?>
 
</article>