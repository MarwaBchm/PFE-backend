<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Register method
    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:teacher,student,admin', // Validate role
        ]);

        // Create the user
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Return a response
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    // Login method
    public function login(Request $request)
    {
        // Validate the request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Get the authenticated user
        $user = auth()->user();
Log::info("generated token: $token");
        // Return the token and user details
        return response()->json([
            'token' => $token, // This is the valid JWT token
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'role' => $user->role,
            ],
        ]);
    }
    // Logout method
    public function logout(Request $request)
    {
        auth()->logout();
        return response()->json(['message' => 'Logout successful']);
    }

    // Get authenticated user
    public function user(Request $request)
    {
        $user = auth()->user();
        return response()->json($user);
    }
}
