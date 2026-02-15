<?php
// 404.php
http_response_code(404);
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>404 - Page introuvable</title>

  <!-- CSS global -->
  <link rel="stylesheet" href="<?= htmlspecialchars(ASSET_URL . '/css/style.css') ?>">
</head>

<body class="page-404">
  <main>
    <div class="error">
      <div class="error__code">404</div>
      <p class="error__text">La page que vous cherchez n’existe pas.</p>

      <a class="error__btn" href="<?= BASE_URL ?>/index.php?route=home">
        Retour à l’accueil
      </a>
    </div>
  </main>
</body>

</html>
