<div class="container-fluid">


    <div class="col-lg-4 mx-auto pt-5">

        <?php load_view('_includes/flash_messages.php') ?>

        <div class="container-fluid">

            <form action="" method="post">

                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">
                        <h4>Connexion</h4>
                    </div>
                    <div class="card-body">
                        <?php  text_field('login','Login')  ?>
                        <?php  password_field('password','Mot de passe')  ?>
                        <button type="submit" class="btn btn-dark col-lg-12">Connexion</button>
                        <a href="<?= path_for('login.reset') ?>">Mot de passe oublié</a>
                    </div>
                </div>

            </form>

        </div>

    </div>


</div>