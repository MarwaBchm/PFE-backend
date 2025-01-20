<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\GradMasteryPassword; // This is the Mailable for password email
use App\Mail\PFEProposalEmail;  // This is the Mailable for proposal email
use App\Mail\PFEProposalReminderEmail; 
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{
    public function sendPasswordEmail()
    {
        // Example data
        $users = [
            ['type' => 'Student', 'email' => 'meribentoumi@gmail.com'],
            ['type' => 'Professor', 'email' => 'bentoumimeriem21@gmail.com'],
            ['type' => 'Enterprise', 'email' => 'benmeriem784@gmail.com'],
        ];

        foreach ($users as $user) {
            $password = Str::random(8); // Generate a unique random password
            $dateTime = now()->format('Y-m-d H:i:s'); // Current date and time

            // Send email
            Mail::to($user['email'])->send(new GradMasteryPassword($user['type'], $password, $dateTime));
        }

        return 'Password emails sent successfully!';
    }

public function sendPFEProposalEmail()
    {
        // Example data for sending the PFE proposal email
        $users = [
            ['type' => 'Student', 'email' => 'meribentoumi@gmail.com'],
            ['type' => 'Professor', 'email' => 'bentoumimeriem21@gmail.com'],
            ['type' => 'Enterprise', 'email' => 'benmeriem784@gmail.com'],
        ];

        // Message content for the proposal email
        

        foreach ($users as $user) {
            // Send the PFE proposal email to the user
            Mail::to($user['email'])->send(new PFEProposalEmail($user['type']));
        }

        return 'PFE Proposal emails sent successfully!';
    }
    public function sendPFEProposalReminderEmail()
{
    // Example array of users
    $users = [
        ['type' => 'Student', 'email' => 'meribentoumi@gmail.com'],
        ['type' => 'Professor', 'email' => 'bentoumimeriem21@gmail.com'],
        ['type' => 'Enterprise', 'email' => 'benmeriem784@gmail.com'],
    ];


    foreach ($users as $user) {
        // Send the reminder email to each user
        Mail::to($user['email'])->send(new PFEProposalReminderEmail($user['type']));
    }

    return "PFE proposal reminder emails sent successfully!";
}

}