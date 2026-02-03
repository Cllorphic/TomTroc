<?php
$titlePage = 'Modifier les informations';
$action = 'index.php?route=book-update';
$submitLabel = 'Valider';
// $book est fourni par le controller
?>

<?php require __DIR__ . '/../layout/header.php'; ?>
<link rel="stylesheet" href="<?= htmlspecialchars(ASSET_URL) ?>/css/style.css">

<main class="account">
  <div class="container">
    <a href="index.php?route=account" class="account-books__link">← retour</a>

    <h1 class="account__title"><?= htmlspecialchars($titlePage) ?></h1>

    <?php require __DIR__ . '/form.php'; ?>
  </div>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>
