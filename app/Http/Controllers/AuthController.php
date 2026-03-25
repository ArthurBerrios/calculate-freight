<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $user = User::create($request->all());

        return $user;
    }
    public function login(Request $request)
    {
        $credentials = $request->all();
        
        if(!Auth::attempt($credentials))
        {
            return response()->json('Unauthorized', 401);
        }
        
        $user = Auth::user();
        if($user->tokens())
        {
            $user->tokens()->delete();
        }
        $token = $user->createToken('token');

        return response()->json($token->plainTextToken);
        
    }
}
