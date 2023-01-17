<?php

namespace App\Services;

use App\Models\ResetPassword;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class ResetPasswordService
{
    public function createReset(array $userData)
    {
        $time = Carbon::now()->subHour(2);
        $user = User::where('email', $userData['email'])->first();

        if (
            !empty($user->resetPassword->token) && $user->resetPassword->where('created_at', '<=', $time)->first() !== null
        ) {
            $user->resetPassword->where('user_id', $user->id)->delete();
            $userReset = new ResetPassword();
            $userReset->token = Str::random(40);
            $userReset->user_id = $user->id;
            $userReset->save();
        } elseif (empty($user->resetPassword->token)) {
            $userReset = new ResetPassword();
            $userReset->token = Str::random(40);
            $userReset->user_id = $user->id;
            $userReset->save();
        } else {
            $userReset = ResetPassword::where('user_id', $user->id)->first();
        }


        return $userReset;
    }
}
