<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Exam;

class ExamCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $exam;
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }
    public function build()
    {
        return $this->markdown('email.exam.created')->subject('晋级考试 Exam for Promotion');
    }
}
