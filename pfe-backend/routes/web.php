<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\EmailController;

// use Illuminate\Support\Facades\Mail;

// Route::get('send-test-email', function () {
//     Mail::raw('This is a test email.', function ($message) {
//         $message->to('recipient@example.com')->subject('Test Email');
//     });

//     return "Test email sent!";
// });
use App\Http\Controllers\EmailController;

Route::get('/send-password-email', [EmailController::class, 'sendPasswordEmail']);
Route::get('/send-pfe-proposal-email', [EmailController::class, 'sendPFEProposalEmail']);
Route::get('/send-pfe-proposal-reminder-email', [EmailController::class, 'sendPFEProposalReminderEmail']);
Route::get('send-pfe-supervision-emails', [EmailController::class, 'sendSupervisionEmails']);
Route::get('/send-encadrement-assignment-email', [EmailController::class, 'sendEncadrementAssignmentEmail']);
Route::get('send-pfe-project-not-selected-email', [EmailController::class, 'sendPFEProjectNotSelectedEmail']);
Route::get('send-pfe-project-needs-update-email', [EmailController::class, 'sendPFEProjectNeedsUpdateEmail']);
Route::get('send-pfe-project-rejected-email', [EmailController::class, 'sendPFEProjectRejectedEmail']);
Route::get('send-gl-pfe-choice-email', [EmailController::class, 'sendGLPFEChoiceEmail']);
Route::get('/send-jury-composition', [EmailController::class, 'sendJuryCompositionEmail']);
Route::get('/send-pfe-emails', [EmailController::class, 'sendPFEEmails']);

