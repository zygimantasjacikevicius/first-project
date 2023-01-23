<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_you_can_delete_the_user()
    {
        $this->artisan('passport:install', ['--force' => true]);
        $createdUsers = User::factory()->count(10)->create();
        Schema::table('users', function (Blueprint $table) {
            $table->string('token')->nullable();
        });
        foreach ($createdUsers as &$createdUser) {

            $createdUser->token = $createdUser->createToken("authToken")->accessToken;
        }

        $id = 8;
        $createdUser = $createdUsers->where('id', '=', $id)->first();
        $this->withHeader('Authorization', 'Bearer ' . $createdUser->token)->json('DELETE', 'api/users/' . $id)->assertStatus(200);
    }
}
