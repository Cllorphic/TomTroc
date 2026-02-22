<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../model/MessagingModel.php';

class MessagingController
{
    private MessagingModel $model;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->model = new MessagingModel($pdo);
    }

    private function currentUserId(): int
    {
        // On ne touche pas AuthController : on utilise la session existante
        return (int) ($_SESSION['user']['id'] ?? 0);
    }

    public function index(): void
    {
        $me = $this->currentUserId();

        if ($me <= 0) {
            header('Location: index.php?route=login');
            exit;
        }

        $to = (int) ($_GET['to'] ?? 0);
        $conversationId = (int) ($_GET['c'] ?? 0);

        // Arrivée depuis "Envoyer un message"
        if ($to > 0) {
            // ✅ Empêche de créer une conversation avec soi-même : on ne fait rien
            if ($to === $me) {
                header('Location: index.php?route=messaging');
                exit;
            }

            // ✅ Sécurité : si le modèle throw quand même, on évite le fatal error
            try {
                $conversationId = $this->model->getOrCreateConversation($me, $to);
            } catch (RuntimeException $e) {
                header('Location: index.php?route=messaging');
                exit;
            }

            header('Location: index.php?route=messaging&c=' . urlencode((string) $conversationId));
            exit;
        }

        $conversations = $this->model->listConversations($me);

        // Ouvre la première conversation si aucune sélectionnée
        if ($conversationId <= 0 && !empty($conversations)) {
            $conversationId = (int) $conversations[0]['conversation_id'];
        }

        $messages = [];

        if ($conversationId > 0) {
            if (!$this->model->userIsInConversation($me, $conversationId)) {
                http_response_code(403);
                echo 'Accès interdit.';
                return;
            }

            $messages = $this->model->getMessages($conversationId);
            $this->model->markReadForUser($conversationId, $me);
        }

        $title = 'Messagerie';
        $bodyClass = 'page-messaging';

        require __DIR__ . '/../view/messaging/messaging.php';
    }

    public function send(): void
    {
        $me = $this->currentUserId();

        if ($me <= 0) {
            header('Location: index.php?route=login');
            exit;
        }

        $conversationId = (int) ($_POST['conversation_id'] ?? 0);
        $body = (string) ($_POST['body'] ?? '');

        if ($conversationId <= 0) {
            http_response_code(400);
            echo 'Conversation invalide.';
            return;
        }

        if (!$this->model->userIsInConversation($me, $conversationId)) {
            http_response_code(403);
            echo 'Accès interdit.';
            return;
        }

        $this->model->sendMessage($conversationId, $me, $body);

        header('Location: index.php?route=messaging&c=' . urlencode((string) $conversationId));
        exit;
    }
}