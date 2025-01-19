<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $username;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\User  $user
     * @param  string  $password
     * @param  string  $username
     * @return void
     */
    public function __construct($user, $password, $username)
    {
        $this->user = $user;
        $this->password = $password;
        $this->username = $username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to ' . config('app.name'))
                    ->view('emails.user_created');
    }
}
