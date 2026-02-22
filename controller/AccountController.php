<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../model/AccountModel.php';

// Controller : page account
class AccountController
{
    // Model account
    private AccountModel $model;

    // Constructeur : init model
    public function __construct()
    {
        // Récupère PDO via Database
        $pdo = Database::getConnection();
        $this->model = new AccountModel($pdo);
    }

    // Affiche la page account
    public function show(): void
    {
        $userId = (int) $_SESSION['user']['id'];

        // Données user + livres
        $user = $this->model->getUserById($userId);
        $books = $this->model->getBooksByUserId($userId);

        // Chargement view
        require __DIR__ . '/../view/account/account.php';
    }

    // Update infos user
    public function updateInfos(): void
    {
        // Vérifie POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=account');
            exit;
        }

        $userId = (int) $_SESSION['user']['id'];
        $email = trim($_POST['email'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Vérifie email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = 'Email invalide.';
            header('Location: index.php?route=account');
            exit;
        }

        // Vérifie pseudo
        if ($username === '') {
            $_SESSION['flash_error'] = 'Pseudo obligatoire.';
            header('Location: index.php?route=account');
            exit;
        }

        // Update email + pseudo
        $this->model->updateUserInfos($userId, $username, $email);

        // Update mdp si rempli
        if ($password !== '') {
            if (strlen($password) < 8) {
                $_SESSION['flash_error'] = 'Mot de passe trop court (min 8).';
                header('Location: index.php?route=account');
                exit;
            }

            // Hash du mdp
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $this->model->updatePasswordHash($userId, $hash);
        }

        // Update session user
        $_SESSION['user']['username'] = $username;
        $_SESSION['user']['email'] = $email;

        $_SESSION['flash_success'] = 'Informations mises à jour.';
        header('Location: index.php?route=account');
        exit;
    }

    // Update avatar user
    public function updateAvatar(): void
    {
        // Vérifie POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=account');
            exit;
        }

        $userId = (int) $_SESSION['user']['id'];

        // ✅ récupère l'ancien avatar AVANT remplacement
        $user = $this->model->getUserById($userId);
        $oldAvatar = $user['avatar'] ?? null;

        // Vérifie fichier
        if (empty($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['flash_error'] = 'Upload avatar échoué.';
            header('Location: index.php?route=account');
            exit;
        }

        // Vérifie taille max
        if ($_FILES['avatar']['size'] > 80 * 1024 * 1024) {
            $_SESSION['flash_error'] = 'Image trop lourde (max 80 Mo).';
            header('Location: index.php?route=account');
            exit;
        }

        // Vérifie mime réel
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($_FILES['avatar']['tmp_name']);

        // Formats autorisés
        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($allowed[$mime])) {
            $_SESSION['flash_error'] = 'Format non autorisé.';
            header('Location: index.php?route=account');
            exit;
        }

        // Extension image
        $ext = $allowed[$mime];

        // Dossier avatars
        $dir = __DIR__ . '/../public/uploads/avatars';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Nom fichier unique
        $filename = 'avatar_u' . $userId . '_' . time() . '.' . $ext;
        $dest = $dir . '/' . $filename;

        // Déplace fichier
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $dest)) {
            $_SESSION['flash_error'] = 'Impossible de sauvegarder.';
            header('Location: index.php?route=account');
            exit;
        }

        // Chemin public DB (✅ on garde ton chemin EXACT)
        $publicPath = 'public/uploads/avatars/' . $filename;

        // Update DB avatar
        $this->model->updateAvatar($userId, $publicPath);

        // Update session avatar
        $_SESSION['user']['avatar'] = $publicPath;

        // ✅ supprime l'ancien fichier avatar (après update réussi)
        $this->deleteUploadedFile($oldAvatar);

        $_SESSION['flash_success'] = 'Avatar mis à jour.';
        header('Location: index.php?route=account');
        exit;
    }

    // Supprime un livre
    public function deleteBook(): void
    {
        $userId = (int) $_SESSION['user']['id'];
        $bookId = (int) ($_GET['id'] ?? 0);

        // Vérifie id book
        if ($bookId <= 0) {
            header('Location: index.php?route=account');
            exit;
        }

        // ✅ récupère l'image du livre AVANT suppression
        $books = $this->model->getBooksByUserId($userId);
        $bookImage = null;

        foreach ($books as $b) {
            if ((int) $b['id'] === $bookId) {
                $bookImage = $b['image'] ?? null;
                break;
            }
        }

        // Delete sécurisé
        $ok = $this->model->deleteBook($bookId, $userId);

        // ✅ si suppression OK, on supprime l'image
        if ($ok) {
            $this->deleteUploadedFile($bookImage);
        }

        $_SESSION['flash_success'] = $ok ? 'Livre supprimé.' : 'Action non autorisée.';
        header('Location: index.php?route=account');
        exit;
    }

    private function deleteUploadedFile(?string $publicPath): void
    {
        if (!$publicPath) {
            return;
        }

        // Sécurité : on ne supprime QUE dans public/uploads
        $uploadsBase = realpath(__DIR__ . '/../public/uploads');
        $fullPath = realpath(__DIR__ . '/../' . ltrim($publicPath, '/'));

        if (!$uploadsBase || !$fullPath) {
            return;
        }

        if (strpos($fullPath, $uploadsBase) !== 0) {
            return; // empêche ../../ etc.
        }

        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}