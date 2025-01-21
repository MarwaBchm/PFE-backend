<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of all students.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Eager load the user relationship to avoid N+1 query problem
        $students = Student::with('user')->get();
        return response()->json($students);
    }

    /**
     * Display the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::with('user')->find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json($student);
    }

    /**
     * Update the specified student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'firstname' => 'sometimes|required|string|max:255',
            'lastname' => 'sometimes|required|string|max:255',
            'option_id' => 'sometimes|required|exists:options,id',
            'groupe_id' => 'sometimes|required|exists:groupes,id',
            'master_average' => 'sometimes|nullable|numeric',
            'ranking' => 'sometimes|nullable|integer',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update the student's information
        $student->update($request->only(['firstname', 'lastname', 'option_id', 'groupe_id', 'master_average', 'ranking']));

        // Update the associated user's email if provided
        if ($request->has('user_id')) {
            $user = User::find($student->user_id);
            if ($user) {
                $user->email = $request->email ?? $user->email;
                $user->save();
            }
        }

        return response()->json(['message' => 'Student updated successfully', 'student' => $student]);
    }

    /**
     * Remove the specified student from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        // Delete the associated user
        $user = User::find($student->user_id);
        if ($user) {
            $user->delete();
        }

        // Delete the student
        $student->delete();

        return response()->json(['message' => 'Student deleted successfully']);
    }
}
