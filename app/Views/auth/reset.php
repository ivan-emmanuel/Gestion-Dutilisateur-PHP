<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto pt-5">
            <form method="post">
            <div class="card border-dark">
                <div class="card-header bg-dark text-white">
                    <h4>Reinitialisation de mot de passe</h4>
                </div>
                <div class="card-body">
                    <?php  text_field('email','Email de creation de compte')  ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark">
                            Envoyer les instructions par mail
                        </button>
                        <a href="<?= path_for('login.home') ?>" class="btn btn-secondary">
                           Accueil
                        </a>
                    </div>
                </div>
            </div>
              </form>  
        </div>
    </div>
</div>