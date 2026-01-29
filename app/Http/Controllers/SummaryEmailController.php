<?php

namespace App\Http\Controllers;

use App\Models\SummaryEmail;
use App\Models\Enrollment;
use App\Mail\GradesSummaryMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class SummaryEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortField = $request->input('sort', 'id'); // default sort column
        $sortDirection = $request->input('direction', 'asc'); // default sort direction

        $summary_emails = SummaryEmail::query()
            ->when($search, function ($query, $search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%")
                    ->orWhere('year_sem', 'like', "%{$search}%")
                    ->orWhere('subject_code', 'like', "%{$search}%")
                    ->orWhere('subject_count', 'like', "%{$search}%")
                    ->orWhere('subject_with_grades', 'like', "%{$search}%")
                    ->orWhere('average_grades', 'like', "%{$search}%")
                    ->orWhere('sent', 'like', "%{$search}%");
            })
            ->orderBy($sortField, $sortDirection)
            ->paginate(10)
            ->appends([
                'search' => $search,
                'sort' => $sortField,
                'direction' => $sortDirection,
            ]);

        return view('summary_emails.index', compact('summary_emails', 'sortField', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    public function batchCreate()
    {
    }

    public function batchStore(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function bulkDelete(Request $request)
    {

    }

    public function bulkSend(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $summaryEmails = SummaryEmail::with('student')
            ->whereIn('id', $request->ids)
            ->where('subject_with_grades', 5)
            ->where('sent', false)
            ->get();

        foreach ($summaryEmails as $summary) {

            $student = $summary->student;

            // fetch enrollments with grades
            $enrollments = Enrollment::with('subject')
                ->where('student_id', $student->id)
                ->where('year_sem', $summary->year_sem)
                ->whereNotNull('grade')
                ->get();

            if ($enrollments->count() !== 5) {
                continue; // safety check
            }

            Mail::to($student->email)->send(
                new GradesSummaryMail(
                    student: $student,
                    yearSem: $summary->year_sem,
                    enrollments: $enrollments,
                    average: $summary->average_grades
                )
            );

            $summary->update(['sent' => true]);
        }

        return redirect()
            ->route('summary_emails.index')
            ->with('success', 'Emails sent successfully.');
    }
}
