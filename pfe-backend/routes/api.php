<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BulkUserController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/bulk-import-users', [BulkUserController::class, 'importUsersFromCSV']);
Route::apiResource('students', StudentController::class);
Route::apiResource('professors', ProfessorController::class);
Route::apiResource('options', OptionController::class);



// Protected routes
Route::middleware(['auth:api', 'Cors'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});
