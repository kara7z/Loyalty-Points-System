<?php
namespace App\Model;

use PDO;

final class PointsTransaction
{
    public function __construct(private PDO $db) {}

    public function add(int $userId, string $type, int $amount, string $description, int $balanceAfter): int
    {
        $sql = "INSERT INTO points_transactions (user_id,type,amount,description,balance_after)
                VALUES (:uid,:type,:amt,:desc,:bal)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'uid'=>$userId, 'type'=>$type, 'amt'=>$amount, 'desc'=>$description, 'bal'=>$balanceAfter
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function historyByUser(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM points_transactions WHERE user_id = :uid ORDER BY createdat DESC");
        $stmt->execute(['uid'=>$userId]);
        return $stmt->fetchAll();
    }
}
