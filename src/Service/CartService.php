<?php
namespace App\Service;

use App\Core\Session;
use App\Model\Product;

final class CartService
{
    public function __construct(private Session $session, private Product $products) {}

    public function items(): array
    {
        return $this->session->get('cart', []);
    }

    public function count(): int
    {
        return array_sum($this->items());
    }

    public function add(int $productId, int $qty = 1): void
    {
        $cart = $this->items();
        $cart[$productId] = ($cart[$productId] ?? 0) + max(1, $qty);
        $this->session->set('cart', $cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->items();
        unset($cart[$productId]);
        $this->session->set('cart', $cart);
    }

    public function clear(): void
    {
        $this->session->set('cart', []);
    }

    public function detailedItems(): array
    {
        $result = [];
        foreach ($this->items() as $pid => $qty) {
            $p = $this->products->find((int)$pid);
            if (!$p) continue;

            $unit = (float)$p['price'];
            $q = (int)$qty;

            $result[] = [
                'id' => (int)$p['id'],
                'name' => $p['name'],
                'price' => $unit,
                'image' => $p['image'],
                'quantity' => $q,
                'line_total' => $unit * $q,
            ];
        }
        return $result;
    }

    public function total(): float
    {
        $sum = 0.0;
        foreach ($this->detailedItems() as $it) $sum += (float)$it['line_total'];
        return $sum;
    }
}
