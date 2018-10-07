<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeePendingReviewMail extends Mailable
{
    use Queueable, SerializesModels;
    public $pendings;

    public function __construct($pendings)
    {
        $this->pendings = $pendings;
    }

    public function build()
    {
        return $this->subject('员工考核提醒')->from('DoNotReply@mail.magicnoodleteam.com')->markdown('email.employee.pendingReview');
    }
}
