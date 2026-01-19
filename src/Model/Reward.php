<?php
namespace App\Model;

use PDO;

final class Reward
{
    public function __construct(private PDO $db) {}

    public function all(): array
    {
        return $this->db->query("SELECT * FROM rewards ORDER BY points_required ASC")->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM rewards WHERE id = :id");
        $stmt->execute(['id'=>$id]);
        $r = $stmt->fetch();
        return $r ?: null;
    }

    public function decrementStockIfLimited(int $rewardId): void
    {
        $sql = "UPDATE rewards SET stock = stock - 1 WHERE id = :id AND stock > 0";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id'=>$rewardId]);
    }
}
