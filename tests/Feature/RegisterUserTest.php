<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_user()
    {
        $this->artisan('passport:install');
        $data = [

            "email" => "arklys@gmail.com",
            'password' => '123456789',
            'password_confirmation' => "123456789",

        ];

        $response = $this->json('POST', 'api/users', $data)->assertStatus(201);

        $response->assertStatus(200);
    }
}
