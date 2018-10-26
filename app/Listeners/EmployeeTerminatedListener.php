<?php

namespace App\Listeners;

use App\Events\EmployeeTerminated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\EmployeeTerminatedMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;

class EmployeeTerminatedListener implements ShouldQueue
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
     * @param  EmployeeTerminated  $event
     * @return void
     */
    public function handle(EmployeeTerminated $event)
    {
        $group = Authorization::group(['admin','hr','dm']);
        Mail::to($event->employee->location->manager)->cc($group)->send(new EmployeeTerminatedMail($event->employee));
    }
}
