<?php

namespace Tests\Basket;

use App\Basket\Basket;
use Tests\Builder\ProductBuilder;
use Tests\TestCase;

class BasketTest extends TestCase
{
    public function test_adding_product(): void
    {
        // arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();

        // act
        $sut->addProduct($product);

        // assert
        $this->assertEquals(1, $sut->count());
    }

    public function test_add_a_duplicate_product_increases_quantity(): void
    {
        // arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();
        $sut->addProduct($product);
        $expectedQuantity = 2;

        // act
        $sut->addProduct($product);

        // assert
        $this->assertEquals(1, $sut->count());
      //  $this->assertEquals($expectedQuantity, );
    }

    public function test_calculate_total_price(): void
    {
        // arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();
        $sut->addProduct($product);

        // act
        $totalPrice = $sut->totalPrice();

        // assert
        $this->assertEquals($product->price(), $totalPrice);
    }
}
