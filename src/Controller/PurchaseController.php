<?php
namespace App\Controller;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Service\AuthService;
use App\Service\PurchaseService;

final class PurchaseController
{
    public function __construct(
        private Response $res,
        private Session $session,
        private AuthService $auth,
        private PurchaseService $purchaseService
    ) {}

    public function simulate(Request $req): void
    {
        try {
            $userId = $this->auth->requireLogin();

            // fake cart for test
            $cart = [
                ['price' => 120, 'quantity' => 1],
                ['price' => 60,  'quantity' => 2],
            ];

            $result = $this->purchaseService->processPurchase($userId, $cart);
            $this->session->flash('msg', "Achat OK, points gagnés: " . $result['points_earned']);
            $this->res->redirect('/dashboard');
        } catch (\Throwable $e) {
            $this->session->flash('msg', 'Erreur: ' . $e->getMessage());
            $this->res->redirect('/login');
        }
    }
}
