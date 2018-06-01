<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PersonalShiftsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $shifts,$start,$end,$employee,$location;
    public function __construct($shifts,$start,$end,$employee,$location)
    {
        $this->shifts = $shifts;
        $this->start = $start;
        $this->end = $end;
        $this->employee = $employee;
        $this->location = $location;
    }

    public function build()
    {
        return $this->subject('我的排班 My Shifts')->markdown('email.shifts.personal');
    }
}
