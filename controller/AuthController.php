<?php

require_once __DIR__ . '/../model/AuthModel.php';

/** Connexion / inscription */
class AuthController
{
    /** Afficher le formulaire login */
    public function showLogin(): void
    {
        $errors = $_SESSION['errors'] ?? [];
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['errors'], $_SESSION['old']);

        require __DIR__ . '/../view/auth/login.php';
    }

    /** Traiter le login */
    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Vérif
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $_SESSION['errors'] = ["Email ou mot de passe invalide."];
            $_SESSION['old'] = ['email' => $email];
            header("Location: index.php?route=login");
            exit;
        }

        $user = UserModel::findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $_SESSION['errors'] = ["Identifiants incorrects."];
            $_SESSION['old'] = ['email' => $email];
            header("Location: index.php?route=login");
            exit;
        }

        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'avatar' => $user['avatar'],
        ];

        header("Location: index.php?page=account");
        exit;

    }

    /** Afficher le formulaire register */
    public function showRegister(): void
    {
        $errors = $_SESSION['errors'] ?? [];
        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['errors'], $_SESSION['old']);

        require __DIR__ . '/../view/auth/register.php';
    }

    /** Traiter le register */
    public function register(): void
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Vérif
        if ($username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $_SESSION['errors'] = ["Champs invalides."];
            $_SESSION['old'] = ['username' => $username, 'email' => $email];
            header("Location: index.php?route=register");
            exit;
        }

        if (UserModel::emailExists($email)) {
            $_SESSION['errors'] = ["Cet email est déjà utilisé."];
            $_SESSION['old'] = ['username' => $username, 'email' => $email];
            header("Location: index.php?route=register");
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        UserModel::create($username, $email, $hash);

        header("Location: index.php?route=login");
        exit;
    }

    /** Déconnexion */
    public function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);

        header("Location: index.php?route=login");
        exit;
    }
}
