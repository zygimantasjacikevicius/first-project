<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function createUser(array $userData)
    {
        $user = User::create($userData);
        return $user;
    }
}
