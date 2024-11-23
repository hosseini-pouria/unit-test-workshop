<?php

namespace Tests\Product;

use App\Models\User;
use App\Product\Product;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
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

    #[DataProvider('priceList')]
    public function test_changing_price(int $newPrice): void
    {
        // arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100_000,500_000);
        $quantity = $this->faker->numberBetween(10,100);;
        $category = $this->faker->word();
        $sut = new Product($title,$price,$quantity,$category);
        // $user = User::factory()->make(); // Laravel example

        // act
        $sut->changePrice($newPrice);

        // assert
        $this->assertEquals($newPrice, $sut->price);
    }

    public function test_it_not_possible_to_change_price_with_negative_price(): void
    {
        // arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100_000,500_000);
        $quantity = $this->faker->numberBetween(10,100);;
        $category = $this->faker->word();
        $sut = new Product($title,$price,$quantity,$category);
        $newPrice = -2_000_000;

        try {
            // act
            $sut->changePrice($newPrice);
        } catch (\Exception $exception) {
            // assert
            $this->assertInstanceOf(\InvalidArgumentException::class, $exception);
            $this->assertEquals(Product::INVALID_PRICE_MESSAGE, $exception->getMessage());
        }
    }

    #[DataProvider('quantityList')]
    public function test_changing_quantity(int $newQuantity)
    {
        // arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100_000,500_000);
        $quantity = $this->faker->numberBetween(10,100);;
        $category = $this->faker->word();
        $sut = new Product($title,$price,$quantity,$category);

        // act
        $sut->changeQuantity($newQuantity);

        // assert
        $this->assertEquals($newQuantity, $sut->quantity);
    }

    public function test_its_not_possible_to_change_quantity_with_negative_value(): void
    {
        // arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100_000,500_000);
        $quantity = $this->faker->numberBetween(10,100);;
        $category = $this->faker->word();
        $sut = new Product($title,$price,$quantity,$category);
        $newQuantity = -10;

        // assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Product::INVALID_QUANTITY_MESSAGE);

        // act
        $sut->changeQuantity($newQuantity);
    }

    public static function priceList(): array
    {
        return[
            'مقدار یک میلیون تومان' => [1_000_000],
            'مقدار صفر' => [0]
        ];
    }

    public static function quantityList(): array
    {
        return[
            'تعداد 60' => [60],
            'تعداد صفر' => [0]
        ];
    }
}
