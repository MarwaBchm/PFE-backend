<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GradMasteryPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $userType;
    public $temporaryPassword;
    public $dateTime;

    /**
     * Create a new message instance.
     */
    public function __construct($userType, $temporaryPassword, $dateTime)
    {
        $this->userType = $userType;
        $this->temporaryPassword = $temporaryPassword;
        $this->dateTime = $dateTime;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Welcome to GradMastery!')
            ->view('emails.passwordemail'); // Points to your email view
    }
}
