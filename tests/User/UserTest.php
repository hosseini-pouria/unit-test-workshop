<?php

namespace Tests\User;

use App\User\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Builder\UserBuilder;
use Tests\TestCase;
use Tests\Users;

class UserTest extends TestCase
{
    use WithFaker;

    public function test_user_registration(): void
    {
        // arrange
        $firstName = $this->faker()->firstName();
        $lastName = $this->faker()->lastName();
        $emailAddress = $this->faker()->email;
        $password = $this->faker()->password;

        // act
        $sut = User::register($firstName, $lastName, $emailAddress, $password);

        // assert
        $this->assertInstanceOf(User::class, $sut);
    }

    public function test_changing_first_name()
    {
        // arrange
        $sut = UserBuilder::anUser()->whoseFirstNameIs(Users::MOHAMMAD)->build();

        // act
        $sut->changeFirstName(Users::ALI);

        // assert
        $this->assertEquals(Users::ALI, $sut->firstName());
    }
}
