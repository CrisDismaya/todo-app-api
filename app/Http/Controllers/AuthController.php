<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\AuthRequest;

use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $user = User::create(
            $request->only(
                'name', 'email', 'password'
            )
        );

        return response()->json([
            'user' => $user,
        ], 201);
    }

    public function login(AuthRequest $request){
        $user = User::where('email', $request->email)->first();

        if (!Auth::attempt($request->all())) {
            return response(['error' => 'Invalid credentials'], 401);
        }

        Auth::user();
        return $user->getToken($user);
    }

    public function logout(){
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        return $user->deleteToken($user);
    }

    public function auth(){
        return [
            'auth' => auth('sanctum')->check()
        ];
    }
}
