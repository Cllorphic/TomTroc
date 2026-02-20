<?php

declare(strict_types=1);

// Header global

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$title = $title ?? 'TomTroc';
$bodyClass = $bodyClass ?? '';
$isLoggedIn = !empty($_SESSION['user']);

$unreadCount = 0;

// Badge non-lus (si connecté)
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

        foreach ($dbPaths as $path) {
            if (file_exists($path)) {
                require_once $path;
                break;
            }
        }

        foreach ($modelPaths as $path) {
            if (file_exists($path)) {
                require_once $path;
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

  <title><?= htmlspecialchars((string) $title, ENT_QUOTES) ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?= htmlspecialchars((string) ASSET_URL, ENT_QUOTES) ?>/css/style.css">
</head>

<body class="<?= htmlspecialchars((string) $bodyClass, ENT_QUOTES) ?>">
  

  <header class="topbar">
    <div class="topbar__inner">
      <a class="logo" href="index.php?route=home" aria-label="TomTroc - Accueil">
        <img
          class="logo__img"
          src="<?= htmlspecialchars((string) ASSET_URL, ENT_QUOTES) ?>/img/uploads/logo/logo.svg"
          alt="TomTroc"
          width="140"
          height="40"
        >
      </a>

      <nav class="nav nav--center" aria-label="Navigation principale">
        <a class="nav__link" href="index.php?route=home">Accueil</a>
        <a class="nav__link" href="index.php?route=books">Nos livres à l’échange</a>
      </nav>

      <nav class="nav nav--right" aria-label="Compte">
        <?php if ($isLoggedIn) : ?>
          <a class="nav__link nav__link--messaging" href="index.php?route=messaging">
            <img
              class="nav__icon-img"
              src="<?= htmlspecialchars((string) ASSET_URL, ENT_QUOTES) ?>/img/uploads/icones/Messagerie.svg"
              alt=""
              aria-hidden="true"
              width="24"
              height="24"
            >
            <span class="nav__messaging-text">Messagerie</span>

            <?php if ($unreadCount > 0) : ?>
              <span class="nav__messaging-badge" aria-label="<?= (int) $unreadCount ?> messages non lus">
                <?= (int) $unreadCount ?>
              </span>
            <?php endif; ?>
          </a>

          <a class="nav__link" href="index.php?route=account">
            <img
              class="nav__icon-img"
              src="<?= htmlspecialchars((string) ASSET_URL, ENT_QUOTES) ?>/img/uploads/icones/IconeCompte.svg"
              alt=""
              aria-hidden="true"
              width="24"
              height="24"
            >
            Mon compte
          </a>

          <span class="nav__sep" aria-hidden="true"></span>

          <a class="nav__link" href="index.php?route=logout">Déconnexion</a>
        <?php else : ?>
          <a class="nav__link" href="index.php?route=login">Connexion</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>
