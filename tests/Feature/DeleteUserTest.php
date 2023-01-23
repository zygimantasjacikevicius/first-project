<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_you_can_delete_the_user()
    {
        $this->artisan('passport:install', ['--force' => true]);
        $createdUser = User::factory()->create();
        $id = $createdUser->id;
        Passport::actingAs($createdUser);
        $this->json('DELETE', 'api/users/' . $id)->assertStatus(200);
    }
}
