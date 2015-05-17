<div id="above-header-links">
    <?php if($authenticated) :?>
    <a href="<?=$this->url->create('users/logout/')?>">Logga ut</a> | <a href="<?=$this->url->create("users/id/{$id}")?>">Min sida</a>
    <?php else :?>
    <a href="<?=$this->url->create('users/login/')?>">Logga in</a> | <a href="<?=$this->url->create('users/add/')?>">Registrera användare</a>
    <?php endif;?>
</div>