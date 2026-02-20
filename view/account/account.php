<?php

declare(strict_types=1);

$title = 'Mon compte';
$bodyClass = 'page-account';

require __DIR__ . '/../layout/header.php';

if (!function_exists('assetPath')) {
    function assetPath(?string $path): string
    {
        if (!$path) {
            return '';
        }
        if (str_starts_with($path, 'http') || str_starts_with($path, '/')) {
            return $path;
        }
        if (defined('BASE_URL')) {
            return rtrim((string) BASE_URL, '/') . '/' . ltrim($path, '/');
        }
        return $path;
    }
}

$usernameValue = (string) (
    $user['username']
    ?? $username
    ?? ($_SESSION['user']['username'] ?? '')
);

$emailValue = (string) (
    $user['email']
    ?? $email
    ?? ($_SESSION['user']['email'] ?? '')
);

$avatarValue = (string) (
    $user['avatar']
    ?? $avatar
    ?? ($_SESSION['user']['avatar'] ?? '')
);

$memberSinceLabel = (string) (
    $user['member_since_label']
    ?? $memberSinceLabel
    ?? $memberSince
    ?? ''
);

$books = $books ?? [];
$booksCountValue = (int) (
    $user['books_count']
    ?? $booksCount
    ?? (is_array($books) ? count($books) : 0)
);

$defaultAvatar = defined('ASSET_URL')
    ? rtrim((string) ASSET_URL, '/') . '/img/default-avatar.svg'
    : '';
$avatarSrc = $avatarValue !== '' ? assetPath($avatarValue) : $defaultAvatar;
?>

<main class="account" id="main-content">
  <div class="container">
    <h1 class="account__title">Mon compte</h1>

    <section class="account__top">
      <article class="account-card account-card--profile">
        <div class="account-profile">
          <div class="account-profile__avatar">
            <img
              src="<?= htmlspecialchars($avatarSrc, ENT_QUOTES) ?>"
              alt="Avatar"
            >
          </div>

          <form
            method="POST"
            action="index.php?route=account-avatar-update"
            enctype="multipart/form-data"
          >
            <input
              id="avatarInput"
              type="file"
              name="avatar"
              accept="image/png,image/jpeg,image/webp"
              hidden
              onchange="this.form.submit()"
            >
            <label class="account-profile__edit" for="avatarInput">
              modifier
            </label>
          </form>

          <div class="account-profile__name">
            <?= htmlspecialchars($usernameValue, ENT_QUOTES) ?>
          </div>

          <div class="account-profile__since">
            <?= htmlspecialchars($memberSinceLabel, ENT_QUOTES) ?>
          </div>

          <div class="account-profile__library">
            <div class="account-profile__label">BIBLIOTHEQUE</div>
            <div class="account-profile__count">
              <span class="account-profile__bookicon" aria-hidden="true"></span>
              <?= $booksCountValue ?> livres
            </div>
          </div>
        </div>
      </article>

      <article class="account-card account-card--infos">
        <h2 class="account-infos__title">Vos informations personnelles</h2>

        <form class="account-form" method="POST" action="index.php?route=account-update">
          <div class="account-field">
            <label for="email">Adresse email</label>
            <input
              id="email"
              type="email"
              name="email"
              value="<?= htmlspecialchars($emailValue, ENT_QUOTES) ?>"
              required
            >
          </div>

          <div class="account-field">
            <label for="password">Mot de passe</label>
            <input
              id="password"
              type="password"
              name="password"
              placeholder="•••••••••"
            >
          </div>

          <div class="account-field">
            <label for="username">Pseudo</label>
            <input
              id="username"
              type="text"
              name="username"
              value="<?= htmlspecialchars($usernameValue, ENT_QUOTES) ?>"
              required
            >
          </div>

          <button class="account-save" type="submit">Enregistrer</button>
        </form>
      </article>
    </section>

    <div class="account-actions">
      <a class="account-add" href="index.php?route=book-create">+ Ajouter un livre</a>
    </div>

    <section class="account-books">
      <div class="account-books__card">
        <div class="account-books__head">
          <div>PHOTO</div>
          <div>TITRE</div>
          <div>AUTEUR</div>
          <div>DESCRIPTION</div>
          <div>DISPONIBILITE</div>
          <div>ACTION</div>
        </div>

        <?php if (!empty($books)) : ?>
          <?php foreach ($books as $book) : ?>
            <?php
              $bookImage = assetPath((string) ($book['image'] ?? ''));
              $bookId = (int) ($book['id'] ?? 0);
            ?>
            <div class="account-books__row">
              <div class="account-books__photo">
                <img
                  src="<?= htmlspecialchars($bookImage, ENT_QUOTES) ?>"
                  alt=""
                >
              </div>

              <div class="account-books__title">
                <?= htmlspecialchars((string) ($book['title'] ?? ''), ENT_QUOTES) ?>
              </div>

              <div class="account-books__author">
                <?= htmlspecialchars((string) ($book['author'] ?? ''), ENT_QUOTES) ?>
              </div>

              <div class="account-books__desc">
                <?= htmlspecialchars((string) ($book['description'] ?? ''), ENT_QUOTES) ?>
              </div>

              <div class="account-books__status">
                <?php if (!empty($book['is_available'])) : ?>
                  <span class="tag tag--available">disponible</span>
                <?php else : ?>
                  <span class="tag tag--unavailable">non dispo.</span>
                <?php endif; ?>
              </div>

              <div class="account-books__actions">
                <a
                  class="action action--edit"
                  href="index.php?route=book-edit&amp;id=<?= $bookId ?>"
                >
                  Éditer
                </a>

                <a
                  class="action action--delete"
                  href="index.php?route=book-delete&amp;id=<?= $bookId ?>"
                >
                  Supprimer
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>
  </div>
</main>

<script>
  document.addEventListener('click', function (e) {
    const deleteLink = e.target.closest('a.action.action--delete');
    if (!deleteLink) return;

    e.preventDefault();

    const ok = window.confirm('Voulez-vous vraiment supprimer ce livre ?');
    if (ok) {
      window.location.href = deleteLink.href;
    }
  });
</script>

<?php require __DIR__ . '/../layout/footer.php'; ?>
