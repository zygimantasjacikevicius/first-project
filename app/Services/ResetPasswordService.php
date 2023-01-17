<?php

namespace App\Services;

use App\Models\ResetPassword;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ResetPasswordService
{
    public function createReset(array $userData)
    {
        $user = User::where('email', $userData['email'])->first();

        DB::table('reset_passwords')->where('user_id', $user->id)->delete(); //remove all exist tokens
        return ResetPassword::create([
            'token' => Str::random(40),
            'user_id' => $user->id,
        ]);
    }

    public function newPassword(array $userData)
    {
        $resetPassword = ResetPassword::where('token', $userData['token'])->first();
        $user = $resetPassword->user;
        $user->password = $userData['new_password'];
        $user->save();
        $user->resetPassword->delete();
    }
}
