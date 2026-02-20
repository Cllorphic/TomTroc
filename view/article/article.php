<?php
$bodyClass = 'page-article';

function assetUrl(?string $path): string
{
    if (!$path) return '';
    if (str_starts_with($path, 'http') || str_starts_with($path, '/')) return $path;

    // Si tu as BASE_URL défini, il sera utilisé. Sinon on part de la racine.
    if (defined('BASE_URL')) return BASE_URL . '/' . ltrim($path, '/');
    return '/' . ltrim($path, '/');
}

$imgUrl = assetUrl($book['image'] ?? null);
$avatarUrl = assetUrl($book['avatar'] ?? null);

// fallback si pas d'avatar
if (!$avatarUrl) {
    // mets le chemin de ton avatar par défaut si tu en as un
    $avatarUrl = (defined('BASE_URL') ? BASE_URL : '') . '/assets/img/avatar-default.png';
}

// lien vers profil user
$userHref = "index.php?route=public-account&id=" . urlencode((string)($book['user_id'] ?? 0));
?>

<?php require_once __DIR__ . '/../layout/header.php'; ?>

<section class="article">
  <div class="container article__wrap">

    <!-- Gauche -->
    <div class="article__left">
      <?php if ($imgUrl): ?>
        <img class="article__img" src="<?= htmlspecialchars($imgUrl) ?>" alt="<?= htmlspecialchars($book['title'] ?? '') ?>">
      <?php else: ?>
        <div class="article__img" aria-hidden="true"></div>
      <?php endif; ?>
    </div>

    <!-- Droite -->
    <div class="article__right">

      <h1 class="article__title"><?= htmlspecialchars($book['title'] ?? '') ?></h1>
      <div class="article__author">par <?= htmlspecialchars($book['author'] ?? '') ?></div>

      <div class="article__line"></div>

      <div class="article__label">Description</div>
      <div class="article__desc">
        <?= nl2br(htmlspecialchars($book['description'] ?? '')) ?>
      </div>

       <div class="article__label article__label--spaced">Propriétaire</div>

      
      <a class="article__ownerCard article__ownerCard--link"  href="<?= htmlspecialchars($userHref) ?>">

        <div class="article__ownerAvatar">
          <img src="<?= htmlspecialchars($avatarUrl) ?>" alt="">
        </div>
        <div class="article__ownerName">
          <?= htmlspecialchars($book['username'] ?? '') ?>
        </div>
      </a>

      <!-- CTA -->
      <a class="article__cta"
   href="index.php?route=messaging&to=<?= urlencode((string)($book['user_id'] ?? 0)) ?>">
  Envoyer un message
</a>


    </div>

  </div>
</section>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
