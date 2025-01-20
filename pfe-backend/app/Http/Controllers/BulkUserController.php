<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Professor;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use App\Mail\UserCreatedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class BulkUserController extends Controller
{
    /**
     * Handle bulk user creation from a CSV file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importUsersFromCSV(Request $request)
    {
        // Validate the request
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        // Get the CSV file
        $file = $request->file('csv_file');

        // Open the CSV file
        $csvData = array_map('str_getcsv', file($file));

        // Remove the header row
        $header = array_shift($csvData);

        // Process each row
        $createdUsers = [];
        foreach ($csvData as $row) {
            // Map the row data to an associative array
            $rowData = array_combine($header, $row);

            // Validate the row data
            $validator = Validator::make($rowData, [
                'email' => 'required|email|unique:users',
                'role' => 'required|in:student,professor,company',
                'firstname' => 'required_if:role,student,professor,company',
                'lastname' => 'required_if:role,student,professor,company',
                'denomination' => 'required_if:role,company',
                'grade' => 'required_if:role,professor|string', // Validate grade for professors
                'recruitment_date' => 'required_if:role,professor|date', // Validate recruitment_date for professors
                'contact' => 'required_if:role,company',
                'type' => 'required_if:role,company',
                'master_average' => 'required_if:role,student|numeric|min:0|max:20', // Validate master_average for students
            ]);

            // If validation fails, log the error and skip the row
            if ($validator->fails()) {
                Log::error('Validation failed for row:', [
                    'row' => $rowData,
                    'errors' => $validator->errors(),
                ]);
                continue;
            }

            // Generate a random password
            $password = Str::password(12); // Generates a 12-character random password

            // Generate a username (e.g., firstname.lastname)
            $username = Str::slug($rowData['firstname'] . '.' . $rowData['lastname'], '.');

            // Ensure the username is unique
            $username = $this->makeUsernameUnique($username);

            // Create the user
            $user = User::create([
                'email' => $rowData['email'],
                'username' => $username,
                'password' => Hash::make($password),
                'role' => $rowData['role'],
            ]);

            // Send welcome email with the generated password and username
            Mail::to($user->email)->send(new UserCreatedMail($user, $password, $username));

            // Log the user creation
            Log::info('User created:', $user->toArray());

            // Create role-specific records
            switch ($rowData['role']) {
                case 'student':
                    Student::create([
                        'firstname' => $rowData['firstname'],
                        'lastname' => $rowData['lastname'],
                        'master_average' => $rowData['master_average'],
                        'ranking' => 0, // Temporary value, will be updated later
                        'user_id' => $user->id,
                    ]);
                    break;

                case 'professor':
                    Professor::create([
                        'firstname' => $rowData['firstname'],
                        'lastname' => $rowData['lastname'],
                        'grade' => $rowData['grade'],
                        'recruitment_date' => $rowData['recruitment_date'],
                        'user_id' => $user->id,
                    ]);
                    break;

                case 'company':
                    Company::create([
                        'firstname' => $rowData['firstname'],
                        'lastname' => $rowData['lastname'],
                        'denomination' => $rowData['denomination'],
                        'contact' => $rowData['contact'],
                        'type' => $rowData['type'],
                        'user_id' => $user->id,
                    ]);
                    break;
            }

            // Add the created user to the response
            $createdUsers[] = $user;
        }

        // Calculate and update rankings for students
        $this->updateStudentRankings();

        // Return a response
        return response()->json([
            'message' => 'Users created successfully',
            'created_users' => $createdUsers,
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
}
