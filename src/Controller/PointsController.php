<?php
namespace App\Controller;

use App\Core\Request;
use App\Core\View;
use App\Model\PointsTransaction;

final class PointsController
{
    public function __construct(private View $view, private PointsTransaction $tx) {}

    public function history(Request $req, int $userId): void
    {
        $this->view->render('points/history.twig', [
            'history' => $this->tx->historyByUser($userId)
        ]);
    }
}
