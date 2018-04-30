<?php

namespace App\Listeners;

use App\Events\LeaveRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use App\Mail\LeaveRequestedMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;



class LeaveRequestedListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(LeaveRequested $event)
    {
        $employees = Authorization::group(['admin','dm','hr']);
        $manager = $event->leave->location->manager;
        Mail::to($event->leave->employee)->cc($employees)
            ->send(new LeaveRequestedMail($event->leave));
        Mail::to($manager)->send(new LeaveRequestedMail($event->leave));

    }
}
