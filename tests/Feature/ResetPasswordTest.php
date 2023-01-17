<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\NewPasswordService;
use App\Services\ResetPasswordService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\UserService;
use Faker\Factory;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_user_gets_reset_token()
    {
        $this->artisan('passport:install', ['--force' => true]);

        $createdUser = User::factory()->create();
        $this->assertDatabaseHas('users', [
            'email' => $createdUser->email
        ]);

        $this->withoutExceptionHandling()->post('api/users/resetpass', [
            'email' => $createdUser->email,
        ])->assertStatus(200);
    }

    public function test_if_user_can_reset_password()
    {
        $this->artisan('passport:install', ['--force' => true]);

        $createdUser = User::factory()->create();

        $passService = app()->make(ResetPasswordService::class);

        $email = [
            "email" => $createdUser->email
        ];
        $createdPassService = $passService->createReset($email);

        $newPass = [
            'token' => $createdPassService->token,
            'new_password' => 'newpassword'
        ];

        $this->json('POST', 'api/users/updatepass', $newPass)->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'password' => $createdUser->password
        ]);
    }
}
