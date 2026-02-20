<?php

class AccountModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Récupère un user par ID
    public function getUserById(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: [];
    }

    // Récupère tous les livres d'un user
    public function getBooksByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM books WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    // Update username + email
    public function updateUserInfos(int $userId, string $username, string $email): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE users
            SET username = :username, email = :email
            WHERE id = :id
        ");

        return $stmt->execute([
            ':username' => $username,
            ':email'    => $email,
            ':id'       => $userId,
        ]);
    }

    // Update password hash 
    public function updatePasswordHash(int $userId, string $hash): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE users
            SET password_hash = :password_hash
            WHERE id = :id
        ");

        return $stmt->execute([
            ':password_hash' => $hash,
            ':id'            => $userId,
        ]);
    }

    // Update avatar
    public function updateAvatar(int $userId, string $avatarPath): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE users
            SET avatar = :avatar
            WHERE id = :id
        ");

        return $stmt->execute([
            ':avatar' => $avatarPath,
            ':id'     => $userId,
        ]);
    }

    /**
     * Supprime un livre seulement s'il appartient à l'user.
     * Retourne true si une ligne a été supprimée, sinon false.
     */
    public function deleteBook(int $bookId, int $userId): bool
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM books
            WHERE id = :id AND user_id = :user_id
        ");

        $stmt->execute([
            ':id'      => $bookId,
            ':user_id' => $userId,
        ]);

        return $stmt->rowCount() > 0;
    }
}