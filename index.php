<?php

session_start();

define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'));
define('ASSET_URL', BASE_URL . '/public');

require_once __DIR__ . '/controller/AuthController.php';
require_once __DIR__ . '/controller/AccountController.php';
require_once __DIR__ . '/controller/BookController.php';
require_once __DIR__ . '/controller/HomeController.php';
require_once __DIR__ . '/controller/LibraryController.php';
require_once __DIR__ . '/controller/PublicAccountController.php';
require_once __DIR__ . '/controller/MessagingController.php';

$route = $_GET['route'] ?? ($_GET['page'] ?? 'login');

switch ($route) {
    case 'login':
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->showLogin();
        }
        break;

    case 'register':
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            $controller->showRegister();
        }
        break;

    case 'logout':
        (new AuthController())->logout();
        break;

    case 'dashboard':
        if (empty($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
        echo 'Bienvenue ' . htmlspecialchars($_SESSION['user']['username'] ?? '');
        break;

    case 'account':
        if (empty($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
        (new AccountController())->show();
        break;

    case 'account-update':
        if (empty($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
        (new AccountController())->updateInfos();
        break;

    case 'account-avatar-update':
        if (empty($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
        (new AccountController())->updateAvatar();
        break;

    case 'book-delete':
        if (empty($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
        (new AccountController())->deleteBook();
        break;

    case 'book-create':
        if (empty($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
        (new BookController())->create();
        break;

    case 'book-store':
        if (empty($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
        (new BookController())->store();
        break;

    case 'book-edit':
        if (empty($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
        (new BookController())->edit();
        break;

    case 'book-update':
        if (empty($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
        (new BookController())->update();
        break;

    case 'book-delete':
        if (empty($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
        (new BookController())->delete();
        break;

    case 'home':
        (new HomeController())->show();
        break;

    case 'books':
        (new LibraryController())->index();
        break;

    case 'article':
        require_once __DIR__ . '/controller/ArticleController.php';
        (new ArticleController())->show();
        break;

    case 'public-account':
        (new PublicAccountController())->show();
        break;

    case 'messaging':
        if (empty($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
        require_once __DIR__ . '/controller/MessagingController.php';
        (new MessagingController())->index();
        break;

    case 'messaging-send':
        if (empty($_SESSION['user'])) {
            header('Location: index.php?route=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Méthode non autorisée.';
            exit;
        }
        require_once __DIR__ . '/controller/MessagingController.php';
        (new MessagingController())->send();
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/404.php';
        break;
}