<?php

namespace App\Product;

class Product
{
    public const INVALID_PRICE_MESSAGE = 'قیمت محصول نمی تواند کمتر از صفر باشد';
    public const INVALID_QUANTITY_MESSAGE = 'موجودی محصول نمی تواند کمتر از صفر باشد';

    public function __construct(
        public string $title,
        public int $price,
        public int $quantity,
        public string $category)
    {
        if ($this->price < 0) {
            throw new \InvalidArgumentException(self::INVALID_PRICE_MESSAGE);
        }
        if ($this->quantity < 0) {
            throw new \InvalidArgumentException(self::INVALID_QUANTITY_MESSAGE);
        }
    }

    public function changePrice(int $newPrice): void
    {
        if ($newPrice < 0) {
            throw new \InvalidArgumentException(self::INVALID_PRICE_MESSAGE);
        }

        $this->price = $newPrice;
    }

    public function makeAsFree(): void
    {
        $this->changePrice(0);
    }

    public function changeQuantity(int $newQuantity): void
    {
        if ($newQuantity < 0) {
            throw new \InvalidArgumentException(self::INVALID_QUANTITY_MESSAGE);
        }

        $this->quantity = $newQuantity;
    }

    public function decreaseQuantityByOne(): void
    {
        $this->changeQuantity($this->quantity--);
    }

    public function increaseQuantityByOne(): void
    {
        $this->changeQuantity($this->quantity++);
    }
}
