<?php if(isset($title)) : ?>
<h2><?=$title?></h2>
<?php endif;?>
<div class="sidemenu">
    <?php foreach($links as $link => $url) : ?>
    <p><a href="<?=$url?>"><span class="sidemenuitem"><?=$link?></span></a></p>
    <?php endforeach;?>
</div>