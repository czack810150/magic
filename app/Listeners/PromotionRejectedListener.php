<?php

namespace App\Listeners;

use App\Events\PromotionRejected;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\PromotionRejectedMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;

class PromotionRejectedListener implements ShouldQueue
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
     * @param  PromotionRejected  $event
     * @return void
     */
    public function handle(PromotionRejected $event)
    {
        $staffs = Authorization::group(['hr','dm','gm','admin']);
        $manager = $event->promotion->employee->location->manager;
        Mail::to($event->promotion->employee)->cc($staffs)->send(new PromotionRejectedMail($event->promotion));
        if(!empty($manager->email)){
            Mail::to($manager)->send(new PromotionRejectedMail($event->promotion));
        }
    }
}
