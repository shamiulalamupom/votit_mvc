<?php require __DIR__ . '/../header.php'; ?>

<div class="py-5">
    <h1 class="display-5 fw-bold mb-4">Catégories</h1>
    <div class="row">
        <?php foreach ($categories as $category): ?>
            <div class="col-md-3 my-2">
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="card-title"><?= htmlspecialchars($category->getName()) ?></h3>
                        <a href="/category/?id=<?= $category->getId() ?>" class="btn btn-primary">Voir les sondages</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require __DIR__ . '/../footer.php'; ?>
