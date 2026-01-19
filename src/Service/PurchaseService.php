<?php
namespace App\Service;

use App\Model\Purchase;
use PDO;

final class PurchaseService
{
    public function __construct(
        private PDO $db,
        private Purchase $purchases,
        private PointsCalculator $calculator,
        private PointsService $pointsService
    ) {}

    public function processPurchase(int $userId, array $cartItems): array
    {
        $this->db->beginTransaction();
        try {
            $total = 0.0;
            foreach ($cartItems as $item) {
                $total += (float)$item['price'] * (int)$item['quantity'];
            }

            $purchaseId = $this->purchases->create($userId, $total, 'completed');

            foreach ($cartItems as $item) {
                $this->purchases->addItem(
                    $purchaseId,
                    (int)$item['id'],
                    (string)$item['name'],
                    (float)$item['price'],
                    (int)$item['quantity']
                );
            }

            $points = $this->calculator->calculate($total);
            if ($points > 0) {
                $this->pointsService->earn($userId, $points, "Points earned from purchase #{$purchaseId}");
            }

            $this->db->commit();

            return [
                'success' => true,
                'purchase_id' => $purchaseId,
                'total_amount' => $total,
                'points_earned' => $points
            ];
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
