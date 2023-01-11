<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
     public function store(StoreUser $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        
        $accessToken = $user->createToken("authToken")->accessToken;
        return response()->json(["access_token" => $accessToken], 201);
    }
}
