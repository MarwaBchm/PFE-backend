<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PFEProfessorDetailsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $professorName;
    public $projectName;
    public $date;
    public $time;
    public $room;

    public function __construct($professorName, $projectName, $date, $time, $room)
    {
        $this->professorName = $professorName;
        $this->projectName = $projectName;
        $this->date = $date;
        $this->time = $time;
        $this->room = $room;
    }

    public function build()
    {
        return $this->subject('Details of the PFE Supervised - ' . $this->projectName)
                    ->view('emails.pfe_professor_details');
    }
}
