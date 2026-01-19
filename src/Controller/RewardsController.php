<?php
namespace App\Controller;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Model\Reward;
use App\Service\PointsService;

final class RewardsController
{
    public function __construct(
        private View $view,
        private Response $res,
        private Session $session,
        private Reward $rewards,
        private PointsService $points
    ) {}

    public function index(Request $req): void
    {
        $this->view->render('rewards/index.twig', ['rewards' => $this->rewards->all()]);
    }

    public function redeem(Request $req, int $userId, array $params): void
    {
        try {
            $id = (int)($params['id'] ?? 0);
            $this->points->redeem($userId, $id);
            $this->session->flash('msg', 'Reward redeemed');
        } catch (\Throwable $e) {
            $this->session->flash('msg', $e->getMessage());
        }
        $this->res->redirect('/rewards');
    }
}
