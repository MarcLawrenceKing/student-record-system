<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortField = $request->input('sort', 'student_id'); // default sort column
        $sortDirection = $request->input('direction', 'asc'); // default sort direction

        $students = Student::query()
            ->when($search, function ($query, $search) {
                $query->where('student_id', 'like', "%{$search}%")
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('course_program', 'like', "%{$search}%")
                    ->orWhere('year_level', 'like', "%{$search}%");
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends([
                'search' => $search,
                'sort' => $sortField,
                'direction' => $sortDirection,
            ]);

        return view('students.index', compact('students', 'sortField', 'sortDirection'));
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
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('students', 's3');
        }

        // add the validated data into the database
        // will only work if model has $fillable defined for the fields
        Student::create($validated);

        // redirect to student.index
        return redirect()->route('students.index')->with('success', 'Student added successfully!');
    }

    public function batchCreate()
    {
        return view('students.batch-create');
    }

    public function batchStore(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file, 'r');

        $header = fgetcsv($handle); // read header row

        $requiredHeader = ['student_id', 'full_name', 'date_of_birth', 'gender', 'email', 'course_program', 'year_level'];

        // Check if header matches exactly
        if ($header !== $requiredHeader) {
            return back()->with('error', 'CSV header format is invalid.');
        }

        $validRecords = [];
        $invalidRecords = [];

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            /* ----------------------------------------
            * 1) NORMALIZE DATE BEFORE VALIDATION
            * ---------------------------------------- */
            $date = trim($data['date_of_birth']);

            $formats = [
                'Y-m-d',   // original CSV
                'Y/m/d',   // Excel sometimes converts to this
                'm/d/Y',   // Excel US locale
                'd/m/Y',   // Excel PH locale
            ];

            $parsed = null;

            foreach ($formats as $format) {
                try {
                    $parsed = \Carbon\Carbon::createFromFormat($format, $date);
                    break;
                } catch (\Exception $e) {
                    // continue trying next format
                }
            }

            // If date can't be parsed
            if (!$parsed) {
                $invalidRecords[] = [
                    'data' => $data,
                    'errors' => ["Invalid date format: '{$data['date_of_birth']}' — use YYYY-MM-DD"],
                ];
                continue;
            }

            // Convert to valid SQL format
            $data['date_of_birth'] = $parsed->format('Y-m-d');

            // Validate each row manually
            $validator = Validator::make($data, [
                'student_id' => 'required|string|max:255|unique:students,student_id',
                'full_name' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:Male,Female,Other',
                'email' => 'required|email|max:255|unique:students,email',
                'course_program' => 'required|string|max:255',
                'year_level' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                $invalidRecords[] = [
                    'data' => $data,
                    'errors' => $validator->errors()->all(),
                ];
            } else {
                $validRecords[] = $data;
            }
        }

        fclose($handle);

        // Insert valid rows
        foreach ($validRecords as $record) {
            Student::create($record);
        }

        // If everything was valid
        if (count($invalidRecords) === 0) {
            return redirect()->route('students.index')
                ->with('success', count($validRecords) . ' students successfully imported!');
        }

        // If some rows were invalid, send them back
        return back()->with([
            'invalidRecords' => $invalidRecords,
            'success' => count($validRecords) . ' valid records were imported!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return view('students.show', compact('student'));
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
            'image' => 'nullable|image|max:2048',  // optional
        ]);

        if ($request->hasFile('image')) {
            // delete old image if exists
            if ($student->image) {
                Storage::disk('s3')->delete($student->image); 
            }

            $validated['image'] = $request->file('image')->store('students', 's3');
        }

        // update the validated data into the database
        $student->update($validated);

        // redirect to student.index
        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (!$ids) {
            return back()->with('error', 'No students selected.');
        }

        // Get the students that will be deleted
        $students = Student::whereIn('id', $ids)->get();

        foreach ($students as $student) {
            // Delete image from S3 if it exists
            if ($student->image) {
                Storage::disk('s3')->delete($student->image);
            }
        }

        // Delete the student records
        Student::whereIn('id', $ids)->delete();

        return back()->with('success', 'Selected students deleted successfully.');
    }
}
