<article class="article1">
<h1><?=$title?></h1>
 
<div class='user_headings'>
    <?php if(isset($gravatar)) : ?>
    <p><img src="<?=$gravatar?>" /></p>
    <?php endif;?>
    <p>Id:</p>
    <p>Akronym:</p>
    <p>Namn:</p>
    <p>E-mail:</p>
    <p>Skapades:</p>
</div>
<div class='user_info'>
    <p><?=$user->id?>&nbsp;</p>
    <p><?=$user->acronym?>&nbsp;</p>
    <p><?=$user->name?>&nbsp;</p>
    <p><?=$user->email?>&nbsp;</p>
    <p><?=$user->created?>&nbsp;</p>
</div>
 
<?php if($owner) : ?>
<p><a href='<?=$this->url->create('users/update/' . $user->id)?>'>Uppdatera användare</a></p>
<p><a href='<?=$this->url->create('users/delete/' . $user->id)?>'>Ta bort användare</a></p>
<?php endif;?>
</article>