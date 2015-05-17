<?php
$gravatarHash = md5( strtolower( trim( $user->email ) ) );
?>

<article class="article1">
<h1><?=$title?></h1>
 
<div class='user_headings'>
    <p><img src="http://www.gravatar.com/avatar/<?=$gravatarHash?>"></p>
    <p>Id:</p>
    <p>Akronym:</p>
    <p>Namn:</p>
    <p>E-mail:</p>
    <p>Skapades:</p>
    <p>Borttagen:</p>
    <p>Aktiv:</p>
</div>
<div class='user_info'>
    <p><?=$user->id?>&nbsp;</p>
    <p><?=$user->acronym?>&nbsp;</p>
    <p><?=$user->name?>&nbsp;</p>
    <p><?=$user->email?>&nbsp;</p>
    <p><?=$user->created?>&nbsp;</p>
    <p><?=isset($user->deleted) ? $user->deleted : 'Nej'?></p>
    <p><?=isset($user->active) ? "Ja ({$user->active})" : 'Nej'?></p>
</div>
 
<p><a href='<?=$this->url->create('users/update/' . $user->id)?>'>Uppdatera</a></p>
<p><a href='<?=$this->url->create('users/softDelete/' . $user->id)?>'>Ta bort (soft delete)</a></p>
<p><a href='<?=$this->url->create('users/deactivate/' . $user->id)?>'>Inaktivera</a></p>
</article>