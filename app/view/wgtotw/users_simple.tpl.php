<table class="users_simple">
    <?php if(isset($title)) : ?>
    <thead>
        <tr>
            <th colspan="2"><h3><?=$title?></h3></th>
        </tr>
    </thead>
    <?php endif;?>
    <tbody>
        <?php foreach($users as $user) : ?>
        <tr class="user_simple">
            <td class="icon"><i class="fa fa-user fa-2x"></i></td><td><a href="<?=$this->url->create("users/id/{$user->id}")?>"><?=$user->acronym?></a></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>