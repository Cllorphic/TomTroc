<?php

class ArticleModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findById(int $id): ?array
{
    $sql = "
        SELECT
            b.id,
            b.user_id,
            b.title,
            b.author,
            b.description,
            b.image,
            b.is_available,
            b.created_at,

            u.id AS user_id,
            u.username,
            u.avatar
        FROM books b
        JOIN users u ON u.id = b.user_id
        WHERE b.id = :id
        LIMIT 1
    ";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $book = $stmt->fetch(PDO::FETCH_ASSOC);

    return $book ?: null;
}

}
