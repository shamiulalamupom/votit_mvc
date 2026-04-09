<?php require __DIR__ . '/../header.php'; ?>

<div class="py-5">
    <h1 class="display-5 fw-bold mb-4"><?= htmlspecialchars($category->getName()) ?></h1>
    <div class="row">
        <?php if (empty($polls)): ?>
            <p>Aucun sondage dans cette catégorie.</p>
        <?php else: ?>
            <?php foreach ($polls as $poll): ?>
                <?php include __DIR__ . '/../poll/poll_part.php'; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <a href="/category/list/" class="btn btn-secondary mt-4">Retour aux catégories</a>
</div>

<?php require __DIR__ . '/../footer.php'; ?>
