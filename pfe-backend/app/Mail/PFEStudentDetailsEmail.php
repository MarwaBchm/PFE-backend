<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PFEStudentDetailsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $studentName;
    public $projectName;
    public $date;
    public $time;
    public $room;

    public function __construct($studentName, $projectName, $date, $time, $room)
    {
        $this->studentName = $studentName;
        $this->projectName = $projectName;
        $this->date = $date;
        $this->time = $time;
        $this->room = $room;
    }

    public function build()
    {
        return $this->subject('Details of your PFE - ' . $this->projectName)
                    ->view('emails.pfe_student_details');
    }
}
