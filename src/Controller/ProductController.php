<?php
namespace App\Controller;

use App\Core\Request;
use App\Core\View;
use App\Model\Product;

final class ProductController
{
    public function __construct(private View $view, private Product $products) {}

    public function index(Request $req): void
    {
        $this->view->render('products/index.twig', [
            'products' => $this->products->all()
        ]);
    }
}
