<?php

namespace App\Services;

use App\Models\ResetPassword;

class ResetPasswordService
{
    public function createReset(array $userData)
    {
        return ResetPassword::create($userData);
    }
}
