<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TrialEmployeeReviewMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employees;
    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('试用期员工完成提醒 Trial Employees has finished')->from('DoNotReply@magicnoodleteam.com')->markdown('email.employee.trialReview');
    }
}
