<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PFEProjectNeedsUpdateEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $projectTitle;

    /**
     * Create a new message instance.
     *
     * @param string $studentName
     * @param string $projectTitle
     */
    public function __construct($studentName, $projectTitle)
    {
        $this->studentName = $studentName;
        $this->projectTitle = $projectTitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('PFE Project Proposal Needs Update')
                    ->view('emails.pfe_project_needs_update');
    }
}
