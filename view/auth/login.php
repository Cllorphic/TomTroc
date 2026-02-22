<?php

$title = 'Connexion';
$bodyClass = 'page-auth';

require __DIR__ . '/../layout/header.php';

?>

<div class="auth">
  <div class="auth__inner">
    <section class="auth__panel">
      <h1 class="auth__title">Connexion</h1>

      <?php if (!empty($errors)) : ?>
        <p class="alert"><?= htmlspecialchars($errors[0]) ?></p>
      <?php endif; ?>

      <form class="form" method="POST" action="index.php?route=login">
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
          Se connecter
        </button>
      </form>

      <p class="auth__hint">
        Pas de compte ?
        <a href="index.php?route=register">Inscrivez-vous</a>
      </p>
    </section>

    <aside class="auth__media" aria-hidden="true"></aside>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>