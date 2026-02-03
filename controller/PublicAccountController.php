<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../model/PublicAccountModel.php';

class PublicAccountController
{
    private PublicAccountModel $model;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->model = new PublicAccountModel($pdo);
    }

    public function show(): void
    {
        $bodyClass = 'page-public-account';
        $title = "Compte public - TomTroc";

        $userId = (int)($_GET['id'] ?? 0);
        if ($userId <= 0) {
            http_response_code(404);
            echo "Utilisateur introuvable.";
            return;
        }

        $page = max(1, (int)($_GET['p'] ?? 1));
        $perPage = 6; // ajuste comme tu veux
        $offset = ($page - 1) * $perPage;

        $user = $this->model->findUserById($userId);
        if (!$user) {
            http_response_code(404);
            echo "Utilisateur introuvable.";
            return;
        }

        $total = $this->model->countBooksByUser($userId);
        $books = $this->model->findBooksByUser($userId, $perPage, $offset);
        $totalPages = max(1, (int)ceil($total / $perPage));

        require __DIR__ . '/../view/account/public_account.php';
    }
}
