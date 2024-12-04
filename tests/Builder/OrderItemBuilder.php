<?php

namespace Tests\Builder;

use App\Order\OrderItem;

class OrderItemBuilder
{
    public function __construct(
        private string $title,
        private int $price,
        private int $quantity)
    {
    }

    public function withTitle(string $title): OrderItemBuilder
    {
        $this->title = $title;
        return $this;
    }

    public function withPrice(string $price): OrderItemBuilder
    {
        $this->price = $price;
        return $this;
    }

    public function withQuantity(string $quantity): OrderItemBuilder
    {
        $this->quantity = $quantity;
        return $this;
    }
    public static function aOrderItem(): OrderItemBuilder
    {
        return new OrderItemBuilder(
            "Order Item 1",
                1_000_000,
            1
        );
    }

    public function build(): OrderItem
    {
        return new OrderItem(
            $this->title,
            $this->price,
            $this->quantity,
        );
    }
}
