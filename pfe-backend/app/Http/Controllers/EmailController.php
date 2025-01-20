<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function sendTestEmail()
    {
        Mail::raw('This is a test email.', function ($message) {
            $message->to('meribentoumi@gmail.com')->subject('Test Email');
        });

        return "Test email sent!";
    }
}
