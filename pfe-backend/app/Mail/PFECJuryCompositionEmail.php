<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PFECJuryCompositionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $projectTitle;
    public $juryComposition;

    /**
     * Create a new message instance.
     *
     * @param string $studentName
     * @param string $projectTitle
     * @param array $juryComposition
     */
    public function __construct($studentName, $projectTitle, $juryComposition)
    {
        $this->studentName = $studentName;
        $this->projectTitle = $projectTitle;
        $this->juryComposition = $juryComposition;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('PFE Jury Composition - ' . $this->projectTitle)
                    ->view('emails.pfe_jury_composition');
    }
}
