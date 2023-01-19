<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function createUser(array $userData)
    {
        return User::create($userData);
    }

    public function updateUser(array $userData)
    {
        $user = Auth::user();

        if (!empty($userData['new_password'])) {
            $user->password = $userData['new_password'];
        }
        if (!empty($userData['email'])) {
            $user->email = $userData['email'];
        }

        $user->update();
    }
}
