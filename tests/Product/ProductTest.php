<?php

namespace Tests\Product;

use App\Models\User;
use App\Product\Product;
use App\Product\ProductId;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Builder\ProductBuilder;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use WithFaker;

    public function test_define_a_product(): void
    {
        // act
        $sut = ProductBuilder::aProduct()->build();

        // assert
        $this->assertInstanceOf(Product::class,$sut);
        $this->assertNotNull(Product::class, $sut->title);


        /*
         *** Inline Fixture setup ***
         */
        /*// arrange
        $productId = ProductId::newId();
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100000,20000000);
        $quantity = $this->faker->numberBetween(10,100);
        $category = $this->faker->word();

        // act
        $sut = new Product($productId, $title, $price, $quantity, $category);

        // assert
        $this->assertEquals($title, $sut->title);
        $this->assertEquals($price, $sut->price);
        $this->assertEquals($quantity, $sut->quantity);
        $this->assertEquals($category, $sut->category);*/
    }

    public function test_not_possible_to_define_a_product_with_negative_price(): void
    {
        try {
            // act
            $sut = ProductBuilder::aProduct()
                ->withPrice(-1_000_000)
                ->build();
        } catch (\Exception $exception) {
            // assert
            $this->assertInstanceOf(\InvalidArgumentException::class, $exception);
            $this->assertEquals(Product::INVALID_PRICE_MESSAGE, $exception->getMessage());
        }

        /*
         *** Inline Fixture setup ***
         */
        /*// arrange
        $price = -1_000_000;

        try {
            // act
            $sut = $this->createProduct($price);
        } catch (\Exception $exception) {
            // assert
            $this->assertInstanceOf(\InvalidArgumentException::class, $exception);
            $this->assertEquals(Product::INVALID_PRICE_MESSAGE, $exception->getMessage());
        }*/

        /*
         *** OR ***
         *
        // assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Product::INVALID_PRICE_MESSAGE);

        // act
        $sut = new Product(ProductId::newId(), $title, $price, $quantity, $category);
        */
    }

    public function test_not_possible_to_define_a_product_with_negative_quantity(): void
    {
        try {
            // act
            $sut = ProductBuilder::aProduct()
                ->withQuantity(-10)
                ->build();
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
        $sut = ProductBuilder::aProduct()->build();

        /*
         ***  use Laravel example ***
         */
        // $user = User::factory()->make();

        // act
        $sut->changePrice($newPrice);

        // assert
        $this->assertEquals($newPrice, $sut->price);
    }

    public function test_it_not_possible_to_change_price_with_negative_price(): void
    {
        // arrange
        $sut = ProductBuilder::aProduct()->build();
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
        $sut = ProductBuilder::aProduct()->build();

        // act
        $sut->changeQuantity($newQuantity);

        // assert
        $this->assertEquals($newQuantity, $sut->quantity);
    }

    public function test_its_not_possible_to_change_quantity_with_negative_value(): void
    {
        // arrange
        $sut = ProductBuilder::aProduct()->build();
        $newQuantity = -10;

        // assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Product::INVALID_QUANTITY_MESSAGE);

        // act
        $sut->changeQuantity($newQuantity);
    }

    public function test_changing_title()
    {
        // arrange
        $sut = ProductBuilder::aProduct()->build();
        $newTitle = $this->faker->sentence(50);

        // act
        $sut->changeTitle($newTitle);

        // assert
        $this->assertEquals($newTitle, $sut->title);
    }

    public function test_empty_title_is_not_allowed(): void
    {
        // arrange
        $sut = ProductBuilder::aProduct()->build();
        $newTitle = '';

        // assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Product::INVALID_TITLE_MESSAGE);

        // act
        $sut->changeTitle($newTitle);
    }

    public function test_title_with_length_lower_than_50_chars_is_not_allowed(): void
    {
        // arrange
        $sut = ProductBuilder::aProduct()->build();
        $newTitle = $this->faker->word();

        // assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Product::INVALID_TITLE_LENGTH_MESSAGE);

        // act
        $sut->changeTitle($newTitle);
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

    public function createProduct(int $price): Product
    {
        $title = $this->faker->word();
        $quantity = $this->faker->numberBetween(10, 100);
        $category = $this->faker->word();

        return new Product(ProductId::newId(), $title, $price, $quantity, $category);
    }
}
