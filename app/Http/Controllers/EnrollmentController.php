<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortField = $request->input('sort', 'id'); // default sort column
        $sortDirection = $request->input('direction', 'asc'); // default sort direction

        $enrollments = Enrollment::query()
            ->when($search, function ($query, $search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%")
                    ->orWhere('subject_code', 'like', "%{$search}%")
                    ->orWhere('year_sem', 'like', "%{$search}%")
                    ->orWhere('grade', 'like', "%{$search}%");
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends([
                'search' => $search,
                'sort' => $sortField,
                'direction' => $sortDirection,
            ]);

        return view('enrollments.index', compact('enrollments', 'sortField', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('enrollments.add'); // create a Blade view for add enrollment
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_code' => 'required|string|max:255',
            'year_sem' => 'required|string|max:255',
            'grade' => 'nullable|string|max:5',
        ]);

        // Check for duplicate enrollment
        $exists = \App\Models\Enrollment::where('student_id', $validated['student_id'])
            ->where('subject_code', $validated['subject_code'])
            ->where('year_sem', $validated['year_sem'])
            ->exists();

        if ($exists) {
            // Add a validation error for student_id specifically
            return redirect()->back()
                ->withInput()
                ->withErrors(['student_id' => 'This student is already enrolled in this subject for the selected year/semester.']);
        }

        Enrollment::create($validated);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment added successfully!');
    }

    public function batchCreate()
    {
        return view('enrollments.batch-create'); // Blade view for CSV upload
    }

    public function batchStore(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file, 'r');
        $header = fgetcsv($handle);

        $requiredHeader = ['student_id', 'subject_code', 'year_sem', 'grade'];

        if ($header !== $requiredHeader) {
            return back()->with('error', 'CSV header format is invalid.');
        }

        $validRecords = [];
        $invalidRecords = [];

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);

            $validator = Validator::make($data, [
                'student_id' => 'required|exists:students,student_id',
                'subject_code' => 'required|string|max:255',
                'year_sem' => 'required|string|max:255',
                'grade' => 'nullable|string|max:5',
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

        foreach ($validRecords as $record) {
            Enrollment::create($record);
        }

        if (count($invalidRecords) === 0) {
            return redirect()->route('enrollments.index')
                ->with('success', count($validRecords) . ' enrollments successfully imported!');
        }

        return back()->with([
            'invalidRecords' => $invalidRecords,
            'success' => count($validRecords) . ' valid enrollments were imported!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        return view('enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        return view('enrollments.edit', compact('enrollment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'subject_code' => 'required|string|max:255',
            'year_sem' => 'required|string|max:255',
            'grade' => 'nullable|string|max:5',
        ]);

        $enrollment->update($validated);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (!$ids) {
            return back()->with('error', 'No enrollments selected.');
        }

        Enrollment::whereIn('id', $ids)->delete();

        return back()->with('success', 'Selected enrollments deleted successfully.');
    }
}
