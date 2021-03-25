<div class="row">
    <?php foreach ($data as $key => $datum) : ?>
    <div class="col-lg-3  mb-5" >
        <div class="card border-dark h-100">
            <div class="card-header">
                <h6> <?= $datum['count'] ?>  <?= $datum['title'] ?> (s)</h6>
            </div>
            <ul class="list-group h-100">
                <?php foreach ($datum['data']->fetchAll() as $item) : ?>
                <li class="list-group-item"><?= $item->name ?> <span class="badge badge-dark"><?= $item->created_at ?></span> </li>
                <?php endforeach; ?>
            </ul>
            <div class="card-footer bg-dark">
                <a href="<?= $datum['link'] ?>" class="text-white">Consulter</a>
            </div>
        </div>
    </div>
    <?php endforeach ?>
</div>