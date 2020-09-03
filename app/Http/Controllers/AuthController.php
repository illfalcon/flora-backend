<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(['email', 'password']), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);
        if (!$validator->passes()) {
            return response(['errors'=> $validator->errors()->first()]);
        }
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
        $validator = Validator::make($request->all(['email', 'password']), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        if (!$validator->passes()) {
            return response(['errors'=> $validator->errors()->first()], 400);
        }
        $data = $request->all(['name', 'email', 'password']);
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        $token = $user->createToken('authUser')->accessToken;
        return response(['user' => $user, 'token' => $token], 200);
    }
}
