<?php

namespace App\Mail;

use App\Models\CourseMaterial;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCourseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $course;

    public function __construct(CourseMaterial $course)
    {
        $this->course = $course;
    }

    public function build()
    {
        return $this
            ->subject('New Course Material: ' . $this->course->title)
            ->view('emails.new-course');
    }

    public function attachments(): array
    {
        return [];
    }
}
