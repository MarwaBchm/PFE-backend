<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PFEProjectNotSelectedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $projectTitle;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @param string $studentName
     * @param string $projectTitle
     * @param string $reason
     */
    public function __construct($studentName, $projectTitle, $reason)
    {
        $this->studentName = $studentName;
        $this->projectTitle = $projectTitle;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('PFE Project Submission Status: Not Selected')
                    ->view('emails.pfe_project_not_selected');
    }
}
