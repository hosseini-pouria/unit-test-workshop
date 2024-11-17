<?php

namespace Tests\Product;

use App\Product\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use WithFaker;

    public function test_define_a_product(): void
    {
        // arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100000,20000000);
        $quantity = $this->faker->numberBetween(10,100);;
        $category = $this->faker->word();

        // act
        $sut = new Product($title,$price,$quantity,$category);

        // assert
        $this->assertEquals($title, $sut->title);
        $this->assertEquals($price, $sut->price);
        $this->assertEquals($quantity, $sut->quantity);
        $this->assertEquals($category, $sut->category);
    }

    public function test_not_possible_to_define_a_product_with_negative_price(): void
    {
        // arrange
        $title = $this->faker->word();
        $price = -1000000;
        $quantity = $this->faker->numberBetween(10,100);
        $category = $this->faker->word();

        try {
            // act
            $sut = new Product($title,$price,$quantity,$category);
        } catch (\Exception $exception) {
            // assert
            $this->assertInstanceOf(\InvalidArgumentException::class, $exception);
            $this->assertEquals(Product::INVALID_PRICE_MESSAGE, $exception->getMessage());
        }

        /*
         *** OR ***
         *
        // assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Product::INVALID_PRICE_MESSAGE);

        // act
        $sut = new Product($title,$price,$quantity,$category);
        */
    }

    public function test_not_possible_to_define_a_product_with_negative_quantity(): void
    {
        // arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100000,20000000);
        $quantity = -10;
        $category = $this->faker->word();

        try {
            // act
            $sut = new Product($title,$price,$quantity,$category);
        } catch (\Exception $exception) {
            // assert
            $this->assertInstanceOf(\InvalidArgumentException::class, $exception);
            $this->assertEquals(Product::INVALID_QUANTITY_MESSAGE, $exception->getMessage());
        }
    }

}
