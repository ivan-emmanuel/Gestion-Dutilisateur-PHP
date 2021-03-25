<!DOCTYPE html>

<html lang="en">
<?php load_view('_includes/head.php') ?>
<body >

<?php load_view('_includes/header.php') ?>

<div class="container-fluid ">
    <div class="row">
        <div class="col-sm-2 p-0 bg-dark" style="min-height: 100vh">
            <?php load_view('_includes/sidebar.php') ?>
        </div>
        <div class="col-md-10 pt-4">
            <?php load_view('_includes/flash_messages.php') ?>

            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Application</li>
                    <?php if ( !empty($title) ): ?>  <li class="breadcrumb-item active"> <?= $title ?></li> <?php endif;; ?>
                </ol>
            </div>

             <div class="container-fluid">
                 <?= $content ?>
             </div>
        </div>
    </div>
</div>

<div class="fixed-footer" style="background-color: #1a1a1a;color: #fff;font-size: 13px;position: fixed;right: 0;bottom: 0;padding: 10px;">
    <?= app_config("APP_NAME") ?>
    <hr> Développé par Emmanuel Ivan
</div>


<?php load_view('_includes/scripts.php') ?>

</body>
</html>
