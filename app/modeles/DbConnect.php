<?php

namespace app\modeles;

use PDO;
use PDOException;
use Exception;

// Singleton - Connexion base de données
abstract class DbConnect
{
    private static ?PDO $instance = null; // Stocke l'instance unique de PDO

    private static function connexion(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'];
                self::$instance = new PDO($dsn, $_ENV['USERNAME'], $_ENV['PASSWORD'], [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            } catch (PDOException $e) {
                die("Erreur de connexion PDO : " . $e->getMessage());
            }
        }
        return self::$instance;
    }

    // Exécute une requête SQL éventuellement paramétrée
    protected static function executerRequete(string $sql, array $values = [])
    {
        try {
            $query = self::connexion()->prepare($sql);

            // Binding des valeurs
            foreach ($values as $key => $value) {
                $param = (strpos($key, ":") === 0) ? $key : ":" . $key;
                $query->bindValue($param, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
            }

            $query->execute();
            return $query;
        } catch (Exception $e) {
            die("Erreur SQL : " . $e->getMessage());
        }
    }
}
