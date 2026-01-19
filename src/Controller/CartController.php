<?php
namespace App\Controller;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Core\View;
use App\Service\CartService;

final class CartController
{
    public function __construct(
        private View $view,
        private Response $res,
        private Session $session,
        private CartService $cart
    ) {}

    public function show(Request $req): void
    {
        $this->view->render('cart/index.twig', [
            'items' => $this->cart->detailedItems(),
            'total' => $this->cart->total()
        ]);
    }

    public function add(Request $req, array $params): void
    {
        $id = (int)($params['id'] ?? 0);
        $qty = (int)$req->input('qty', 1);
        $this->cart->add($id, $qty);
        $this->session->flash('msg', 'Added to cart');
        $this->res->redirect('/cart');
    }

    public function remove(Request $req, array $params): void
    {
        $id = (int)($params['id'] ?? 0);
        $this->cart->remove($id);
        $this->session->flash('msg', 'Removed');
        $this->res->redirect('/cart');
    }
}
