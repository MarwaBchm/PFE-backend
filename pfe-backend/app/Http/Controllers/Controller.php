<?php

namespace App\Http\Controllers;
use App\Mail\WelcomeEmail;
// use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
//     public function sendEmail()
//     {
//         // Define the recipient's email and data
//         $email = 'bentoumimeriem21@gmail.com'; // Replace with the recipient's email
//         $data = [
//             'name' => 'Recipient Name', // Replace with the recipient's name
//             'message' => 'This is your notification message.',
//         ];

//         // Send the email using the UserNotification Mailable
//         try {
//             Mail::to($email)->send(new UserNotification($data));
//             return "Email sent successfully to $email!";
//         } catch (\Exception $e) {
//             return "Failed to send email: " . $e->getMessage();
//         }
//     }
// }
// use App\Mail\WelcomeEmail;
// use Illuminate\Support\Facades\Mail;

public function sendWelcomeEmail()
{
    $user = User::find(1); // Replace with your user data
    Mail::to($user->email)->send(new WelcomeEmail($user));

    return "Email sent successfully!";
}}