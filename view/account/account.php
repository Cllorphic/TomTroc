<?php
$user  = $user  ?? [];
$books = $books ?? [];

$avatarPath = $user['avatar'] ?? null;
$avatarUrl = $avatarPath
    ? BASE_URL . '/' . ltrim($avatarPath, '/')
    : BASE_URL . '/public/img/default-avatar.png';
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">

  <title>Mon compte</title>
  <link rel="stylesheet" href="<?= htmlspecialchars(ASSET_URL) ?>/css/style.css">
</head>

<body class="page-account">

<?php require __DIR__ . '/../layout/header.php'; ?>

<main class="account">
  <div class="container">
    <h1 class="account__title">Mon compte</h1>

    <section class="account__top">
      <article class="account-card account-card--profile">
        <div class="account-profile">

          <!-- AVATAR -->
          <div class="account-profile__avatar">
            <img src="<?= htmlspecialchars($avatarUrl) ?>" alt="Avatar">
          </div>

          <form method="POST"
                action="index.php?route=account-avatar-update"
                enctype="multipart/form-data">
            <input
              id="avatarInput"
              type="file"
              name="avatar"
              accept="image/png,image/jpeg,image/webp"
              style="display:none"
              onchange="this.form.submit()"
            >
            <label class="account-profile__edit" for="avatarInput" style="cursor:pointer;">
              modifier
            </label>
          </form>
          <!-- /AVATAR -->

          <div class="account-profile__name">
            <?= htmlspecialchars($user['username'] ?? '') ?>
          </div>

          <div class="account-profile__since">
            <?php
              $createdAt = $user['created_at'] ?? null;
              $memberText = 'Membre depuis';

              if ($createdAt) {
                $dt = new DateTime($createdAt);
                $now = new DateTime();
                $diff = $dt->diff($now);

                $years = (int)$diff->y;
                $months = (int)$diff->m;

                if ($years >= 1) {
                  $memberText .= ' ' . $years . ' an' . ($years > 1 ? 's' : '');
                } elseif ($months >= 1) {
                  $memberText .= ' ' . $months . ' mois';
                } else {
                  $memberText .= ' < 1 mois';
                }
              }

              echo htmlspecialchars($memberText);
            ?>
          </div>

          <div class="account-profile__library">
            <div class="account-profile__label">BIBLIOTHEQUE</div>
            <div class="account-profile__count">
              <span class="account-profile__bookicon" aria-hidden="true"></span>
              <?= count($books) ?> livre<?= count($books) > 1 ? 's' : '' ?>
            </div>
          </div>

        </div>
      </article>

      <article class="account-card account-card--infos">
        <h2 class="account-infos__title">Vos informations personnelles</h2>

        <form class="account-form" method="POST" action="index.php?route=account-update">
          <div class="account-field">
            <label for="email">Adresse email</label>
            <input id="email" type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
          </div>

          <div class="account-field">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password" placeholder="•••••••••">
          </div>

          <div class="account-field">
            <label for="username">Pseudo</label>
            <input id="username" type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
          </div>

          <button class="account-save" type="submit">Enregistrer</button>
        </form>
      </article>
    </section>

    <!-- Ajouter un livre -->
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

        <?php if (empty($books)): ?>
          <div class="account-books__empty">Aucun livre ajouté pour le moment.</div>
        <?php else: ?>
          <?php foreach ($books as $book): ?>
            <div class="account-books__row">
              <div class="account-books__photo">
                <?php if (!empty($book['image'])): ?>
                  <?php
                    $bookImg = $book['image'];
                    // Si tu stockes un chemin relatif en BDD
                    $bookImgUrl = (str_starts_with($bookImg, 'http') || str_starts_with($bookImg, '/'))
                      ? $bookImg
                      : BASE_URL . '/' . ltrim($bookImg, '/');
                  ?>
                  <img src="<?= htmlspecialchars($bookImgUrl) ?>" alt="">
                <?php else: ?>
                  <div class="account-books__placeholder" aria-hidden="true"></div>
                <?php endif; ?>
              </div>

              <div class="account-books__title"><?= htmlspecialchars($book['title'] ?? '') ?></div>
              <div class="account-books__author"><?= htmlspecialchars($book['author'] ?? '') ?></div>

              <div class="account-books__desc">
                <?= htmlspecialchars($book['description'] ?? '') ?>
              </div>

              <div class="account-books__status">
                <?php if ((int)($book['is_available'] ?? 0) === 1): ?>
                  <span class="tag tag--available">disponible</span>
                <?php else: ?>
                  <span class="tag tag--unavailable">non dispo.</span>
                <?php endif; ?>
              </div>

              <div class="account-books__actions">
                <a class="action action--edit" href="index.php?route=book-edit&id=<?= (int)($book['id'] ?? 0) ?>">Éditer</a>
                <a class="action action--delete" href="index.php?route=book-delete&id=<?= (int)($book['id'] ?? 0) ?>">Supprimer</a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </section>

  </div>
</main>

<?php require __DIR__ . '/../layout/footer.php'; ?>

</body>
</html>
