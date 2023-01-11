<?php

namespace Tests\Unit;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_method()
    {
        //create an instance of UserService through the ServiceContainer.
        $userService = app()->make(UserService::class);

        //prepare data
        $data = [
            "email" => "arklys@gmail.com",
            'password' => '123456789'
        ];

        //call service method
        $createdUser = $userService->createUser($data);

        //check all necessary changes and response.
        // You can use any asserts you need. find them in Laravel documentation
        $this->assertSame($data["email"], $createdUser->email, "does not have the same email"); //check Laravel documentation
        // $this->assertDatabaseHas($use) //check Laravel documentation
    }
}
