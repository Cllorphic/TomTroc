<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../model/BookModel.php';

class BookController
{
    private BookModel $model;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->model = new BookModel($pdo);
    }

    public function create(): void
    {
        $this->ensureAuth();
        require __DIR__ . '/../view/book/create.php';
    }

    public function store(): void
    {
        $this->ensureAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=create');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $isAvailable = isset($_POST['is_available']) ? 1 : 0;

        if (!$this->validateBookData($title, $author, $description, $isAvailable)) {
            $_SESSION['flash_error'] = 'Données du livre invalides.';
            header('Location: index.php?route=create');
            exit;
        }

        $image = $this->handleBookImageUpload();

        $this->model->insert(
            (int) $_SESSION['user']['id'],
            $title,
            $author,
            $description,
            $image,
            $isAvailable
        );

        header('Location: index.php?route=account');
        exit;
    }

    public function edit(): void
    {
        $this->ensureAuth();

        $userId = (int) $_SESSION['user']['id'];
        $bookId = (int) ($_GET['id'] ?? 0);

        $book = $this->model->findByIdForUser($bookId, $userId);
        if (!$book) {
            header('Location: index.php?route=account');
            exit;
        }

        require __DIR__ . '/../view/book/edit.php';
    }

    public function update(): void
    {
        $this->ensureAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=account');
            exit;
        }

        $userId = (int) $_SESSION['user']['id'];
        $bookId = (int) ($_GET['id'] ?? 0);

        $book = $this->model->findByIdForUser($bookId, $userId);
        if (!$book) {
            header('Location: index.php?route=account');
            exit;
        }

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $isAvailable = isset($_POST['is_available']) ? 1 : 0;

        if (!$this->validateBookData($title, $author, $description, $isAvailable)) {
            $_SESSION['flash_error'] = 'Données du livre invalides.';
            header('Location: index.php?route=edit&id=' . $bookId);
            exit;
        }

        $oldImage = $book['image'] ?? null;
        $newImage = $this->handleBookImageUpload();
        $finalImage = $newImage ?: $oldImage;

        $updated = $this->model->update(
            $bookId,
            $userId,
            $title,
            $author,
            $description,
            $finalImage,
            $isAvailable
        );

        if ($updated && $newImage && $oldImage) {
            $this->deleteUploadedFile($oldImage);
        }

        header('Location: index.php?route=account');
        exit;
    }

    public function delete(): void
    {
        $this->ensureAuth();

        $userId = (int) $_SESSION['user']['id'];
        $bookId = (int) ($_GET['id'] ?? 0);

        $book = $this->model->findByIdForUser($bookId, $userId);
        if (!$book) {
            header('Location: index.php?route=account');
            exit;
        }

        $oldImage = $book['image'] ?? null;
        $deleted = $this->model->delete($bookId, $userId);

        if ($deleted && $oldImage) {
            $this->deleteUploadedFile($oldImage);
        }

        header('Location: index.php?route=account');
        exit;
    }

    private function validateBookData(
        string $title,
        string $author,
        string $description,
        int $isAvailable
    ): bool {
        if ($title === '' || mb_strlen($title) > 255) {
            return false;
        }

        if ($author === '' || mb_strlen($author) > 255) {
            return false;
        }

        if (mb_strlen($description) > 2000) {
            return false;
        }

        return in_array($isAvailable, [0, 1], true);
    }

    private function handleBookImageUpload(): ?string
    {
        if (
            empty($_FILES['image']['name']) ||
            ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK
        ) {
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $fileType = (string) ($_FILES['image']['type'] ?? '');

        if (!in_array($fileType, $allowedTypes, true)) {
            return null;
        }

        $extension = pathinfo((string) $_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('book_', true) . '.' . $extension;
        $destination = __DIR__ . '/../public/uploads/books/' . $filename;

        if (!move_uploaded_file((string) $_FILES['image']['tmp_name'], $destination)) {
            return null;
        }

        return 'public/uploads/books/' . $filename;
    }

    private function deleteUploadedFile(?string $relativePath): void
    {
        if (!$relativePath) {
            return;
        }

        $fullPath = __DIR__ . '/../' . ltrim($relativePath, '/');

        if (is_file($fullPath)) {
            unlink($fullPath);
        }
    }

    private function ensureAuth(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
    }
}