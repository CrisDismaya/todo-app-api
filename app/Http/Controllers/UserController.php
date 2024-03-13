<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $user = User::all();

        return response()->json([
            'user' => $user
        ], 201);
    }

    public function access(){
        $auth = Auth::user();
        $user = User::find($auth->id);
        $user->update([
            'is_active' => ($auth->is_active == '1' ? '0' : '1')
        ]);

        return response()->json([
            'user' => $user
        ], 201);
    }
}
