<?php

namespace App\Order;

class OrderItem
{
    public function __construct(
        public readonly string $title,
        public readonly int $price,
        public readonly int $quantity)
    {
    }

    public function subTotal(): int
    {
        return $this->price * $this->quantity;
    }
}
