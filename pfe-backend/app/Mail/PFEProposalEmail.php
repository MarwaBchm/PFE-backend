<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PFEProposalEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $userType;
    

   

    public function __construct($userType)
    {
        $this->userType = $userType;
        // $this->message = $message;
    }

    public function build()
    {
        return $this->subject('Call for PFE Proposals')
        ->view('emails.pfe_proposal');  // Update this view as per your email content.
    }
}
