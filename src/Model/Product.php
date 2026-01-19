<?php
namespace App\Model;

use PDO;

final class Product
{
    public function __construct(private PDO $db) {}

    public function all(): array
    {
        return $this->db->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id'=>$id]);
        $p = $stmt->fetch();
        return $p ?: null;
    }
}
