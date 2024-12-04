<?php

namespace Tests\Order;

use App\Order\Order;
use App\Order\OrderItem;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Builder\OrderItemBuilder;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use WithFaker;

    public function test_placing_an_order(): void
    {
        // arrange
        $orderItem = OrderItemBuilder::aOrderItem()->build();

        // act
        $sut = Order::place([$orderItem]);

        // assert
        $this->assertInstanceOf(Order::class, $sut);
    }

    public function test_calculate_order_total_price(): void
    {
        // arrange
        $firstOrderItem = OrderItemBuilder::aOrderItem()
            ->withQuantity(2)
            ->withPrice(1_500_000)
            ->build();
        $secondOrderItem = OrderItemBuilder::aOrderItem()
            ->withQuantity(3)
            ->withPrice(300_000)
            ->build();
        $sut = Order::place([$firstOrderItem, $secondOrderItem]);
        $expectedTotalPrice = 3_900_000;

        // act
        $totalPrice = $sut->totalPrice();

        // assert
        $this->assertEquals($expectedTotalPrice, $totalPrice);
    }

    public function test_order_placed_in_pending_status(): void
    {
        // arrange
        $orderItem = OrderItemBuilder::aOrderItem()->build();

        // act
        $sut = Order::place([$orderItem]);

        // assert
        $this->assertTrue($sut->isPending());
    }

    public function test_approving_order(): void
    {
        // arrange
        $orderItem = OrderItemBuilder::aOrderItem()->build();
        $sut = Order::place([$orderItem]);

        // act
        $sut->approve();

        // assert
        $this->assertTrue($sut->isApprove());
    }

    public function test_canceling_order(): void
    {
        // arrange
        $orderItem = OrderItemBuilder::aOrderItem()->build();
        $sut = Order::place([$orderItem]);

        // act
        $sut->cancel();

        // assert
        $this->assertTrue($sut->isCancel());
    }

    public function test_is_not_possible_to_approve_a_canceled_order(): void
    {
        // arrange
        $orderItem = OrderItemBuilder::aOrderItem()->build();
        $sut = Order::place([$orderItem]);
        $sut->cancel();

        // assert
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(Order::CANCEL_TO_IMPROVE_ERROR);

        // act
        $sut->approve();
    }
}
