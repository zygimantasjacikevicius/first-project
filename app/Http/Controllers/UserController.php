<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUser;
use App\Http\Requests\StoreUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
}
