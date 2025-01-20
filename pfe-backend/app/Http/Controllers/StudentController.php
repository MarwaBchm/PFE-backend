<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Display a listing of the students
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    // Show the form for creating a new student
    public function create()
    {
        return view('students.create');
    }

    // Store a newly created student in the database
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'option_id' => 'required|exists:options,id',
            'groupe_id' => 'required|exists:groupes,id',
            'master_average' => 'nullable|numeric',
            'ranking' => 'nullable|integer',
            'user_id' => 'required|exists:users,id',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')
                         ->with('success', 'Student created successfully.');
    }

    // Display the specified student
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
    }

    // Show the form for editing the specified student
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    // Update the specified student in the database
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'option_id' => 'required|exists:options,id',
            'groupe_id' => 'required|exists:groupes,id',
            'master_average' => 'nullable|numeric',
            'ranking' => 'nullable|integer',
            'user_id' => 'required|exists:users,id',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')
                         ->with('success', 'Student updated successfully.');
    }

    // Remove the specified student from the database
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
                         ->with('success', 'Student deleted successfully.');
    }
}
