<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeReviewSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $review;
    public function __construct($review)
    {
        $this->review = $review;
    }

    public function build()
    {
        return $this->subject('员工考核提交 Employee Review Submitted')->from('DoNotReply@mail.magicnoodleteam.com')->markdown('email.employee.reviewSubmitted');
    }
}
