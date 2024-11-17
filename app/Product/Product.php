<?php

namespace App\Product;

class Product
{
    public const INVALID_PRICE_MESSAGE = 'قیمت محصول نمی تواند کمتر از صفر باشد';
    public const INVALID_QUANTITY_MESSAGE = 'موجودی محصول نمی تواند کمتر از صفر باشد';

    public function __construct(
        public readonly string $title,
        public readonly int $price,
        public readonly int $quantity,
        public readonly string $category)
    {
        if ($this->price < 0) {
            throw new \InvalidArgumentException(self::INVALID_PRICE_MESSAGE);
        }
        if ($this->quantity < 0) {
            throw new \InvalidArgumentException(self::INVALID_QUANTITY_MESSAGE);
        }
    }
}
