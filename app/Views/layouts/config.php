<!DOCTYPE html>

<html lang="en">
    <?php load_view('_includes/head.php') ?>
<body >

    <div class="mx-auto mt-5 py-2 col-lg-8">
        <?php load_view('_includes/flash_messages.php') ?>

        <?= $content ?>
    </div>

    <div class="fixed-footer" style="background-color: #1a1a1a;color: #fff;font-size: 13px;position: fixed;right: 0;bottom: 0;padding: 10px;">
        <?= app_config("APP_NAME") ?>
        <hr> Développé par Emmanuel Ivan
    </div>

    <?php load_view('_includes/scripts.php') ?>

</body>
</html>

