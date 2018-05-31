<?php

namespace App\Listeners;

use App\Events\ShiftsPublished;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\ShiftsPublishedMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;
use Illuminate\Support\Facades\Auth;

class ShiftsPublishedListener implements shouldQueue
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
    public function handle(ShiftsPublished $event)
    {
        $staffs = Authorization::group(['hr','dm','gm','admin']);
        Mail::to(Auth::user()->authorization->employee)
        ->cc($staffs)
        ->send(new ShiftsPublishedMail($event->start,$event->end,$event->count));
    }
}
