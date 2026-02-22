<?php

// Model : gestion livres
class BookModel
{
    // Connexion DB
    private PDO $pdo;

    // Constructeur PDO
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Crée un livre
    public function insert(
        int $userId,
        string $title,
        string $author,
        string $description,
        ?string $image,
        int $isAvailable
    ): int {
        $stmt = $this->pdo->prepare(
            '
            INSERT INTO books (user_id, title, author, description, image, is_available, created_at)
            VALUES (:uid, :t, :a, :d, :i, :av, NOW())
            '
        );

        $stmt->execute([
            'uid' => $userId,
            't' => $title,
            'a' => $author,
            'd' => $description,
            'i' => $image,
            'av' => $isAvailable,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    // Récupère un livre (owner)
    public function findByIdForUser(int $bookId, int $userId): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM books WHERE id = :id AND user_id = :uid'
        );

        $stmt->execute([
            'id' => $bookId,
            'uid' => $userId,
        ]);

        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        return $book ?: null;
    }

    // Update un livre
    public function update(
        int $bookId,
        int $userId,
        string $title,
        string $author,
        string $description,
        ?string $image,
        int $isAvailable
    ): bool {
        $stmt = $this->pdo->prepare(
            '
            UPDATE books
            SET title = :t,
                author = :a,
                description = :d,
                image = :i,
                is_available = :av
            WHERE id = :id AND user_id = :uid
            '
        );

        $stmt->execute([
            't' => $title,
            'a' => $author,
            'd' => $description,
            'i' => $image,
            'av' => $isAvailable,
            'id' => $bookId,
            'uid' => $userId,
        ]);

        return $stmt->rowCount() > 0;
    }

    // Supprime un livre (owner)
    public function delete(int $bookId, int $userId): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM books WHERE id = :id AND user_id = :uid'
        );

        $stmt->execute([
            'id' => $bookId,
            'uid' => $userId,
        ]);

        return $stmt->rowCount() > 0;
    }
}