<?php
$bodyClass = $bodyClass ?? 'page-public-account';
$title = $title ?? "Compte public - TomTroc";

$user = $user ?? null;
$books = $books ?? [];
$total = $total ?? 0;
$page = $page ?? 1;
$totalPages = $totalPages ?? 1;

function imgUrl(?string $img): string
{
    if (!$img) return '';
    if (str_starts_with($img, 'http') || str_starts_with($img, '/')) return $img;
    return BASE_URL . '/' . ltrim($img, '/');
}

$avatar = imgUrl($user['avatar'] ?? '');
$username = $user['username'] ?? 'Utilisateur';
$memberSince = !empty($user['created_at']) ? date('d/m/Y', strtotime($user['created_at'])) : null;

//lien pour “écrire un message”
$messageHref = "index.php?route=messaging&to=" . urlencode((string)$user['id']);
?>

<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="public-account">
  <div class="container public-account__grid">

    <!-- Colonne gauche -->
    <aside class="public-account__card">
      <div class="public-account__avatar">
        <?php if ($avatar): ?>
          <img src="<?= htmlspecialchars($avatar) ?>" alt="">
        <?php else: ?>
          <div class="public-account__avatar-ph"></div>
        <?php endif; ?>
      </div>

      <h1 class="public-account__name"><?= htmlspecialchars($username) ?></h1>

      <?php if ($memberSince): ?>
        <div class="public-account__meta">Membre depuis <?= htmlspecialchars($memberSince) ?></div>
      <?php endif; ?>

      <div class="public-account__sep"></div>

      <div class="public-account__stat">
        <div class="public-account__stat-label">Bibliothèque</div>
        <div class="public-account__stat-value">
  <?= (int)$total ?> <?= ((int)$total === 1) ? 'livre' : 'livres' ?>
</div>

      </div>

      <a class="btn btn--primary" href="<?= htmlspecialchars($messageHref) ?>">
        Écrire un message
      </a>
    </aside>

    <!-- Colonne droite -->
    <div class="public-account__list">

      <div class="public-account__table">
        <div class="public-account__thead">
          <div>Photo</div>
          <div>Titre</div>
          <div>Auteur</div>
          <div>Description</div>
        </div>

        <?php foreach ($books as $b): ?>
          <?php
            $img = imgUrl($b['image'] ?? null);
            $bookHref = "index.php?route=article&id=" . urlencode((string)$b['id']);
            $desc = trim((string)($b['description'] ?? ''));
            $descShort = mb_strlen($desc) > 120 ? (mb_substr($desc, 0, 120) . '…') : $desc;
          ?>

          <a class="public-account__row" href="<?= htmlspecialchars($bookHref) ?>">
            <div class="public-account__cell">
              <?php if ($img): ?>
                <img class="public-account__bookimg" src="<?= htmlspecialchars($img) ?>" alt="">
              <?php else: ?>
                <div class="public-account__bookimg-ph"></div>
              <?php endif; ?>
            </div>

            <div class="public-account__cell"><?= htmlspecialchars($b['title'] ?? '') ?></div>
            <div class="public-account__cell"><?= htmlspecialchars($b['author'] ?? '') ?></div>
            <div class="public-account__cell"><?= htmlspecialchars($descShort) ?></div>
          </a>
        <?php endforeach; ?>

        <?php if (empty($books)): ?>
          <div class="public-account__empty">Aucun livre publié pour le moment.</div>
        <?php endif; ?>
      </div>

      <?php if ($totalPages > 1): ?>
        <nav class="library-pagination" style="margin-top:16px;">
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a
              class="library-pagination__link <?= (int)$i === (int)$page ? 'is-active' : '' ?>"
              href="index.php?route=public-account&id=<?= urlencode((string)$user['id']) ?>&p=<?= $i ?>"
            >
              <?= $i ?>
            </a>
          <?php endfor; ?>
        </nav>
      <?php endif; ?>

    </div>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
