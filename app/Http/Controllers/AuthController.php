<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Register new user
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:6',
            'password_confirmation'=> 'required|same:password',
'phone_number' => 'nullable|string|max:30'            // 'role'=>'required|in:user,owner,admin',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'password_confirmation'=> Hash::make($request->password_confirmation),
            'role' => 'admin',
            'phone_number' => $request->phone_number ?? null,

        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),201);
    }

    // Login
    public function login(Request $request)
    {
        $credentials = $request->only('email','password' );

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error'=>'Invalid credentials'],401);
        }

        return response()->json(compact('token'));
    }

    // Get logged in user
    public function me()
    {
        return response()->json(auth()->user());
    }

    // Logout
    public function logout()
    {
        auth()->logout();
        return response()->json(['message'=>'Logged out successfully']);
    }
}
