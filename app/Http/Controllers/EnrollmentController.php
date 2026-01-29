<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\SummaryEmail;
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

        // Update grades_email
        $this->updateGradesEmail($validated['student_id'], $validated['year_sem']);

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

            // Pad the row with nulls if it's shorter than the header
            $row = array_pad($row, count($header), null);

            $data = array_combine($header, $row);

            $validator = Validator::make($data, [
                'student_id' => 'required|exists:students,id',
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

        $affectedCombos = [];

        foreach ($validRecords as $record) {
            Enrollment::create($record);

            // Track affected student/year_sem
            $key = $record['student_id'].'-'.$record['year_sem'];
            $affectedCombos[$key] = ['student_id' => $record['student_id'], 'year_sem' => $record['year_sem']];
        }

        // Update grades_email for all affected combos
        foreach ($affectedCombos as $combo) {
            $this->updateGradesEmail($combo['student_id'], $combo['year_sem']);
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
    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'subject_code' => 'required|string|max:255',
            'year_sem' => 'required|string|max:255',
            'grade' => 'nullable|string|max:5',
        ]);

        $enrollment->update($validated);

        // Update grades_email
        $oldYearSem = $enrollment->year_sem;

        $enrollment->update($validated);

        // Update old summary
        $this->updateGradesEmail($enrollment->student_id, $oldYearSem);

        // Update new summary
        $this->updateGradesEmail($enrollment->student_id, $validated['year_sem']);

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

        $affectedCombos = Enrollment::whereIn('id', $ids)
            ->get(['student_id', 'year_sem'])
            ->unique(function ($item) {
                return $item->student_id.'-'.$item->year_sem;
            });

        Enrollment::whereIn('id', $ids)->delete();

        // Update grades_email for all affected combos
        foreach ($affectedCombos as $combo) {
            $this->updateGradesEmail($combo->student_id, $combo->year_sem);
        }

        return back()->with('success', 'Selected enrollments deleted successfully.');
    }

    // Helper to update grades_email
    private function updateGradesEmail($student_id, $year_sem)
    {
        $enrollments = Enrollment::where('student_id', $student_id)
            ->where('year_sem', $year_sem)
            ->get();

        $subject_count = $enrollments->count();
        $subject_with_grades = $enrollments->whereNotNull('grade')->count();
        $average_grades = $subject_with_grades > 0 
            ? $enrollments->whereNotNull('grade')->avg('grade') 
            : 0;

        SummaryEmail::updateOrCreate(
            ['student_id' => $student_id, 'year_sem' => $year_sem],
            [
                'subject_count' => $subject_count,
                'subject_with_grades' => $subject_with_grades,
                'average_grades' => $average_grades,
                'sent' => false
            ]
        );
    }

}
