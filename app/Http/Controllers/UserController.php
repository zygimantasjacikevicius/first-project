<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteYourUser;
use App\Http\Requests\GetYourUser;
use App\Http\Requests\LoginUser;
use App\Http\Requests\NewPassword;
use App\Http\Requests\ResetPassword;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Http\Resources\UserResource;
use App\Mail\ResetPasswordSent;
use App\Models\ResetPassword as ModelsResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Services\ResetPasswordService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    protected UserService $userService;
    protected ResetPasswordService $resetPasswordService;
    protected ResetPasswordService $newPasswordService;


    public function __construct(UserService $userService, ResetPasswordService $resetPasswordService)
    {
        $this->userService = $userService;
        $this->resetPasswordService = $resetPasswordService;
    }

    public function store(StoreUser $request)
    {
        $user = $this->userService->createUser($request->validated());
        $accessToken = $user->createToken("authToken")->accessToken;
        return response()->json(["token" => $accessToken], 201);
    }

    public function login(LoginUser $request)
    {
        $loginData = $request->validated();

        if (auth()->attempt($loginData)) {

            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            return response()->json(['token' => $accessToken], 200);
        } else {
            return response()->json(['error' => 'Unauthorised Access'], 401);
        }
    }

    public function resetPassword(ResetPassword $request)
    {
        $userReset = $this->resetPasswordService->createReset($request->validated());
        Mail::to($request->email)->send(new ResetPasswordSent($userReset->token));
        return response()->json(['success' => 'Your password token has been sent, please check your inbox'], 200);
    }

    public function newPassword(NewPassword $request)
    {
        $this->resetPasswordService->newPassword($request->validated());
        return response()->json(['success' => 'Your password has been changed'], 200);
    }

    public function update(UpdateUser $request)
    {
        $this->userService->updateUser($request->validated(), $request->user());
        return response()->json(['success' => 'User details have been updated'], 200);
    }

    public function viewAll()
    {
        $users = User::all();
        return response()->json(['users' => $users->pluck('email')->toArray()], 200);
    }

    public function view(GetYourUser $request)
    {
        $userResource = new UserResource(User::findOrFail($request->user()->id));
        return response()->json(['user' => $userResource]);
    }

    public function delete(DeleteYourUser $request)
    {
        $this->userService->deleteUser($request->validated(), $request->user());
        return response()->json(['success' => 'Your account is inactive and an email has been sent with your account info'], 200);
    }
}
