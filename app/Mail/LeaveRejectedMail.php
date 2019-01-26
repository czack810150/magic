<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Leave;

class LeaveRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $leave;
    public function __construct(Leave $leave)
    {
        $this->leave = $leave;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('员工休假拒否通知')->from('DoNotReply@mail.magicnoodleteam.com')->markdown('email.leave.denied');
    }
}
