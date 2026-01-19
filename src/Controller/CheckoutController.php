<?php
namespace App\Controller;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Model\User;
use App\Service\CartService;
use App\Service\PurchaseService;

final class CheckoutController
{
    public function __construct(
        private View $view,
        private Response $res,
        private Session $session,
        private User $users,
        private CartService $cart,
        private PurchaseService $purchaseService
    ) {}

    public function show(Request $req): void
    {
        $items = $this->cart->detailedItems();
        if (!$items) {
            $this->session->flash('msg', 'Your cart is empty');
            $this->res->redirect('/products');
        }

        $this->view->render('checkout/index.twig', [
            'items' => $items,
            'total' => $this->cart->total()
        ]);
    }

    public function pay(Request $req, int $userId): void
    {
        $items = $this->cart->detailedItems();
        if (!$items) {
            $this->session->flash('msg', 'Your cart is empty');
            $this->res->redirect('/products');
        }

       
        $password = (string)$req->input('password', '');
        if (trim($password) === '') {
            $this->session->flash('msg', 'Password required to confirm checkout');
            $this->res->redirect('/checkout');
        }

        $user = $this->users->findById($userId);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            $this->session->flash('msg', 'Wrong password');
            $this->res->redirect('/checkout');
        }

        $method = (string)$req->input('method', 'test_card');

        $result = $this->purchaseService->processPurchase($userId, $items);

        $this->cart->clear();
        $this->session->set('last_purchase', [
            'purchase_id' => $result['purchase_id'],
            'total_amount' => $result['total_amount'],
            'points_earned' => $result['points_earned'],
            'payment_method' => $method
        ]);

        $this->session->flash('msg', 'Payment');
        $this->res->redirect('/checkout/success');
    }

    public function success(Request $req): void
    {
        $purchase = $this->session->get('last_purchase');
        if (!$purchase) $this->res->redirect('/products');

        $this->view->render('checkout/success.twig', [
            'purchase' => $purchase
        ]);
    }
}
