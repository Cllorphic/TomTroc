<?php

// Model : gestion compte + livres
class AccountModel
{
    // Connexion DB
    private PDO $pdo;

    // Constructeur : injecte PDO
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Récupère un utilisateur
    public function getUserById(int $id): array
    {
        $stmt = $this->pdo->prepare("SELECT id, username, email, created_at, avatar FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    // Met à jour username + email
    public function updateUserInfos(int $id, string $username, string $email): void
    {
        $stmt = $this->pdo->prepare("UPDATE users SET username = :u, email = :e WHERE id = :id");
        $stmt->execute(['u' => $username, 'e' => $email, 'id' => $id]);
    }

    // Met à jour le mot de passe
    public function updatePasswordHash(int $id, string $hash): void
    {
        $stmt = $this->pdo->prepare("UPDATE users SET password_hash = :h WHERE id = :id");
        $stmt->execute(['h' => $hash, 'id' => $id]);
    }

    // Met à jour l’avatar
    public function updateAvatar(int $id, string $avatarPath): void
    {
        $stmt = $this->pdo->prepare("UPDATE users SET avatar = :a WHERE id = :id");
        $stmt->execute(['a' => $avatarPath, 'id' => $id]);
    }

    // Liste les livres du user
    public function getBooksByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT id, user_id, title, author, description, image, is_available, created_at
            FROM books
            WHERE user_id = :uid
            ORDER BY id DESC
        ");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    // Supprime un livre (si owner)
    public function deleteBook(int $bookId, int $userId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM books WHERE id = :id AND user_id = :uid");
        $stmt->execute(['id' => $bookId, 'uid' => $userId]);
        return $stmt->rowCount() > 0;
    }
}
