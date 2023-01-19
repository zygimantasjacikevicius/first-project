<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Testing\TestResponse;

class GetUsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_user_can_get_all_users()
    {
        $this->artisan('passport:install', ['--force' => true]);
        $createdUsers = User::factory()->count(10)->create();
        $pluckedEmails = $createdUsers->pluck('email')->toArray();
        $response = $this->json('GET', 'api/users');
        $this->assertSame($pluckedEmails[0], $response['users'][0]);
    }
}
