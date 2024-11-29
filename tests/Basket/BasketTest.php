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
        $this->assertEquals(1, $sut->itemsCount());
    }

    public function test_add_a_duplicate_product_increases_quantity(): void
    {
        // arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();
        $sut->addProduct($product);

        // act
        $sut->addProduct($product);

        // assert
        $this->assertEquals(1, $sut->itemsCount());
        $this->assertEquals($product->price() * 2 , $sut->totalPrice());
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

    public function test_remove_product()
    {
        // arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();
        $sut->addProduct($product);

        // act
        $sut->removeProduct($product);

        // assert
        $this->assertEquals(0, $sut->itemsCount());
    }

    public function test_decreasing_product_quantity(): void
    {
        // arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();
        $sut->addProduct($product);
        $sut->addProduct($product);

        // act
        $sut->decreasingProductQuantity($product);

        // assert
        $this->assertEquals($product->price(), $sut->totalPrice());
    }

    public function test_its_not_possible_to_decrease_product_quantity_when_it_dose_not_exists_in_the_basket(): void
    {
        // arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();

        // assert
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(Basket::PRODUCT_NOT_FOUND_ERR_MESSAGE);

        // act
        $sut->decreasingProductQuantity($product);
    }

    public function test_deleting_basket(): void
    {
        // arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();
        $sut->addProduct($product);

        // act
        $sut->deleted();

        // arrange
        $this->assertEquals(0, $sut->itemsCount());
    }
}
