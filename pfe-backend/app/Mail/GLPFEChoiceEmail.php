<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GLPFEChoiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $availablePFEs;

    /**
     * Create a new message instance.
     *
     * @param string $studentName
     * @param array $availablePFEs
     */
    public function __construct($studentName, $availablePFEs)
    {
        $this->studentName = $studentName;
        $this->availablePFEs = $availablePFEs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Choisissez un PFE pour votre option GL')
                    ->view('emails.gl_pfe_choice');
    }
}
