<div class="container-fluid">


    <div class="col-lg-4 mx-auto pt-5">

        <?php load_view('_includes/flash_messages.php') ?>

        <div class="container-fluid">

            <form action="" method="post">

                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">
                        <h4>Confirmation compte</h4>
                    </div>
                    <div class="card-body">
                        <?php  password_field('password_creation','token de creation')  ?>
                        <?php  password_field('password','Mot de passe')  ?>
                        <?php  password_field('password_confirmation','Confirmation de mot de passe')  ?>
                        <button type="submit" class="btn btn-dark col-lg-12">Confirmer mon compte</button>
                    </div>
                </div>

            </form>

        </div>

    </div>


</div>