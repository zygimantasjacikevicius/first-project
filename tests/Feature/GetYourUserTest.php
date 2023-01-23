<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class GetYourUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_user_can_get_only_his_user()
    {
        $this->artisan('passport:install', ['--force' => true]);
        $createdUser = User::factory()->create();
        $id = $createdUser->id;
        Passport::actingAs($createdUser);
        $this->get('api/users/' . $id)->assertStatus(200);
    }
}
