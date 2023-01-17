<?php

namespace App\Services;

use App\Models\User;
use App\Models\ResetPassword as ModelsResetPassword;

class NewPasswordService
{
    public function newPassword(array $userData)
    {
        $resetPassword = ModelsResetPassword::where('token', $userData['token'])->first();
        $user = User::where('id', $resetPassword->user_id)->first();
        $user->password = $userData['new_password'];
        $user->save();
        $user->resetPassword->where('user_id', $user->id)->delete();
    }
}
