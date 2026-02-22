<?php

class PublicAccountModel
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findUserById(int $userId): ?array
    {
        $stmt = $this->pdo->prepare(
            '
            SELECT id, username, avatar, created_at
            FROM users
            WHERE id = :id
            LIMIT 1
            '
        );
        $stmt->execute(['id' => $userId]);

        $u = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $u ?: null;
    }

    public function countBooksByUser(int $userId): int
    {
        $stmt = $this->pdo->prepare(
            '
            SELECT COUNT(*) AS c
            FROM books
            WHERE user_id = :uid
            '
        );
        $stmt->execute(['uid' => $userId]);

        return (int) ($stmt->fetch(\PDO::FETCH_ASSOC)['c'] ?? 0);
    }

    public function findBooksByUser(int $userId, int $limit, int $offset): array
    {
        $limit = max(1, min($limit, 48));
        $offset = max(0, $offset);

        $stmt = $this->pdo->prepare(
            "
            SELECT
                id,
                user_id,
                title,
                author,
                description,
                image,
                is_available,
                created_at
            FROM books
            WHERE user_id = :uid
            ORDER BY created_at DESC, id DESC
            LIMIT $limit OFFSET $offset
            "
        );
        $stmt->execute(['uid' => $userId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }
}