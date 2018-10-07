<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeReviewVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $review;
    public function __construct($review)
    {
        $this->review = $review;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('员工考核被批准 Employee Review Verified')->from('DoNotReply@mail.magicnoodleteam.com')->markdown('email.employee.reviewVerified');
    }
}
