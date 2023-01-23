<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeleteUser;

class UserService
{
    public function createUser(array $userData)
    {
        return User::create($userData);
    }

    public function updateUser(array $userData, User $user)
    {
        if (!empty($userData['new_password'])) {
            $user->password = $userData['new_password'];
        }
        if (!empty($userData['email'])) {
            $user->email = $userData['email'];
        }

        $user->update();
    }

    public function deleteUser(array $userData, User $user)
    {
        $user->status = User::Inactive;
        $user->update();
        $pdf = Pdf::loadView('pdf.user', $user->toArray());
        Mail::to($user->email)->send(new DeleteUser($user, $pdf->output()));
    }
}
