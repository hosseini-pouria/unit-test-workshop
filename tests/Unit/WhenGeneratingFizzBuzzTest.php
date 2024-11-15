<?php

namespace Tests\Unit;

use App\FizzBuzzGenerator;
use Tests\TestCase;

class WhenGeneratingFizzBuzzTest extends TestCase
{
    public function test_generates_number_when_not_divided_by_3_or_5(): void
    {
        // arrange
        $sut = new FizzBuzzGenerator();
        $expected = 2;

        // act
        $result = $sut->generate(2);

        // assert
        $this->assertEquals($expected, $result);
    }

    public function test_generates_fizz_when_divided_by_3(): void
    {
        // arrange
        $sut = new FizzBuzzGenerator();
        $expected = 'Fizz';

        // act
        $result = $sut->generate(3);

        // assert
        $this->assertEquals($expected, $result);
    }

    public function test_generates_buzz_when_divided_by_5(): void
    {
        // arrange
        $sut = new FizzBuzzGenerator();
        $expected = 'Buzz';

        // act
        $result = $sut->generate(5);

        // assert
        $this->assertEquals($expected, $result);
    }

    public function test_generates_fizzbuzz_when_divided_by_3_and_5(): void
    {
        // arrange
        $sut = new FizzBuzzGenerator();
        $expected = 'FizzBuzz';

        // act
        $result = $sut->generate(15);

        // assert
        $this->assertEquals($expected, $result);
    }
}
