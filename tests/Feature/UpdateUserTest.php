<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_user_can_update_email()
    {
        $this->artisan('passport:install', ['--force' => true]);
        $faker = \Faker\Factory::create();
        $createdUser = User::factory()->create();
        $token = $createdUser->createToken("authToken")->accessToken;
        $this->withHeader('Authorization', 'Bearer ' . $token)->put('api/users', [
            'email' => $faker->email,
        ])->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'email' => $createdUser->email
        ]);
    }

    public function test_if_user_can_update_password()
    {
        $this->artisan('passport:install', ['--force' => true]);
        $createdUser = User::factory()->create();
        $token = $createdUser->createToken("authToken")->accessToken;
        $this->withHeader('Authorization', 'Bearer ' . $token)->put('api/users', [
            'new_password' => 'new_password',
            'new_password_confirmation' => 'new_password'
        ])->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'password' => $createdUser->password
        ]);
    }
}
