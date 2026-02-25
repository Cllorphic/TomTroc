<?php

$titlePage = 'Modifier les informations';
$submitLabel = 'Valider';

// $book est fourni par le controller
$bookId = (int)($book['id'] ?? 0);

$action = 'index.php?route=book-update&id=' . $bookId;

require __DIR__ . '/../layout/header.php';

?>

<main class="account">
  <div class="container">
    <a href="index.php?route=account" class="account-books__link">← retour</a>

    <h1 class="account__title"><?= htmlspecialchars($titlePage, ENT_QUOTES) ?></h1>

    <?php require __DIR__ . '/form.php'; ?>
  </div>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>