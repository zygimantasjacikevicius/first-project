<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        
        return User::all();
    }

    public function store(StoreUser $request)
    {
        
        $user = new User;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        
        $accessToken = $user->createToken("authToken")->accessToken;
        // dd($accessToken);
        return response()->json([201, "access_token" => $accessToken]);
    }
}
