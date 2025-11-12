<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // backend validation on incoming data before saving in the db
        $validated = $request->validate([
            'student_id' => 'required|string|max:255|unique:students,student_id',
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email|max:255|unique:students,email',
            'course_program' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
        ]);

        // add the validated data into the database
        // will only work if model has $fillable defined for the fields
        Student::create($validated);

        // redirect to student.index
        return redirect()->route('students.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        // validate the request values before saving changes
        $validated = $request->validate([
            'student_id' => 'required|string|max:255|unique:students,student_id,' .$student->id,
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email|max:255|unique:students,email,' .$student->id,
            'course_program' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
        ]);

        // update the validated data into the database
        $student->update($validated);

        // redirect to student.index
        return redirect()->route('students.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        // delete the stored id
        $student->delete();

        // redirect to student.index
        return redirect()->route('students.index');
    }
}
