<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\EmailController;

use Illuminate\Support\Facades\Mail;

Route::get('send-test-email', function () {
    Mail::raw('This is a test email.', function ($message) {
        $message->to('recipient@example.com')->subject('Test Email');
    });

    return "Test email sent!";
});
