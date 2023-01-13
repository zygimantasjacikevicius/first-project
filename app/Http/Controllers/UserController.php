<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUser;
use App\Http\Requests\ResetPassword;
use App\Http\Requests\StoreUser;
use App\Mail\ResetPasswordSent;
use App\Models\ResetPassword as ModelsResetPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\UserService;
use App\Services\ResetPasswordService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    protected UserService $userService;
    protected ResetPasswordService $resetPasswordService;

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
        $user = User::where('email', $request->email)->first();
        $time = Carbon::now()->subHour(2);
        // dd(!empty($user->resetPassword->token));
        // dd($user->resetPassword->where('created_at', '<=', $time)->first() == null);
        if (
            !empty($user->resetPassword->token) && $user->resetPassword->where('created_at', '<=', $time)->first() == null
        ) {
            echo "hehe";
            die;
        } else {
            echo "nope";
            die;
        }

        $userReset = $this->resetPasswordService->createReset($request->validated());
        $userReset->token = Str::random(40);
        $userReset->user_id = $user->id;
        $userReset->save();



        Mail::to($request->email)->send(new ResetPasswordSent($userReset->token));
    }
}
