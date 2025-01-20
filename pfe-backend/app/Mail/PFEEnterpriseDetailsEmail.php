<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PFEEnterpriseDetailsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $enterpriseName;
    public $projectName;
    public $date;
    public $time;
    public $room;

    public function __construct($enterpriseName, $projectName, $date, $time, $room)
    {
        $this->enterpriseName = $enterpriseName;
        $this->projectName = $projectName;
        $this->date = $date;
        $this->time = $time;
        $this->room = $room;
    }

    public function build()
    {
        return $this->subject('Details of the PFE Partnership - ' . $this->projectName)
                    ->view('emails.pfe_enterprise_details');
    }
}
