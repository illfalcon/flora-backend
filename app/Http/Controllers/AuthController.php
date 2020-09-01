<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all(['email', 'password']);
        if (!Auth::attempt($credentials))
        {
            return response(['error' => 'invalid credentials'], 400);
        }

        $user = Auth::user();
        $token = $user->createToken('authUser')->accessToken;

        return response(['user' => $user, 'token' => $token]);
    }

    public function register(Request $request)
    {
        $data = $request->all(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        $token = $user->createToken('authUser')->accessToken;
        return response(['user' => $user, 'token' => $token], 200);
    }
}
