<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Company;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
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
            'role' => 'required|in:student,professor,company',
            'firstname' => 'required_if:role,student,professor,company',
            'lastname' => 'required_if:role,student,professor,company',
            'denomination' => 'required_if:role,company',
            'grade' => 'required_if:role,professor', // Required for professors
            'recruitment_date' => 'required_if:role,professor|date', // Ensure it's a valid date
            'contact' => 'required_if:role,company',
            'type' => 'required_if:role,company',
            'master_average' => 'required_if:role,student|numeric|min:0|max:20',
            'option_id' => 'required_if:role,student|exists:options,id', // Ensure option_id exists in options table
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
            'username' => $username,
            'password' => Hash::make($password),
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
                    'master_average' => $request->master_average,
                    'ranking' => 0,
                    'user_id' => $user->id,
                    'option_id' => $request->option_id, // Add option_id
                ]);
                break;

            case 'professor':
                Professor::create([
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'grade' => $request->grade,
                    'recruitment_date' => $request->recruitment_date,
                    'user_id' => $user->id,
                ]);
                break;

            case 'company':
                Company::create([
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'denomination' => $request->denomination,
                    'contact' => $request->contact,
                    'type' => $request->type,
                    'user_id' => $user->id,
                ]);
                break;
        }

        // Calculate and update rankings for students
        $this->updateStudentRankings();

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

    /**
     * Calculate and update rankings for all students based on their master_average.
     */
    private function updateStudentRankings()
    {
        // Fetch all students ordered by master_average (descending)
        $students = Student::orderBy('master_average', 'desc')->get();

        // Update rankings
        $ranking = 1;
        foreach ($students as $student) {
            $student->update(['ranking' => $ranking]);
            $ranking++;
        }
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
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'username' => $user->username,
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

        // Load role-specific data based on the user's role
        switch ($user->role) {
            case 'student':
                $user->load('student');
                break;

            case 'professor':
                $user->load('professor'); // Load professor data
                break;

            case 'company':
                $user->load('company');
                break;
        }

        return response()->json($user);
    }
}
