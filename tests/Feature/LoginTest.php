<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_login()
    {
        $this->artisan('passport:install', ['--force' => true]);
        $userService = app()->make(UserService::class);

        $response = $this->json('POST', 'api/users', $data);

        $response->assertStatus(200);
    }
}
