<?php
// Header global

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$title = $title ?? 'TomTroc';
$bodyClass = $bodyClass ?? '';
$isLoggedIn = !empty($_SESSION['user']);
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= htmlspecialchars($title) ?></title>

  <!-- CSS global -->
  <link rel="stylesheet" href="<?= htmlspecialchars(ASSET_URL) ?>/css/style.css">
</head>

<body class="<?= htmlspecialchars($bodyClass) ?>">

<header class="topbar">
  <div class="topbar__inner">

    <!-- Logo -->
    <a class="logo" href="index.php?route=home" aria-label="TomTroc - Accueil">
      <img class="logo__img" src="<?= htmlspecialchars(ASSET_URL) ?>/img/uploads/logo/logo.svg" alt="TomTroc">
    </a>

    <!-- Menu centre -->
    <nav class="nav nav--center">
      <a class="nav__link" href="index.php?route=home">Accueil</a>
      <a class="nav__link" href="index.php?route=books">Nos livres à l’échange</a>
    </nav>

    <!-- Menu droite -->
    <nav class="nav nav--right">
      <?php if ($isLoggedIn): ?>

        <a class="nav__link" href="index.php?route=messages">
          <img class="nav__icon-img" src="<?= htmlspecialchars(ASSET_URL) ?>/img/uploads/icones/Messagerie.svg" alt="">
          Messagerie
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

<main>
