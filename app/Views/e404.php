<div class="container pt-5 mt-5">

    <div class="col-lg-12 ">
        <h1>Erreur 404</h1>
        <hr>
        <p>
            Page non trouvé pour l'url <?= $_SERVER['REQUEST_URI'] ?>
        </p>
        <p><a href="<?= path_for('login.home') ?>" class="btn btn-primary">Retouner a l'accueil</a> </p>
    </div>


</div>