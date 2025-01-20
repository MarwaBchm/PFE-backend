<?php


namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PFEEncadrementAssignmentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $supervisorName;
    public $projectTitle;

    /**
     * Create a new message instance.
     *
     * @param string $studentName
     * @param string $supervisorName
     * @param string $projectTitle
     */
    public function __construct($studentName, $supervisorName, $projectTitle)
    {
        $this->studentName = $studentName;
        $this->supervisorName = $supervisorName;
        $this->projectTitle = $projectTitle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('PFE Encadrement Assignment Notification')
                    ->view('emails.pfe_encadrement_assignment');
    }
}