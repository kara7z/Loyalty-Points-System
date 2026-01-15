<?php
namespace App\config;
use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function connect()
    {
        if (self::$connection === null) {

            $host = "localhost";
            $db   = "LPS";   
            $user = "root";
            $pass = "Admin@1234";
            $charset = "utf8mb4";

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            try {
                self::$connection = new PDO($dsn, $user, $pass);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}



// $pdo = Database::connect();
// $sql = "SELECT * FROM users";
// $stmt = $pdo->prepare($sql);
// $stmt->execute();
// $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
// print_r($users);