<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class UpdateUserService
{
    public function updateUser(array $userData)
    {
        $user = Auth::user();

        if (!empty($userData['new_password'])) {
            $user->password = $userData['new_password'];
        }
        if (!empty($userData['email'])) {
            $user->email = $userData['email'];
        }

        if ($user->can('update', $user)) {
            $user->update();
        } else {
            echo 'Not Authorized to update.';
        }
    }
}
