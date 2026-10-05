<?php

namespace App\Mail;

use App\Models\StudentAttendance;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentAbsenceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $attendance;

    public function __construct(StudentAttendance $attendance)
    {
        $this->attendance = $attendance;
    }

    public function build()
    {
        return $this
            ->subject(
                'Student Absence Notification - ' .
                    $this->attendance->student->user->name
            )
            ->view('emails.student-absence');
    }
}
