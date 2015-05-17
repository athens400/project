<article class="article1">
<h1><?=$title?></h1>
 
<table>
    <tr>
        <th>Akronym</th><th>Namn</th><th>E-mail</th><th>Ångra borttagning</th><th>Ta bort permanent</th>
    </tr>
<?php foreach ($users as $user) : ?>
    <tr>
        <td><?=$user->acronym?></td>
        <td><?=$user->name?></td>
        <td><?=$user->email?></td>
        <td><a href="<?=$this->url->create("users/undelete/{$user->id}")?>">--></a></td>
        <td><a href="<?=$this->url->create("users/delete/{$user->id}")?>">--></a></td>
    </tr>
<?php endforeach; ?>
</table> 
</article>