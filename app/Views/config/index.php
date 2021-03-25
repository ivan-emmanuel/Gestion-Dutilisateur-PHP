<div class="container-fluid">


    <div class="card border-dark">
        <div class="card-header bg-dark text-white">
            <h4>Configuration de l'application</h4>
        </div>
        <div class="card-header">
            <h5>Création du compte administrateur</h5>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="row">
                    <div class="col-lg-6">
                        <?php  text_field('name','Votre Nom')  ?>
                    </div>
                    <div class="col-lg-6">
                        <?php  text_field('login','Votre login')  ?>
                    </div>
                    <div class="col-lg-6">
                        <?php  password_field('password','Mot de passe')  ?>
                    </div>
                    <div class="col-lg-6">
                        <?php  password_field('password_confirmation','Confirmation de mot de passe')  ?>
                    </div>
                    <div class="col-lg-12">
                        <?php  email_field('email','Email de compte admin')  ?>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-dark" type="submit">
                        Confirgurer l'application
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>