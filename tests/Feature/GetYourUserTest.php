<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GetYourUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_if_user_can_get_only_his_user()
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
        $this->withHeader('Authorization', 'Bearer ' . $createdUser->token)->get('api/users/' . $id)->assertStatus(200);
    }
}
