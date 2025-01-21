<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Log;

class GroupeController extends Controller
{
    /**
     * Check if a student is part of a groupe and return the groupe details.
     *
     * @param int $studentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkGroupe($studentId)
    {
        // Find the groupe where the student is either student_1 or student_2
        $groupe = Groupe::where('id_student_1', $studentId)
                        ->orWhere('id_student_2', $studentId)
                        ->first();

        if (!$groupe) {
            return response()->json([
                'message' => 'Student is not part of any groupe.',
            ], 404);
        }

        return response()->json([
            'message' => 'Groupe found.',
            'groupe' => $groupe,
        ]);
    }

    /**
     * Update the invitation state of a groupe.
     *
     * @param Request $request
     * @param int $groupeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateInvitation(Request $request, $groupeId)
{
    $request->validate([
        'student_id' => 'required|integer', // The student making the request
        'action' => 'required|in:accept,decline', // The action (accept or decline)
    ]);

    $groupe = Groupe::find($groupeId);

    if (!$groupe) {
        return response()->json([
            'message' => 'Groupe not found.',
        ], 404);
    }

    // Check if the student is student_2
    if ($groupe->id_student_2 != $request->student_id) {
        return response()->json([
            'message' => 'Only student_2 can update the invitation state.',
        ], 403);
    }

    // Update the invitation state based on the action
    if ($request->action === 'accept') {
        $groupe->invitation_state = 'accepted';
        $groupe->save();

        return response()->json([
            'message' => 'Invitation accepted.',
            'groupe' => $groupe,
        ]);
    } elseif ($request->action === 'decline') {
        $groupe->invitation_state = 'refused';
        $groupe->id_student_2 = 0; // Set student_2 to 0

        // Recalculate the groupe master average based on student_1 alone
        $student1 = Student::find($groupe->id_student_1);
        if ($student1) {
            $groupe->groupe_master_average = $student1->master_average;
        } else {
            $groupe->groupe_master_average = 0; // Fallback if student_1 is not found
        }

        $groupe->save();

        return response()->json([
            'message' => 'Invitation declined.',
            'groupe' => $groupe,
        ]);
    }
}
    /**
     * Create a new groupe with student_1 and student_2.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createGroupe(Request $request)
    {
        $request->validate([
            'student_1_id' => 'required|integer', // The student creating the groupe
            'student_2_id' => 'required|integer', // The classmate to invite
        ]);
log::info($request->student_1_id);
log::info($request->student_2_id);


        // Check if student_2 is already in a groupe
        $existingGroupeForStudent2 = Groupe::where('id_student_1', $request->student_2_id)
                                           ->orWhere('id_student_2', $request->student_2_id)
                                           ->first();

        if ($existingGroupeForStudent2) {log::info('errrr here');
            return response()->json([
                'message' => 'Student_2 is already part of a groupe.',
            ], 400);
        }
Log::info("ot here");
        // Fetch the master_average of student_1 and student_2
        $student1 = Student::find($request->student_1_id);
        $student2 = Student::find($request->student_2_id);
Log::info("mohahaha");

        if (!$student1 || !$student2) {
            return response()->json([
                'message' => 'One or both students not found.',
            ], 404);
        }
        Log::info("aree wee here?");

        // Calculate the groupe master average
        $groupeMasterAverage = ($student1->master_average + $student2->master_average) / 2;
        Log::info("may bee here's the issue ?");

        // Create the groupe
        $groupe = Groupe::create([
            'id_student_1' => $request->student_1_id,
            'id_student_2' => $request->student_2_id,
            'invitation_state' => 'pending', // Set invitation state to pending
            'groupe_master_average' => $groupeMasterAverage, // Store the calculated average
        ]);

        return response()->json([
            'message' => 'Groupe created successfully.',
            'groupe' => $groupe,
        ], 201);
    }
}
