<div class="container">
    <div class="row">
        <div class="col-lg-4 mx-auto pt-5">
            <form method="post">
                <div class="card border-dark">
                    <div class="card-header bg-dark text-white">
                        <h4>Reinitialisation de mot de passe</h4>
                    </div>
                    <div class="card-body">
                        <?php  password_field('password','Mot de passe')  ?>
                        <?php  password_field('password_confirmation','Confirmation de mot de passe')  ?>
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark">
                                Reinitialiser le mot de passe
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>