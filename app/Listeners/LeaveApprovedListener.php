<?php

namespace App\Listeners;

use App\Events\LeaveApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\LeaveApprovedMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;

class LeaveApprovedListener implements ShouldQueue
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
     * @param  LeaveApproved  $event
     * @return void
     */
    public function handle(LeaveApproved $event)
    {
        $group = Authorization::group(['admin','hr','dm']);
        $manager = $event->leave->employee->location->manager;
        $group->push($manager);
        Mail::to($event->leave->employee)->cc($group)->send(new LeaveApprovedMail($event->leave));
    }
}
