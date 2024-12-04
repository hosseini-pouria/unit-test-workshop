<?php

namespace App\Order;

use Illuminate\Support\Collection;

class Order
{
    public const CANCEL_TO_IMPROVE_ERROR = 'تایید سفارش کنسل شده امکان پذیر نیست.';

    private OrderStatus $status;

    private function __construct(private Collection $orderItems)
    {
        $this->status = OrderStatus::PENDING;
    }

    public static function place(array $orderItems): Order
    {
        return new Order(collect($orderItems));
    }

    public function totalPrice(): int
    {
        return $this->orderItems->reduce(fn($total, OrderItem $item)=>
            $total+= $item->subTotal(), 0);
    }

    public function isPending(): bool
    {
        return $this->status === OrderStatus::PENDING;
    }

    public function approve(): void
    {
        if ($this->status === OrderStatus::CANCEL) {
            throw new \RuntimeException(self::CANCEL_TO_IMPROVE_ERROR);
        }

        $this->status = OrderStatus::APPROVE;
    }

    public function isApprove(): bool
    {
        return $this->status === OrderStatus::APPROVE;
    }

    public function cancel(): void
    {
        $this->status = OrderStatus::CANCEL;
    }

    public function isCancel(): bool
    {
        return $this->status === OrderStatus::CANCEL;
    }
}
