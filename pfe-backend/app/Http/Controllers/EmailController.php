<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\GradMasteryPassword; // This is the Mailable for password email
use App\Mail\PFEProposalEmail;  // This is the Mailable for proposal email
use App\Mail\PFEProposalReminderEmail; 
use App\Mail\PFEEncadrementAssignmentEmail;
use App\Mail\PFEProposalSupervisionEmail;
use App\Mail\PFEProjectNotSelectedEmail;
use App\Mail\PFEProjectNeedsUpdateEmail;
use App\Mail\PFEProjectRejectedEmail;
use App\Mail\GLPFEChoiceEmail;
use App\Mail\PFECJuryCompositionEmail;
use App\Mail\PFEStudentDetailsEmail;
use App\Mail\PFEProfessorDetailsEmail;
use App\Mail\PFEEnterpriseDetailsEmail;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{
    public function sendPasswordEmail()
    {
        // Example data
        $users = [
            ['type' => 'Student', 'email' => 'meribentoumi@gmail.com'],
            ['type' => 'Professor', 'email' => 'bentoumimeriem21@gmail.com'],
            ['type' => 'Enterprise', 'email' => 'benmeriem784@gmail.com'],
        ];

        foreach ($users as $user) {
            $password = Str::random(8); // Generate a unique random password
            $dateTime = now()->format('Y-m-d H:i:s'); // Current date and time

            // Send email
            Mail::to($user['email'])->send(new GradMasteryPassword($user['type'], $password, $dateTime));
        }

        return 'Password emails sent successfully!';
    }

public function sendPFEProposalEmail()
    {
        // Example data for sending the PFE proposal email
        $users = [
            ['type' => 'Student', 'email' => 'meribentoumi@gmail.com'],
            ['type' => 'Professor', 'email' => 'bentoumimeriem21@gmail.com'],
            ['type' => 'Enterprise', 'email' => 'benmeriem784@gmail.com'],
        ];

        // Message content for the proposal email
        

        foreach ($users as $user) {
            // Send the PFE proposal email to the user
            Mail::to($user['email'])->send(new PFEProposalEmail($user['type']));
        }

        return 'PFE Proposal emails sent successfully!';
    }
    public function sendPFEProposalReminderEmail()
{
    // Example array of users
    $users = [
        ['type' => 'Student', 'email' => 'meribentoumi@gmail.com'],
        ['type' => 'Professor', 'email' => 'bentoumimeriem21@gmail.com'],
        ['type' => 'Enterprise', 'email' => 'benmeriem784@gmail.com'],
    ];


    foreach ($users as $user) {
        // Send the reminder email to each user
        Mail::to($user['email'])->send(new PFEProposalReminderEmail($user['type']));
    }

    return "PFE proposal reminder emails sent successfully!";
}
public function sendSupervisionEmails()
{
    $users = [
        ['email' => 'bentoumimeriem21@gmail.com', 'userType' => 'Professor'],
        // Add more professors and students as needed
    ];

    foreach ($users as $user) {
        // Send the supervision email to each user
        Mail::to($user['email'])->send(new PFEProposalSupervisionEmail($user['userType']));
    }

    return "Supervision invitation emails sent successfully!";
}

public function sendEncadrementAssignmentEmail()
{
    $studentName = 'Ahmed and Naltis';
    $supervisorName = 'Professor Mohammed';
    $projectTitle = 'GrandMastery';

    // Send the email to the students
    Mail::to('meribentoumi@gmail.com')->send(new PFEEncadrementAssignmentEmail($studentName, $supervisorName, $projectTitle));
    Mail::to('benmeriem784@gmail.com')->send(new PFEEncadrementAssignmentEmail($studentName, $supervisorName, $projectTitle));

    return "Encadrement assignment emails sent successfully!";
}
public function sendPFEProjectNotSelectedEmail()
{
    $studentName = 'Merieme and Naltis';
    $projectTitle = 'Project1';
    $reason = 'Reason for Non-Selection';

    // Send the email to the students
    Mail::to('meribentoumi@gmail.com')->send(new PFEProjectNotSelectedEmail($studentName, $projectTitle, $reason));
    Mail::to('benmeriem784@gmail.com')->send(new PFEProjectNotSelectedEmail($studentName, $projectTitle, $reason));

    return "PFE Project Not Selected emails sent successfully!";
}
public function sendPFEProjectNeedsUpdateEmail()
{
    $studentName = 'Merieme and Naltis';
    $projectTitle = 'Project2';

    // Send the email to the students
    Mail::to('meribentoumi@gmail.com')->send(new PFEProjectNeedsUpdateEmail($studentName, $projectTitle));
    Mail::to('benmeriem784@gmail.com')->send(new PFEProjectNeedsUpdateEmail($studentName, $projectTitle));

    return "PFE Project Needs Update emails sent successfully!";
}
public function sendPFEProjectRejectedEmail()
{
    $studentName = 'Merieme and Naltis';
    $projectTitle = 'Project3';

    // Send the rejection email to the students
    Mail::to('meribentoumi@gmail.com')->send(new PFEProjectRejectedEmail($studentName, $projectTitle));
    Mail::to('benmeriem784@gmail.com')->send(new PFEProjectRejectedEmail($studentName, $projectTitle));

    return "PFE Project Rejected emails sent successfully!";
}
public function sendGLPFEChoiceEmail()
{
    // Example data
    $studentName = 'Étudiant 1';
    $availablePFEs = [
        'PFE 1 : Développement d\'une application mobile',
        'PFE 2 : Développement d\'un logiciel de gestion',
    ];

    // Send the email to the student
    Mail::to('meribentoumi@gmail.com')->send(new GLPFEChoiceEmail($studentName, $availablePFEs));

    return 'PFE choice email sent successfully!';
}
public function sendJuryCompositionEmail()
{
    $users = [
        [
            'email' => 'meribentoumi@gmail.com',
            'studentName' => 'Étudiant 1',
            'projectTitle' => 'PFE Web Development',
            'juryComposition' => [
                'president' => 'Prof. B',
                'examiner' => 'Dr. C',
                'supervisor' => 'Dr. A',
            ],
        ],
        // Add other users as needed
    ];

    foreach ($users as $user) {
        Mail::to($user['email'])->send(new PFECJuryCompositionEmail(
            $user['studentName'], 
            $user['projectTitle'], 
            $user['juryComposition']
        ));
    }

    return 'PFE Jury Composition emails sent successfully!';
}
public function sendPFEEmails()
    {
        $students = [
            [
                'email' => 'meribentoumi@gmail.com',
                'name' => 'Étudiant 1',
                'projectName' => 'PFE 1',
                'date' => '2024-12-15',
                'time' => '10:00',
                'room' => 'Salle A',
            ],
            // Add more students as needed
        ];

        $professors = [
            [
                'email' => 'bentoumimeriem21@gmail.com',
                'name' => 'Enseignant 1',
                'projectName' => 'PFE 1',
                'date' => '2024-12-15',
                'time' => '10:00',
                'room' => 'Salle A',
            ],
            // Add more professors as needed
        ];

        $enterprises = [
            [
                'email' => 'benmeriem784@gmail.com',
                'name' => 'Entreprise 1',
                'projectName' => 'PFE 1',
                'date' => '2024-12-15',
                'time' => '10:00',
                'room' => 'Salle A',
            ],
            // Add more enterprises as needed
        ];

        foreach ($students as $student) {
            Mail::to($student['email'])->send(new PFEStudentDetailsEmail(
                $student['name'], $student['projectName'], $student['date'], $student['time'], $student['room']
            ));
        }

        foreach ($professors as $professor) {
            Mail::to($professor['email'])->send(new PFEProfessorDetailsEmail(
                $professor['name'], $professor['projectName'], $professor['date'], $professor['time'], $professor['room']
            ));
        }

        foreach ($enterprises as $enterprise) {
            Mail::to($enterprise['email'])->send(new PFEEnterpriseDetailsEmail(
                $enterprise['name'], $enterprise['projectName'], $enterprise['date'], $enterprise['time'], $enterprise['room']
            ));
        }

        return 'PFE details emails sent successfully!';
    }

}