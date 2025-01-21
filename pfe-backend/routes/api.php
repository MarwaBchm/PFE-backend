<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BulkUserController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GroupeController;


// Public routes
Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
Route::post('/bulk-import-users', [BulkUserController::class, 'importUsersFromCSV']);
Route::apiResource('students', StudentController::class);
Route::apiResource('professors', ProfessorController::class);
Route::apiResource('options', OptionController::class);
Route::apiResource('companies', CompanyController::class);

// Check if a student is part of a groupe
Route::get('/groupes/check/{studentId}', [GroupeController::class, 'checkGroupe']);

// Update the invitation state of a groupe
Route::post('/groupes/{groupeId}/update-invitation', [GroupeController::class, 'updateInvitation']);

// Create a new groupe
Route::post('/groupes/create', [GroupeController::class, 'createGroupe']);


// Protected routes
Route::middleware(['auth:api', 'Cors'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});
