<?php

namespace App\Models;

use Resend\Resend;

class GradesSummaryMail extends Mailable
{
    public function __construct(
        public $student,
        public $yearSem,
        public $enrollments,
        public $average
    ) {}

    public function send($mailer)
    {
        $resend = Resend::client(config('services.resend.key'));

        $resend->emails->send([
            'from' => config('mail.from.address'),
            'to' => [$this->student->email],
            'subject' => "Grade Summary - {$this->yearSem}",
            'html' => view('emails.grades-summary', [
                'student' => $this->student,
                'yearSem' => $this->yearSem,
                'enrollments' => $this->enrollments,
                'average' => $this->average,
            ])->render(),
        ]);
    }
}
