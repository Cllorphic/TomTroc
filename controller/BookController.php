<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../model/BookModel.php';

// Controller : CRUD livres
class BookController
{
    // Model livres
    private BookModel $model;

    // Constructeur model
    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->model = new BookModel($pdo);
    }

    // Formulaire create
    public function create(): void
    {
        require __DIR__ . '/../view/book/create.php';
    }

    // Enregistre create
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?route=book-create");
            exit;
        }

        $userId = (int)$_SESSION['user']['id'];

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $isAvailable = (int)($_POST['is_available'] ?? 1);

        if ($title === '' || $author === '') {
            $_SESSION['flash_error'] = "Titre et auteur obligatoires.";
            header("Location: index.php?route=book-create");
            exit;
        }

        // Upload image (optionnel)
        $imagePath = $this->handleBookImageUpload();

        $this->model->insert($userId, $title, $author, $description, $imagePath, $isAvailable);

        $_SESSION['flash_success'] = "Livre créé.";
        header("Location: index.php?route=account");
        exit;
    }

    // Formulaire edit
    public function edit(): void
    {
        $userId = (int)$_SESSION['user']['id'];
        $bookId = (int)($_GET['id'] ?? 0);

        $book = $this->model->findByIdForUser($bookId, $userId);
        if (!$book) {
            $_SESSION['flash_error'] = "Livre introuvable.";
            header("Location: index.php?route=account");
            exit;
        }

        require __DIR__ . '/../view/book/edit.php';
    }

    // Enregistre edit
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?route=account");
            exit;
        }

        $userId = (int)$_SESSION['user']['id'];
        $bookId = (int)($_POST['id'] ?? 0);

        $book = $this->model->findByIdForUser($bookId, $userId);
        if (!$book) {
            $_SESSION['flash_error'] = "Action non autorisée.";
            header("Location: index.php?route=account");
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $isAvailable = (int)($_POST['is_available'] ?? 1);

        if ($title === '' || $author === '') {
            $_SESSION['flash_error'] = "Titre et auteur obligatoires.";
            header("Location: index.php?route=book-edit&id=" . $bookId);
            exit;
        }

        // Si nouvelle image uploadée -> remplace, sinon garde l’ancienne
        $newImage = $this->handleBookImageUpload();
        $finalImage = $newImage ?: ($book['image'] ?? null);

        $this->model->update($bookId, $userId, $title, $author, $description, $finalImage, $isAvailable);

        $_SESSION['flash_success'] = "Livre modifié.";
        header("Location: index.php?route=account");
        exit;
    }

    // Supprime un livre
    public function delete(): void
    {
        $userId = (int)$_SESSION['user']['id'];
        $bookId = (int)($_GET['id'] ?? 0);

        $ok = $this->model->delete($bookId, $userId);

        $_SESSION['flash_success'] = $ok ? "Livre supprimé." : "Action non autorisée.";
        header("Location: index.php?route=account");
        exit;
    }

    // Upload image livre
    private function handleBookImageUpload(): ?string
    {
        if (empty($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['flash_error'] = "Upload image échoué.";
            return null;
        }

        if ($_FILES['image']['size'] > 90 * 1024 * 1024) {
            $_SESSION['flash_error'] = "Image trop lourde (max 90 Mo).";
            return null;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES['image']['tmp_name']);

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($allowed[$mime])) {
            $_SESSION['flash_error'] = "Format non autorisé (jpg/png/webp).";
            return null;
        }

        $ext = $allowed[$mime];

        $dir = __DIR__ . '/../public/uploads/books';
        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $filename = 'book_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $dest = $dir . '/' . $filename;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
            $_SESSION['flash_error'] = "Impossible de sauvegarder l’image.";
            return null;
        }

        return 'public/uploads/books/' . $filename;
    }
}
