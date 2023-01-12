<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;
    public function test_create_method()
    {
        $this->artisan('passport:install');
        //create an instance of UserService through the ServiceContainer.
        $userService = app()->make(UserService::class);

        //prepare data
        $data = [
            "email" => "arklys@gmail.com",
            'password' => '123456789'
        ];

        //call service method
        $createdUser = $userService->createUser($data);

        $this->assertSame($data["email"], $createdUser->email, "does not have the same email");
        $this->assertDatabaseHas('users', [
            'email' => 'arklys@gmail.com'
        ]);
        $this->assertInstanceOf(User::class, $createdUser);
    }
}
