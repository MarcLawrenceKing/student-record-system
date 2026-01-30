<?php

namespace App\Http\Controllers;

use App\Models\SummaryEmail;
use App\Models\Enrollment;
use App\Mail\StudentGradesMail;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

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
    public function show(SummaryEmail $summary_email)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SummaryEmail $summary_email)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SummaryEmail $summary_email)
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
            'ids' => 'required|array'
        ]);

        // Get the selected summary emails
        $summaryEmails = SummaryEmail::with('student', 'student.enrollments')
            ->whereIn('id', $request->ids)
            ->get();

        if ($summaryEmails->isEmpty()) {
            return back()->with('error', 'No summary emails selected.');
        }

        // Pre-check: ensure all subjects have at least 5 grades
        foreach ($summaryEmails as $summaryEmail) {
            if ($summaryEmail->subject_with_grades < 5) {
                return back()->with('error', "Student {$summaryEmail->student->full_name} has insufficient subjects with grades.");
            }
        }

        $failedEmails = [];

        foreach ($summaryEmails as $summaryEmail) {
            try {
                Mail::to($summaryEmail->student->email)->send(
                    new StudentGradesMail($summaryEmail)
                );

                // Mark as sent only if mail succeeds
                $summaryEmail->sent = true;
                $summaryEmail->save();
            } catch (\Exception $e) {
                $failedEmails[] = [
                    'student' => $summaryEmail->student->full_name ?? $summaryEmail->student->email,
                    'reason' => $e->getMessage(),
                ];
            }
        }

        if (empty($failedEmails)) {
            return back()->with('success', 'All emails sent successfully!');
        }

        $message = count($failedEmails) . ' email(s) failed to send: ';
        foreach ($failedEmails as $fail) {
            $message .= "{$fail['student']} ({$fail['reason']}); ";
        }

        return back()->with('error', $message);
    }


}
