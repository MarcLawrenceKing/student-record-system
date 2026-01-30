<?php

namespace App\Mail;

use App\Models\SummaryEmail; // <-- make sure this is imported
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentGradesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $summaryEmail;

    /**
     * Create a new message instance.
     */
    public function __construct(SummaryEmail $summaryEmail)
    {
        $this->summaryEmail = $summaryEmail;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Grades Summary')
                    ->view('emails.grades-summary')
                    ->with([
                        'student' => $this->summaryEmail->student,
                        'enrollments' => $this->summaryEmail->student->enrollments,
                        'year_sem' => $this->summaryEmail->year_sem,
                    ]);
    }
}
