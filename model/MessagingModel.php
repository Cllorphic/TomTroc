<?php

class MessagingModel
{
    public function __construct(private PDO $pdo) {}

    private function makePairKey(int $a, int $b): string
    {
        return min($a, $b) . '_' . max($a, $b);
    }

    public function getOrCreateConversation(int $me, int $other): int
    {
        if ($me <= 0 || $other <= 0) throw new RuntimeException("IDs invalides.");
        if ($me === $other) throw new RuntimeException("Impossible de se parler à soi-même.");

        $pairKey = $this->makePairKey($me, $other);

        $stmt = $this->pdo->prepare("SELECT id FROM conversations WHERE pair_key = :k LIMIT 1");
        $stmt->execute(['k' => $pairKey]);
        $id = $stmt->fetchColumn();
        if ($id) return (int)$id;

        $u1 = min($me, $other);
        $u2 = max($me, $other);

        $stmt = $this->pdo->prepare("
            INSERT INTO conversations (user_one_id, user_two_id, pair_key, created_at, updated_at)
            VALUES (:u1, :u2, :k, NOW(), NOW())
        ");
        $stmt->execute(['u1' => $u1, 'u2' => $u2, 'k' => $pairKey]);

        return (int)$this->pdo->lastInsertId();
    }

    public function userIsInConversation(int $me, int $conversationId): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT 1 FROM conversations
            WHERE id = :cid AND (user_one_id = :me OR user_two_id = :me)
            LIMIT 1
        ");
        $stmt->execute(['cid' => $conversationId, 'me' => $me]);
        return (bool)$stmt->fetchColumn();
    }

    public function listConversations(int $me): array
    {
        $sql = "
            SELECT
                c.id AS conversation_id,

                CASE WHEN c.user_one_id = :me THEN u2.id ELSE u1.id END AS other_id,
                CASE WHEN c.user_one_id = :me THEN u2.username ELSE u1.username END AS other_username,
                CASE WHEN c.user_one_id = :me THEN u2.avatar ELSE u1.avatar END AS other_avatar,

                lm.body AS last_body,
                lm.created_at AS last_at,

                (
                    SELECT COUNT(*)
                    FROM messages m2
                    WHERE m2.conversation_id = c.id
                      AND m2.sender_id <> :me
                      AND m2.is_read = 0
                ) AS unread_count
            FROM conversations c
            JOIN users u1 ON u1.id = c.user_one_id
            JOIN users u2 ON u2.id = c.user_two_id

            LEFT JOIN messages lm ON lm.id = (
                SELECT id
                FROM messages
                WHERE conversation_id = c.id
                ORDER BY created_at DESC, id DESC
                LIMIT 1
            )

            WHERE c.user_one_id = :me OR c.user_two_id = :me
            ORDER BY COALESCE(lm.created_at, c.updated_at) DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['me' => $me]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getMessages(int $conversationId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT id, conversation_id, sender_id, body, created_at, is_read
            FROM messages
            WHERE conversation_id = :cid
            ORDER BY created_at ASC, id ASC
        ");
        $stmt->execute(['cid' => $conversationId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function sendMessage(int $conversationId, int $senderId, string $body): void
    {
        $body = trim($body);
        if ($body === '') return;

        $stmt = $this->pdo->prepare("
            INSERT INTO messages (conversation_id, sender_id, body, created_at, is_read)
            VALUES (:cid, :sid, :body, NOW(), 0)
        ");
        $stmt->execute(['cid' => $conversationId, 'sid' => $senderId, 'body' => $body]);

        $stmt = $this->pdo->prepare("UPDATE conversations SET updated_at = NOW() WHERE id = :cid");
        $stmt->execute(['cid' => $conversationId]);
    }

    public function markReadForUser(int $conversationId, int $me): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE messages
            SET is_read = 1
            WHERE conversation_id = :cid
              AND sender_id <> :me
              AND is_read = 0
        ");
        $stmt->execute(['cid' => $conversationId, 'me' => $me]);
    }

    public function countUnreadForUser(int $me): int
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*)
            FROM messages m
            JOIN conversations c ON c.id = m.conversation_id
            WHERE (c.user_one_id = :me OR c.user_two_id = :me)
              AND m.sender_id <> :me
              AND m.is_read = 0
        ");
        $stmt->execute(['me' => $me]);
        return (int)$stmt->fetchColumn();
    }
}
