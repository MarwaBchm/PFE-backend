<?php

namespace App\Http\Controllers;

use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendEmail()
    {
        // Fetch user data from the database
        $users = \DB::table('users')->get(); // Replace 'users' with your table name

        foreach ($users as $user) {
            $data = [
                'name' => $user->name,
                'message' => 'This is your notification message.',
            ];

            // Send email using the UserNotification Mailable
            Mail::to($user->email)->send(new UserNotification($data));
        }

        return "Emails sent successfully!";
    }
}
