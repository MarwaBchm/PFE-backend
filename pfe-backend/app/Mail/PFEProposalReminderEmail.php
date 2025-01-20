<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PFEProposalReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $userType;
   

    public function __construct($userType)
    {
        $this->userType = $userType;
        
    }

    public function build()
    {
        return $this->subject('Reminder: Submit Your PFE Proposals')
        ->view('emails.pfe_proposal_reminder');   // Your email view
    }
}
