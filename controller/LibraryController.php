<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../model/LibraryModel.php';

// Controller : page "Nos livres à l'échange"
class LibraryController
{
    // Model catalogue
    private LibraryModel $model;

    // Constructeur
    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->model = new LibraryModel($pdo);
    }

    // Listing public
    public function index(): void
    {
        $bodyClass = 'page-books';
        $title = "Nos livres à l'échange - TomTroc";

        $q = trim($_GET['q'] ?? '');
        $page = max(1, (int) ($_GET['p'] ?? 1));
        $perPage = 16;
        $offset = ($page - 1) * $perPage;

        $filters = [
            'q' => $q,
        ];

        $total = $this->model->countAll($filters);
        $books = $this->model->findAll($filters, $perPage, $offset);

        $totalPages = max(1, (int) ceil($total / $perPage));

        require __DIR__ . '/../view/library/library.php';
    }
}