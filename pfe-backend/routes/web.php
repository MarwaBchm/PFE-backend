<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;

Route::get('/send-email', [EmailController::class, 'sendEmail']);

// Route::get('/send-email', [Controller::class, 'sendEmail']);

Route::get('/', function () {
    return 'Welcome to Laravel!';
});
// Route::get('/', [App\Http\Controllers\EmailController::class, 'sendEmail']);
