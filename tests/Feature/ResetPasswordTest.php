<?php

namespace Tests\Feature;

use App\Services\ResetPasswordService;
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

        $userService = app()->make(UserService::class);
        $data = [
            "email" => "arklys@gmail.com",
            'password' => '123456789',
        ];

        $createdUser = $userService->createUser($data);
        $this->post('api/users/reset', [
            'email' => 'arklys@gmail.com',
        ])->assertStatus(200);
    }

    public function test_if_user_can_reset_password()
    {
        $this->artisan('passport:install', ['--force' => true]);
        $userService = app()->make(UserService::class);
        $passService = app()->make(ResetPasswordService::class);

        $data = [
            "email" => "arklys@gmail.com",
            'password' => '123456789',
        ];

        $createdUser = $userService->createUser($data);
        $email = [
            "email" => $createdUser->email
        ];
        $createdPassService = $passService->createReset($email);

        $newPass = [
            'token' => $createdPassService->token,
            'new_password' => 'newpassword'
        ];

        $this->json('POST', 'api/users/update', $newPass)->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'password' => $createdUser->password
        ]);
    }
}
