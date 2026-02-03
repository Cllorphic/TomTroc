<?php

// Model : données accueil
class HomeModel
{
  // Connexion DB
  private PDO $pdo;

  // Constructeur PDO
  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  // Derniers livres ajoutés
  public function getLatestBooks(int $limit = 4): array
  {
    $limit = max(1, min($limit, 12));

    $stmt = $this->pdo->prepare("
      SELECT id, title, author, image, created_at
      FROM books
      ORDER BY created_at DESC, id DESC
      LIMIT $limit
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
  }
}
