<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Leave;

class LeaveApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $leave;
    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
    }

    public function build()
    {
        return $this->subject('大槐树员工休假通知')->from('DoNotReply@mail.magicnoodleteam.com')->markdown('email.leave.approved');
    }
}
