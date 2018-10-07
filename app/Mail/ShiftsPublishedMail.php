<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;


class ShiftsPublishedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $start,$end,$count;
    public $manager;
    public function __construct($start,$end,$count)
    {
        $this->start = $start;
        $this->end = $end;
        $this->count = $count;
        $this->manager = Auth::user()->authorization->employee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.shifts.published');
    }
}
