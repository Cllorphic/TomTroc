<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="messagerie">
  <div class="container messagerie__grid">

    <!-- LEFT -->
    <aside class="messagerie__sidebar">
      <h1 class="messagerie__title">Messagerie</h1>

      <div class="messagerie__threads">
        <?php if (empty($conversations)): ?>
          <div class="messagerie__empty">Aucune conversation.</div>
        <?php else: ?>
          <?php foreach ($conversations as $conv): ?>
            <?php
              $cid = (int)$conv['conversation_id'];
              $href = "index.php?route=messaging&c=" . urlencode((string)$cid);

              $isActive = ($cid === (int)($conversationId ?? 0));
              $name = $conv['other_username'] ?? 'Utilisateur';
              $snippet = $conv['last_body'] ?? '';
              $time = !empty($conv['last_at']) ? date('H:i', strtotime($conv['last_at'])) : '';
              $unread = (int)($conv['unread_count'] ?? 0);
            ?>

            <a class="messagerie__thread <?= $isActive ? 'is-active' : '' ?>"
               href="<?= htmlspecialchars($href) ?>">

              <div class="messagerie__avatar">
                <?php if (!empty($conv['other_avatar'])): ?>
                  <img src="<?= htmlspecialchars($conv['other_avatar']) ?>" alt="">
                <?php else: ?>
                  <div class="messagerie__avatar-ph"></div>
                <?php endif; ?>
              </div>

              <div class="messagerie__threadBody">
                <div class="messagerie__threadTop">
                  <div class="messagerie__threadName"><?= htmlspecialchars($name) ?></div>
                  <div class="messagerie__threadTime"><?= htmlspecialchars($time) ?></div>
                </div>
                <div class="messagerie__threadSnippet">
                  <?= htmlspecialchars(mb_strlen($snippet) > 40 ? mb_substr($snippet, 0, 40) . '…' : $snippet) ?>
                </div>
              </div>

              <?php if ($unread > 0): ?>
                <div class="messagerie__unread"><?= (int)$unread ?></div>
              <?php endif; ?>

            </a>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </aside>

    <!-- RIGHT -->
    <div class="messagerie__main">
      <?php if (!empty($conversationId)): ?>
        <!-- ✅ EN-TÊTE DE CONVERSATION (Avatar + Nom) -->
        <?php
          // Récupérer les infos de l'utilisateur actif
          $activeConv = null;
          foreach ($conversations as $conv) {
            if ((int)$conv['conversation_id'] === (int)$conversationId) {
              $activeConv = $conv;
              break;
            }
          }
          $otherName = $activeConv['other_username'] ?? 'Utilisateur';
          $otherAvatar = $activeConv['other_avatar'] ?? '';
        ?>
        <div class="messagerie__header">
          <div class="messagerie__header-avatar">
            <?php if (!empty($otherAvatar)): ?>
              <img src="<?= htmlspecialchars($otherAvatar) ?>" alt="">
            <?php else: ?>
              <div class="messagerie__header-avatar-ph"></div>
            <?php endif; ?>
          </div>
          <div class="messagerie__header-name"><?= htmlspecialchars($otherName) ?></div>
        </div>
      <?php endif; ?>

      <div class="messagerie__messages">
        <?php if (empty($conversationId)): ?>
          <div class="messagerie__placeholder">Sélectionne une conversation.</div>
        <?php else: ?>
          <?php foreach ($messages as $m): ?>
            <?php
              $mine = ((int)$m['sender_id'] === (int)$me);
              $date = !empty($m['created_at']) ? date('d.m H:i', strtotime($m['created_at'])) : '';
            ?>
            <div class="messagerie__msg <?= $mine ? 'is-mine' : 'is-their' ?>">
              <div class="messagerie__msgTime"><?= htmlspecialchars($date) ?></div>
              <div class="messagerie__bubble"><?= nl2br(htmlspecialchars($m['body'] ?? '')) ?></div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <?php if (!empty($conversationId)): ?>
        <form class="messagerie__form" method="POST" action="index.php?route=messaging-send">
          <input type="hidden" name="conversation_id" value="<?= (int)$conversationId ?>">
          <input class="messagerie__input" type="text" name="body" placeholder="Tapez votre message ici" autocomplete="off">
          <button class="messagerie__btn" type="submit">Découvrir</button>
        </form>
      <?php endif; ?>
    </div>

  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>