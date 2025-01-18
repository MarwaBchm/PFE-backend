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
                'password' => 'required|string|min:6',
                'role' => 'required|in:student,professor,company',
                'firstname' => 'required_if:role,student,professor,company',
                'lastname' => 'required_if:role,student,professor,company',
                'denomination' => 'required_if:role,company',
            ]);

            // If validation fails, log the error and skip the row
            if ($validator->fails()) {
                Log::error('Validation failed for row:', [
                    'row' => $rowData,
                    'errors' => $validator->errors(),
                ]);
                continue;
            }

            // Create the user
            $user = User::create([
                'email' => $rowData['email'],
                'password' => Hash::make($rowData['password']),
                'role' => $rowData['role'],
            ]);
            Mail::to($user->email)->send(new UserCreatedMail($user, $rowData['password']));
            // Create role-specific records
            switch ($rowData['role']) {
                case 'student':
                    Student::create([
                        'firstname' => $rowData['firstname'],
                        'lastname' => $rowData['lastname'],
                        'user_id' => $user->id,
                    ]);
                    break;

                case 'professor':
                    Professor::create([
                        'firstname' => $rowData['firstname'],
                        'lastname' => $rowData['lastname'],
                        'user_id' => $user->id,
                    ]);
                    break;

                case 'company':
                    Company::create([
                        'firstname' => $rowData['firstname'],
                        'lastname' => $rowData['lastname'],
                        'denomination' => $rowData['denomination'],
                        'user_id' => $user->id,
                    ]);
                    break;
            }

            // Add the created user to the response
            $createdUsers[] = $user;
        }

        // Return a response
        return response()->json([
            'message' => 'Users created successfully',
            'created_users' => $createdUsers,
        ], 201);
    }
}
