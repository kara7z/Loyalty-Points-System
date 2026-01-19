<?php
namespace App\Model;

use PDO;

final class User
{
    public function __construct(private PDO $db) {}

    public function create(string $email, string $passwordHash, ?string $name): int
    {
        $sql = "INSERT INTO users (email, password_hash, name) VALUES (:email,:ph,:name)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email'=>$email, 'ph'=>$passwordHash, 'name'=>$name]);
        return (int)$this->db->lastInsertId();
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email'=>$email]);
        $u = $stmt->fetch();
        return $u ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id'=>$id]);
        $u = $stmt->fetch();
        return $u ?: null;
    }

    public function updatePoints(int $userId, int $newTotal): void
    {
        $stmt = $this->db->prepare("UPDATE users SET total_points = :p WHERE id = :id");
        $stmt->execute(['p'=>$newTotal, 'id'=>$userId]);
    }
}
