<?php

use Illuminate\Support\Facades\Route;
Route::get('/send-email', [Controller::class, 'sendEmail']);

Route::get('/', function () {
    return view('welcome');
});
