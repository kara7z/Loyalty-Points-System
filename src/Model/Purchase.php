<?php
namespace App\Model;

use PDO;

final class Purchase
{
    public function __construct(private PDO $db) {}

    public function create(int $userId, float $totalAmount, string $status): int
    {
        $sql = "INSERT INTO purchases (user_id, total_amount, status, created_at)
                VALUES (:uid, :total, :status, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['uid'=>$userId, 'total'=>$totalAmount, 'status'=>$status]);
        return (int)$this->db->lastInsertId();
    }

    public function addItem(int $purchaseId, int $productId, string $productName, float $unitPrice, int $quantity): void
    {
        $sql = "INSERT INTO purchase_items (purchase_id, product_id, product_name, unit_price, quantity, line_total)
                VALUES (:pid,:prid,:name,:price,:qty,:total)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'pid'=>$purchaseId,
            'prid'=>$productId,
            'name'=>$productName,
            'price'=>$unitPrice,
            'qty'=>$quantity,
            'total'=>$unitPrice * $quantity
        ]);
    }
}
