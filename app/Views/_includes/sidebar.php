<?php
    use \Application\Auth;
    $type = Auth::getUser()->type ;
?>
<div class="card border-dark bg-dark">
    <div class="card-body text-white py-4 bg-dark text-center">
        <h6> <?= Auth::getUser()->login ?> / <?= Auth::getUser()->email ?> </h6>
        <span class="badge badge-warning"><?= soft_user_type(Auth::getUser()->type) ?></span>

        <br> Depuis le <span class="text-white"><?= Auth::getUser()->confirmed_at ?></span>
    </div>
    <div class="list-group">

        <a href="<?=  path_for('admin.home') ?>" class="clearfix list-group-item list-group-item-action bg-dark text-white">
            <span class="float-left">Tableau de bord</span>
            <span class="float-right"><i class="fa fa-cogs"></i></span>
        </a>

        <?php if( in_array($type,['admin']) ) : ?>
        <a href="<?=  path_for('users.index') ?>" class="clearfix list-group-item list-group-item-action bg-dark text-white">
            <span class="float-left">Utilisateurs</span>
            <span class="float-right"><i class="fa fa-users-cog"></i></span>
        </a>
        <?php endif;  ?>


    </div>
</div>