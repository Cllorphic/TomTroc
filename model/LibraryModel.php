<?php

// Model : catalogue public
class LibraryModel
{
    // PDO
    private PDO $pdo;

    // Constructeur
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Compte total
    public function countAll(array $filters): int
    {
        [$where, $params] = $this->buildWhere($filters);

        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) AS c
            FROM books b
            JOIN users u ON u.id = b.user_id
            $where
        ");
        $stmt->execute($params);

        return (int)($stmt->fetch(PDO::FETCH_ASSOC)['c'] ?? 0);
    }

    // Liste paginée
    public function findAll(array $filters, int $limit, int $offset): array
    {
        $limit = max(1, min($limit, 48));
        $offset = max(0, $offset);

        [$where, $params] = $this->buildWhere($filters);

        $stmt = $this->pdo->prepare("
            SELECT
                b.id,
                b.user_id,
                b.title,
                b.author,
                b.description,
                b.image,
                b.is_available,
                b.created_at,
                u.username AS seller_username
            FROM books b
            JOIN users u ON u.id = b.user_id
            $where
            ORDER BY b.created_at DESC, b.id DESC
            LIMIT $limit OFFSET $offset
        ");
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    // Where dynamique
    private function buildWhere(array $filters): array
    {
        $where = [];
        $params = [];

        $q = trim((string)($filters['q'] ?? ''));
        if ($q !== '') {
            $where[] = "(b.title LIKE :q OR b.author LIKE :q)";
            $params['q'] = '%' . $q . '%';
        }

        $sqlWhere = $where ? ('WHERE ' . implode(' AND ', $where)) : '';
        return [$sqlWhere, $params];
    }
}
