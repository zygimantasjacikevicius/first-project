<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\UserService;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_user_gets_reset_token()
    {
        $this->artisan('passport:install', ['--force' => true]);
        $this->artisan('make:mail', [
            'name' => 'ResetPasswordSent',
            '--markdown'   => true,
        ]);
        $userService = app()->make(UserService::class);
        $data = [
            "email" => "arklys@gmail.com",
            'password' => '123456789',
        ];

        $email = ["email" => "arklys@gmail.com"];

        $userService->createUser($data);

        $this->withoutExceptionHandling()->json('POST', 'api/users/reset', $email)->assertStatus(200);
    }
}
