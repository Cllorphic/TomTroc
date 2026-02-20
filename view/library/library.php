<?php
$bodyClass = $bodyClass ?? 'page-books';
$title = $title ?? "Nos livres à l'échange - TomTroc";

$q = $q ?? '';
$page = $page ?? 1;
$totalPages = $totalPages ?? 1;
$books = $books ?? [];

function libraryBookImg(?string $img): string
{
    if (!$img) return '';
    if (str_starts_with($img, 'http') || str_starts_with($img, '/')) return $img;
    return BASE_URL . '/' . ltrim($img, '/');
}
?>

<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="library">
  <div class="container">

    <div class="library-head">
      <h1 class="library-title">Nos livres à l’échange</h1>

      <form class="library-search" method="GET" action="index.php">
        <input type="hidden" name="route" value="books">

        <div class="library-search__wrap">
          <label for="search-books" hidden>Rechercher un livre</label>

          <span class="library-search__icon">🔍</span>
          <input
  id="search-books"
  class="library-search__input"
  type="text"
  name="q"
  placeholder="Rechercher un livre"
  value="<?= htmlspecialchars($q) ?>"
  aria-label="Rechercher un livre"
>
        </div>
      </form>
    </div>

    <div class="library-grid">
      <?php foreach ($books as $b): ?>
        <?php
          $imgUrl = libraryBookImg($b['image'] ?? null);
          $bookId = $b['id'] ?? $b['book_id'] ?? null;
          $href = $bookId ? "index.php?route=article&id=" . urlencode((string)$bookId) : "#";
        ?>

        <article class="library-card">
          <a href="<?= htmlspecialchars($href) ?>" class="library-card__link">

            <div class="library-card__imgwrap">
              <?php if (!$b['is_available']): ?>
                <span class="library-card__tag">non dispo.</span>
              <?php endif; ?>

              <?php if ($imgUrl): ?>
                <img class="library-card__img" src="<?= htmlspecialchars($imgUrl) ?>" alt="">
              <?php else: ?>
                <div class="library-card__ph"></div>
              <?php endif; ?>
            </div>

            <div class="library-card__body">
              <div class="library-card__title"><?= htmlspecialchars($b['title'] ?? '') ?></div>
              <div class="library-card__author"><?= htmlspecialchars($b['author'] ?? '') ?></div>
              <div class="library-card__seller">
                Vendu par : <span><?= htmlspecialchars($b['seller_username'] ?? '') ?></span>
              </div>
            </div>

          </a>
        </article>

      <?php endforeach; ?>
    </div>

    <?php if ($totalPages > 1): ?>
      <nav class="library-pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <a
            class="library-pagination__link <?= (int)$i === (int)$page ? 'is-active' : '' ?>"
            href="index.php?route=books&q=<?= urlencode($q) ?>&p=<?= $i ?>"
          >
            <?= $i ?>
          </a>
        <?php endfor; ?>
      </nav>
    <?php endif; ?>

  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
