<?php

namespace App\Helper;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthHelper
{
    public static function login($request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('token-name')->plainTextToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public static function register($request)
    {
        // Implement your user registration logic here
     
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('token-name')->plainTextToken;
        
        return response()->json(['token' => $token]);

        return response()->json(['message' => 'Registration functionality not implemented'], 500);
    }
}
