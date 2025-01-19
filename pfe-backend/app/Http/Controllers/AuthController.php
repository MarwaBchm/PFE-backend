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
use App\Mail\UserCreatedMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Register method
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'role' => 'required|in:student,professor,company', // Validate role
            'firstname' => 'required_if:role,student,professor,company', // Required for students, professors, and companies
            'lastname' => 'required_if:role,student,professor,company', // Required for students, professors, and companies
            'denomination' => 'required_if:role,company', // Required for companies
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate a random password
        $password = Str::password(12); // Generates a 12-character random password

        // Generate a username (e.g., firstname.lastname)
        $username = Str::slug($request->firstname . '.' . $request->lastname, '.');

        // Ensure the username is unique
        $username = $this->makeUsernameUnique($username);

        // Create the user
        $user = User::create([
            'email' => $request->email,
            'username' => $username, // Add the generated username
            'password' => Hash::make($password), // Use the generated password
            'role' => $request->role,
        ]);

        // Send welcome email with the generated password and username
        Mail::to($user->email)->send(new UserCreatedMail($user, $password, $username));

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
    /**
     * Ensure the username is unique by appending a number if necessary.
     *
     * @param string $username
     * @return string
     */
    private function makeUsernameUnique($username)
    {
        $originalUsername = $username;
        $counter = 1;

        // Check if the username already exists
        while (User::where('username', $username)->exists()) {
            $username = $originalUsername . '.' . $counter;
            $counter++;
        }

        return $username;
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
