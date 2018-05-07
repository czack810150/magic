<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Exam;
class ExamSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $exam;
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }
    public function build()
    {
        return $this->markdown('email.exam.submitted')->subject('晋级考试提交提醒');
    }
}
