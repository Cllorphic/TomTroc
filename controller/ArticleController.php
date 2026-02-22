<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../model/ArticleModel.php';

class ArticleController
{
    public function show(): void
    {
        // 1) récupérer l'id depuis l'URL
        $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

        if ($id <= 0) {
            http_response_code(400);
            echo 'ID invalide';
            return;
        }

        // 2) connexion BDD
        $pdo = Database::getConnection();

        // 3) récupérer le livre
        $model = new ArticleModel($pdo);
        $book = $model->findById($id);

        if (!$book) {
            http_response_code(404);
            echo 'Article introuvable';
            return;
        }

        // 4) charger la view
        $title = ($book['title'] ?? 'Article') . ' - TomTroc';
        require_once __DIR__ . '/../view/article/article.php';
    }
}