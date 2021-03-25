<?php use \Application\Auth; ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-0">
    <a class="navbar-brand" href="<?=  path_for('admin.home') ?>"> <?= app_config('APP_NAME') ?>  </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a href="#"  class="nav-link dropdown-toggle text-white"  id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= Auth::getUser()->name ?>  <span class="badge badge-warning"><?= soft_user_type(Auth::getUser()->type) ?></span>
                </a>
                <div  class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
                    <a class="dropdown-item" data-animated-modal href="#_account_edit" >Compte</a>
                    <a onclick="return confirm('Vous allez être déconnecter')" class="dropdown-item"
                       href="<?= path_for('logout') ?>">Déconnexion</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<?php modal_tags("_account_edit","Editer mon profil"); ?>
            <form action="<?= path_for('account.edit') ?>" method="post">
                <div class="row">
                    <div class="col-lg-12">
                        <?php  text_field('name','Nom utilisateur',Auth::getUser()->name)  ?>
                    </div>
                    <div class="col-lg-12">
                        <?php  text_field('login','Login utilisateur',Auth::getUser()->login)  ?>
                     </div>
                    <div class="col-lg-12">
                        <?php  password_field('password','Mot de passe')  ?>
                       </div>
                    <div class="col-lg-12">
                     <?php  password_field('password_confirmation','Confirmation de mot de passe')  ?>
                    </div>
                </div>
                <div class="form-group"><button class="btn btn-primary" type="submit">Enregistrer</button></div>
            </form>
<?php close_modal_tags(); ?>