<?php
namespace App\Service;

use App\Model\User;
use App\Model\PointsTransaction;
use App\Model\Reward;
use PDO;

final class PointsService
{
    public function __construct(
        private PDO $db,
        private User $users,
        private PointsTransaction $tx,
        private Reward $rewards
    ) {}

    public function earn(int $userId, int $points, string $description): int
    {
        $ownTx = !$this->db->inTransaction();
        if ($ownTx) $this->db->beginTransaction();

        try {
            $u = $this->users->findById($userId);
            if (!$u) throw new \RuntimeException('USER_NOT_FOUND');

            $newTotal = (int)$u['total_points'] + $points;
            $this->users->updatePoints($userId, $newTotal);
            $this->tx->add($userId, 'earned', $points, $description, $newTotal);

            if ($ownTx) $this->db->commit();
            return $newTotal;
        } catch (\Throwable $e) {
            if ($ownTx && $this->db->inTransaction()) $this->db->rollBack();
            throw $e;
        }
    }

    public function redeem(int $userId, int $rewardId): int
    {
        $ownTx = !$this->db->inTransaction();
        if ($ownTx) $this->db->beginTransaction();

        try {
            $u = $this->users->findById($userId);
            if (!$u) throw new \RuntimeException('USER_NOT_FOUND');

            $reward = $this->rewards->find($rewardId);
            if (!$reward) throw new \RuntimeException('REWARD_NOT_FOUND');
            if ((int)$reward['stock'] === 0) throw new \RuntimeException('OUT_OF_STOCK');

            $cost = (int)$reward['points_required'];
            $current = (int)$u['total_points'];
            if ($current < $cost) throw new \RuntimeException('NOT_ENOUGH_POINTS');

            $newTotal = $current - $cost;
            $this->users->updatePoints($userId, $newTotal);

            if ((int)$reward['stock'] > 0) $this->rewards->decrementStockIfLimited($rewardId);

            $this->tx->add($userId, 'redeemed', $cost, 'Reward: ' . $reward['name'], $newTotal);

            if ($ownTx) $this->db->commit();
            return $newTotal;
        } catch (\Throwable $e) {
            if ($ownTx && $this->db->inTransaction()) $this->db->rollBack();
            throw $e;
        }
    }
}
