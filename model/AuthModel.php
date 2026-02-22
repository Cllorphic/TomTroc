<?php

require_once __DIR__ . '/../config/Database.php';

/** Requêtes liées aux utilisateurs */
class UserModel
{
    /** Trouver un utilisateur via son email */
    public static function findByEmail(string $email): ?array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(
            '
            SELECT id, username, email, password_hash, avatar
            FROM users
            WHERE email = :email
            LIMIT 1
            '
        );

        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch();

        return $user ?: null;
    }

    /** Vérifier si un email est déjà utilisé */
    public static function emailExists(string $email): bool
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(
            'SELECT 1 FROM users WHERE email = :email LIMIT 1'
        );

        $stmt->execute(['email' => $email]);

        return (bool) $stmt->fetchColumn();
    }

    /** Créer un compte utilisateur */
    public static function create(
        string $username,
        string $email,
        string $passwordHash
    ): int {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(
            '
            INSERT INTO users (username, email, password_hash, created_at)
            VALUES (:username, :email, :password_hash, NOW())
            '
        );

        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password_hash' => $passwordHash,
        ]);

        return (int) $pdo->lastInsertId();
    }
}