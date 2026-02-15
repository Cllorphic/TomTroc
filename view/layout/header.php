<?php
// Header global

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$title = $title ?? 'TomTroc';
$bodyClass = $bodyClass ?? '';
$isLoggedIn = !empty($_SESSION['user']);

$unreadCount = 0;

/**
 * Badge non-lus
 */
if ($isLoggedIn) {
    $me = (int)($_SESSION['user']['id'] ?? 0);

    if ($me > 0) {
        $dbPaths = [
            __DIR__ . '/../../config/Database.php',
            __DIR__ . '/../config/Database.php',
            __DIR__ . '/config/Database.php',
        ];

        $modelPaths = [
            __DIR__ . '/../../model/MessagingModel.php',
            __DIR__ . '/../model/MessagingModel.php',
            __DIR__ . '/model/MessagingModel.php',
        ];

        foreach ($dbPaths as $p) {
            if (file_exists($p)) {
                require_once $p;
                break;
            }
        }

        foreach ($modelPaths as $p) {
            if (file_exists($p)) {
                require_once $p;
                break;
            }
        }

        if (class_exists('Database') && class_exists('MessagingModel')) {
            try {
                $pdo = Database::getConnection();
                $messagingModel = new MessagingModel($pdo);
                $unreadCount = (int)$messagingModel->countUnreadForUser($me);
            } catch (Throwable $e) {
                $unreadCount = 0;
            }
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= htmlspecialchars($title) ?></title>

  <link rel="stylesheet" href="<?= htmlspecialchars(ASSET_URL) ?>/css/style.css">
</head>

<body class="<?= htmlspecialchars($bodyClass) ?>">

<header class="topbar">
  <div class="topbar__inner">

    <a class="logo" href="index.php?route=home" aria-label="TomTroc - Accueil">
      <img class="logo__img" src="<?= htmlspecialchars(ASSET_URL) ?>/img/uploads/logo/logo.svg" alt="TomTroc">
    </a>

    <nav class="nav nav--center">
      <a class="nav__link" href="index.php?route=home">Accueil</a>
      <a class="nav__link" href="index.php?route=books">Nos livres à l’échange</a>
    </nav>

    <nav class="nav nav--right">
      <?php if ($isLoggedIn): ?>

        <a class="nav__link nav__link--messaging" href="index.php?route=messaging">
          <img class="nav__icon-img" src="<?= htmlspecialchars(ASSET_URL) ?>/img/uploads/icones/Messagerie.svg" alt="">
          <span class="nav__messaging-text">Messagerie</span>

          <?php if ($unreadCount > 0): ?>
            <span class="nav__messaging-badge"><?= (int)$unreadCount ?></span>
          <?php endif; ?>
        </a>

        <a class="nav__link" href="index.php?route=account">
          <img class="nav__icon-img" src="<?= htmlspecialchars(ASSET_URL) ?>/img/uploads/icones/IconeCompte.svg" alt="">
          Mon compte
        </a>

        <span class="nav__sep"></span>

        <a class="nav__link" href="index.php?route=logout">Déconnexion</a>

      <?php else: ?>

        <a class="nav__link" href="index.php?route=login">Connexion</a>

      <?php endif; ?>
    </nav>

  </div>
</header>
