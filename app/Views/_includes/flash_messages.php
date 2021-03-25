<?php if( session_instance()->hasFlashes() ): ?>

    <div class="container-fluid">
            <?php foreach ( session_instance()->getFlashes() as $type => $flash ): ?>
                <div class="col-lg-12 alert alert-<?= $type ?>">
                    <h5><i class="fa fa-info"></i><?= $flash['title'] ?></h5>
                    <p><?= $flash['msg'] ?></p>
                </div>
            <?php endforeach; ?>
    </div>

<?php endif?>

<?php if( !empty(session_instance()->read('errors')) ): ?>

    <div class="container-fluid">
        <div class="col-lg-12 alert alert-danger">
            <h5><i class="fa fa-warning"></i>Erreurs rencontrer dans le formulaire :</h5>
            <?php foreach ( session_instance()->read('errors') as $error): ?>
                <?= $error ?><br>
            <?php endforeach; ?>
        </div>
    </div>

<?php
    session_instance()->delete('errors');
    endif
?>
