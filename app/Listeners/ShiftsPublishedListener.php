<?php

namespace App\Listeners;

use App\Events\ShiftsPublished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\ShiftsPublishedMail;
use App\Mail\PersonalShiftsMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ShiftsPublishedNotification;
use App\Shift;

class ShiftsPublishedListener implements shouldQueue
{
    public function __construct()
    {
        //
    }
    public function handle(ShiftsPublished $event)
    {
        $staffs = Authorization::group(['hr','dm','gm','admin']);

        Notification::send($staffs, new ShiftsPublishedNotification());
        // $user = \App\User::first();
        // $user->notify(new ShiftsPublishedNotification());

        Mail::to(Auth::user()->authorization->employee)
        ->cc($staffs)
        ->send(new ShiftsPublishedMail($event->start,$event->end,$event->count));

        
        // $employees = Shift::storeShifts($event->location->id,$event->start,$event->end);
        // foreach($employees as $e){
        //     try {
        //         Mail::to($e)->send(new PersonalShiftsMail($e->shifts,$event->start,$event->end,$e,$event->location));
        //     }
        //     catch (Exception $e) {

        //     }
        // }
       
        

    }
}
