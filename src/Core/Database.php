<?php
namespace App\Core;

use PDO;

final class Database
{
    public static function pdo(array $config): PDO
    {
        return new PDO($config['dsn'], $config['user'], $config['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}
