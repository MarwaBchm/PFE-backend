<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // Add this line
use App\Models\User;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Company;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log; // For logging

class AuthController extends Controller
{
    // Register method
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:student,professor,company', // Validate role
            'firstname' => 'required_if:role,student,professor,company', // Required for students, professors, and companies
            'lastname' => 'required_if:role,student,professor,company', // Required for students, professors, and companies
            'denomination' => 'required_if:role,company', // Required for companies
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the user
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Log the user creation
        Log::info('User created:', $user->toArray());

        // Create role-specific records
        switch ($request->role) {
            case 'student':
                Student::create([
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'user_id' => $user->id,
                ]);
                break;

            case 'professor':
                Professor::create([
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'user_id' => $user->id,
                ]);
                break;

            case 'company':
                try {
                    Company::create([
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'denomination' => $request->denomination,
                        'user_id' => $user->id,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to create company:', ['error' => $e->getMessage()]);
                    return response()->json(['message' => 'Failed to create company record'], 500);
                }
                break;
        }

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
        // Return the token and user details
        return response()->json([
            'token' => $token, // This is the valid JWT token
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
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
