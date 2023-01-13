<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\UserService;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_login()
    {
        $this->artisan('passport:install', ['--force' => true]);
        $userService = app()->make(UserService::class);
        $data = [
            "email" => "arklys@gmail.com",
            'password' => '123456789',
        ];

        $userService->createUser($data);
        $this->json('POST', 'api/users/login', $data);
        $this->assertAuthenticated();
    }

    public function test_user_with_invalid_password()
    {
        $this->artisan('passport:install', ['--force' => true]);
        $userService = app()->make(UserService::class);
        $data = [
            "email" => "arklys@gmail.com",
            'password' => '123456789',
        ];

        $userService->createUser($data);

        $this->post('api/users/login', [
            'email' => 'arklys@gmail.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
