<?php

namespace App\Listeners;

use App\Events\EmployeeAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\EmployeeWelcomeMail;
use Mail;

class EmployeeWelcomeListener implements ShouldQueue
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
     * @param  EmployeeAdded  $event
     * @return void
     */
    public function handle(EmployeeAdded $event)
    {
        Mail::to($event->employee)->send(new EmployeeWelcomeMail($event->employee,$event->token));
    }
}
