Pour déployer le site, il faut créer un dossier config à la racine du projet, puis créer un fichier database.php à l’intérieur.

Contenu du fichier database.php :

<?php

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO(
                'mysql:host=localhost;dbname=TomTroc;charset=utf8',
                'root',
                '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }

        return self::$pdo;
    }
}


Ensuite, il faut créer une base de données TomTroc sur phpMyAdmin et importer le fichier TomTroc.sql.

Pour se connecter à l’administrateur :

Email : admin12@gmail.com

Mot de passe : 123

Pour se connecter avec un compte de test :

Email : jeandupont@gmail.com

Mot de passe : 123