<?php

namespace App\Http\Controllers;

use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $email = 'bentoumimeriem21@gmail.com'; // Replace with the actual email address
        $data = [
            'name' => 'Recipient Name',
            'message' => 'This is your notification message.',
        ];

        try {
            Mail::to($email)->send(new UserNotification($data));
            return "Email sent successfully to $email!";
        } catch (\Exception $e) {
            return "Failed to send email: " . $e->getMessage();
        }
    }
}
