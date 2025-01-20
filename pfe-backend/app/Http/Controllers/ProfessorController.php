<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfessorController extends Controller
{
    /**
     * Display a listing of all professors.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Eager load the user relationship to avoid N+1 query problem
        $professors = Professor::with('user')->get();
        return response()->json($professors);
    }

    /**
     * Display the specified professor.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $professor = Professor::with('user')->find($id);

        if (!$professor) {
            return response()->json(['message' => 'Professor not found'], 404);
        }

        return response()->json($professor);
    }

    /**
     * Update the specified professor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $professor = Professor::find($id);

        if (!$professor) {
            return response()->json(['message' => 'Professor not found'], 404);
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'firstname' => 'sometimes|required|string|max:255',
            'lastname' => 'sometimes|required|string|max:255',
            'grade' => 'sometimes|required|in:' . implode(',', Professor::$grades),
            'recruitment_date' => 'sometimes|required|date',
            'email' => 'sometimes|required|email|unique:users,email,' . $professor->user_id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update the professor's information
        $professor->update($request->only(['firstname', 'lastname', 'grade', 'recruitment_date']));

        // Update the associated user's email if provided
        if ($request->has('email')) {
            $user = User::find($professor->user_id);
            $user->email = $request->email;
            $user->save();
        }

        return response()->json(['message' => 'Professor updated successfully', 'professor' => $professor]);
    }

    /**
     * Remove the specified professor from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $professor = Professor::find($id);

        if (!$professor) {
            return response()->json(['message' => 'Professor not found'], 404);
        }

        // Delete the associated user
        $user = User::find($professor->user_id);
        if ($user) {
            $user->delete();
        }

        // Delete the professor
        $professor->delete();

        return response()->json(['message' => 'Professor deleted successfully']);
    }
}
