<?php
// Valeurs
$book = $book ?? [];

$image = $book['image'] ?? '';
$title = $book['title'] ?? '';
$author = $book['author'] ?? '';
$description = $book['description'] ?? '';
$isAvailable = (!isset($book['is_available']) || (int)$book['is_available'] === 1);


$imageUrl = '';
if (!empty($image)) {
  if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://') || str_starts_with($image, '/')) {
    $imageUrl = $image;
  } else {
    $imageUrl = BASE_URL . '/' . ltrim($image, '/');
  }
}


$isImageRequired = empty($imageUrl);
?>

<div class="bookedit">
  <div class="bookedit__card">
    <form class="bookedit__grid"
          method="post"
          action="<?= htmlspecialchars($action) ?>"
          enctype="multipart/form-data">

      <?php if (!empty($book['id'])): ?>
        <input type="hidden" name="id" value="<?= (int)$book['id'] ?>">
      <?php endif; ?>

      <!-- Colonne gauche -->
      <div class="bookedit__left">
        <div class="bookedit__label">Photo</div>

        <div class="bookedit__photo">
          <?php if ($imageUrl): ?>
            <img id="coverPreview" src="<?= htmlspecialchars($imageUrl) ?>" alt="Couverture du livre">
          <?php else: ?>
            <div class="bookedit__placeholder" id="coverPreview"></div>
          <?php endif; ?>
        </div>

        <input class="bookedit__file"
               type="file"
               name="image"
               id="image"
               accept="image/*"
               <?= $isImageRequired ? 'required' : '' ?>>

        <button class="bookedit__link" type="button" onclick="document.getElementById('image').click()">
          Modifier la photo
        </button>
      </div>

      <!-- Colonne droite -->
      <div class="bookedit__right">
        <div class="bookedit__field">
          <label for="title">Titre</label>
          <input id="title" name="title" required value="<?= htmlspecialchars($title) ?>">
        </div>

        <div class="bookedit__field">
          <label for="author">Auteur</label>
          <input id="author" name="author" required value="<?= htmlspecialchars($author) ?>">
        </div>

        <div class="bookedit__field">
          <label for="description">Commentaire</label>
          <textarea id="description"
                    name="description"
                    rows="10"
                    required><?= htmlspecialchars($description) ?></textarea>
        </div>

        <div class="bookedit__field">
          <label for="is_available">Disponibilité</label>
          <select id="is_available" name="is_available">
            <option value="1" <?= $isAvailable ? 'selected' : '' ?>>disponible</option>
            <option value="0" <?= !$isAvailable ? 'selected' : '' ?>>indisponible</option>
          </select>
        </div>

        <button class="bookedit__submit" type="submit"><?= htmlspecialchars($submitLabel) ?></button>
      </div>

    </form>
  </div>
</div>

<script>
  // Preview image
  const input = document.getElementById('image');
  let prev = document.getElementById('coverPreview');

  if (input && prev) {
    input.addEventListener('change', () => {
      const f = input.files && input.files[0];
      if (!f) return;

      const url = URL.createObjectURL(f);

      // Si c'était un placeholder <div>, on le remplace par un <img>
      if (prev.tagName.toLowerCase() !== 'img') {
        const img = document.createElement('img');
        img.id = 'coverPreview';
        img.alt = 'Couverture du livre';
        img.src = url;
        prev.replaceWith(img);
        prev = img;
      } else {
        prev.src = url;
      }
    });
  }
</script>