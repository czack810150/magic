<?php

namespace App\Listeners;

use App\Events\LeaveRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use App\Mail\LeaveRequestedMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;
// use Nexmo\Laravel\Facade\Nexmo;



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
       
    //     Nexmo::message()->send([
    // 'to'   => '14168348612',
    // 'from' => '12266023048',
    // 'text' => $event->leave->employee->location->name.'\'s '.$event->leave->employee->cName.' has requested a '.$event->leave->type->cName. ' leave.',
    // 'type' => 'unicode',
    // ]);





// {{$leave->from->toFormattedDateString()}}      | {{$leave->to->toFormattedDateString()}}      | {{$leave->comment?$leave->comment:'No comment'}} 



    }
}
