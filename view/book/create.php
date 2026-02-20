<?php
$titlePage = 'Ajouter un livre';
$action = 'index.php?route=book-store';
$submitLabel = 'Créer';
$book = [];
?>

<?php require __DIR__ . '/../layout/header.php'; ?>


<main class="account">
  <div class="container">
    <a href="index.php?route=account" class="account-books__link">← retour</a>

    <h1 class="account__title"><?= htmlspecialchars($titlePage) ?></h1>

    <?php require __DIR__ . '/form.php'; ?>
  </div>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>
