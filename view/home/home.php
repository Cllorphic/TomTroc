<?php
// Body class pour activer le CSS body.page-home ...
$bodyClass = 'page-home';
$title = 'Accueil - TomTroc';

$latestBooks = $latestBooks ?? [];

// Images home (selon ton besoin : imgHome1 en haut, HomeImg2 en bas)
$heroImg   = BASE_URL . '/public/img/uploads/home_image/imgHome1.jpg';
$valuesImg = BASE_URL . '/public/img/uploads/home_image/HomeImg2.jpg';
$vector    = BASE_URL . '/public/img/uploads/icones/Vector.svg';
?>

<?php require __DIR__ . '/../layout/header.php'; ?>

<main class="home">

  <!-- HERO -->
  <section class="home-hero">
    <div class="container home-hero__container">
      <div class="home-hero__left">
        <h1 class="home-hero__title">Rejoignez nos lecteurs passionnés</h1>
        <p class="home-hero__text">
          Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux
          de la lecture. Nous croyons en la magie du partage de connaissances et
          d'histoires à travers les livres.
        </p>
        <a class="home-btn home-btn--primary" href="index.php?route=books">Découvrir</a>
      </div>

      <div class="home-hero__right">
        <img class="home-hero__img" src="<?= htmlspecialchars($heroImg) ?>" alt="Livres">
      </div>
    </div>
  </section>

  <!-- DERNIERS LIVRES (fond beige pleine largeur) -->
  <section class="home-latest-section">
    <div class="container">
      <h2 class="home-section__title">Les derniers livres ajoutés</h2>

      <div class="home-grid">
        <?php foreach ($latestBooks as $b): ?>
          <?php
            $img = $b['image'] ?? '';
            $imgUrl = $img
              ? (str_starts_with($img, 'http') || str_starts_with($img, '/')
                  ? $img
                  : BASE_URL . '/' . ltrim($img, '/'))
              : '';

            
            $bookId = $b['id'] ?? $b['book_id'] ?? null;
            $href = $bookId ? "index.php?route=article&id=" . urlencode((string)$bookId) : "#";
          ?>

          <article class="home-card">
            
            <a href="<?= htmlspecialchars($href) ?>" class="home-card__link">
              <div class="home-card__imgwrap">
                <?php if ($imgUrl): ?>
                  <img class="home-card__img" src="<?= htmlspecialchars($imgUrl) ?>" alt="">
                <?php else: ?>
                  <div class="home-card__ph"></div>
                <?php endif; ?>
              </div>

              <div class="home-card__body">
                <div class="home-card__title"><?= htmlspecialchars($b['title'] ?? '') ?></div>
                <div class="home-card__meta"><?= htmlspecialchars($b['author'] ?? '') ?></div>
              </div>
            </a>
          </article>

        <?php endforeach; ?>
      </div>

      <div class="home-center">
        <a class="home-btn home-btn--primary" href="index.php?route=books">Voir tous les livres</a>
      </div>
    </div>
  </section>

  <!-- COMMENT ÇA MARCHE -->
  <section class="home-how home-section--tint">
    <div class="container">
      <h2 class="home-section__title">Comment ça marche ?</h2>
      <p class="home-section__subtitle">
        Échanger des livres avec TomTroc c'est simple et amusant ! Suivez ces étapes pour commencer :
      </p>

      <div class="home-steps">
        <div class="home-step"><div class="home-step__text">Inscrivez-vous gratuitement sur notre plateforme.</div></div>
        <div class="home-step"><div class="home-step__text">Ajoutez les livres que vous souhaitez échanger à votre profil.</div></div>
        <div class="home-step"><div class="home-step__text">Parcourez les livres disponibles chez d'autres membres.</div></div>
        <div class="home-step"><div class="home-step__text">Proposez un échange et discutez avec d'autres passionnés.</div></div>
      </div>

      <div class="home-center">
        <a class="home-btn home-btn--ghost" href="index.php?route=books">Voir tous les livres</a>
      </div>
    </div>
  </section>

  <!-- BANDE IMAGE -->
  <section class="home-band">
    <img class="home-band__img" src="<?= htmlspecialchars($valuesImg) ?>" alt="">
  </section>

  <!-- VALEURS -->
  <section class="home-values">
    <div class="container">
      <h2 class="home-section__title">Nos valeurs</h2>

      <div class="home-values__grid">
        <div class="home-values__text">
          <p>
            Chez TomTroc, nous mettons l'accent sur le partage, la découverte et la communauté.
            Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer
            des liens entre les lecteurs.
          </p>
          <p>
            Nous encourageons la réutilisation des livres pour préserver l'environnement et
            permettre à chacun de découvrir de nouvelles histoires.
          </p>
          <p class="home-values__sign">L’équipe TomTroc</p>
        </div>

        <div class="home-values__mark">
          <img src="<?= htmlspecialchars($vector) ?>" alt="">
        </div>
      </div>
    </div>
  </section>

</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>
