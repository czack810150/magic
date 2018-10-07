<?php

namespace App\Listeners;

use App\Events\LeaveRejected;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\LeaveRejectedMail;
use Illuminate\Support\Facades\Mail;

class LeaveRejectedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LeaveRejected  $event
     * @return void
     */
    public function handle(LeaveRejected $event)
    {
        Mail::to($event->leave->employee)->send(new LeaveRejectedMail($event->leave));
    }
}
