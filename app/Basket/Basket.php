<?php

namespace App\Basket;

use App\Product\Product;
use Illuminate\Support\Collection;

class Basket
{
    private Collection $items;

    public function __construct()
    {
        $this->items = collect([]);
    }

    public function addProduct(Product $product): void
    {
        $this->items->put((string)$product->productId, ['quantity' => 1, 'product' => $product]);
    }

    public function count(): int
    {
        return $this->items->count();
    }

    public function totalPrice(): void
    {
        return ;
    }


}
