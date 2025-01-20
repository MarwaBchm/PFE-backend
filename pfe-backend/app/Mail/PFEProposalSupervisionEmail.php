<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PFEProposalSupervisionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $userType;
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userType)
    {
        $this->userType = $userType;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Call for PFE Supervision: Student and Enterprise Proposals')
                    ->view('emails.pfe_proposal_supervision'); // Make sure this view exists
    }
}
