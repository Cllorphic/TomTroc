<?php

$title = 'Inscription';
$bodyClass = 'page-auth';

require __DIR__ . '/../layout/header.php';

?>

<div class="auth">
  <div class="auth__inner">
    <section class="auth__panel">
      <h1 class="auth__title">Inscription</h1>

      <?php if (!empty($errors)) : ?>
        <p class="alert"><?= htmlspecialchars($errors[0]) ?></p>
      <?php endif; ?>

      <form class="form" method="POST" action="index.php?route=register">
        <div class="field">
          <label for="username">Pseudo</label>
          <input
            id="username"
            type="text"
            name="username"
            required
            value="<?= htmlspecialchars($old['username'] ?? '') ?>"
          >
        </div>

        <div class="field">
          <label for="email">Adresse email</label>
          <input
            id="email"
            type="email"
            name="email"
            required
            value="<?= htmlspecialchars($old['email'] ?? '') ?>"
          >
        </div>

        <div class="field">
          <label for="password">Mot de passe</label>
          <input
            id="password"
            type="password"
            name="password"
            required
          >
        </div>

        <button class="btn btn--primary" type="submit">
          S’inscrire
        </button>
      </form>

      <p class="auth__hint">
        Déjà un compte ?
        <a href="index.php?route=login">Connectez-vous</a>
      </p>
    </section>

    <aside class="auth__media" aria-hidden="true"></aside>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>