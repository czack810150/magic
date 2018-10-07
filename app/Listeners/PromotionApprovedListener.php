<?php

namespace App\Listeners;

use App\Events\PromotionApproved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\PromotionApprovedMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;

class PromotionApprovedListener implements ShouldQueue
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
     * @param  PromotionApproved  $event
     * @return void
     */
    public function handle(PromotionApproved $event)
    {
        $staffs = Authorization::group(['hr','dm','gm','admin']);
        $manager = $event->promotion->employee->location->manager;
        Mail::to($event->promotion->employee)->cc($staffs)->send(new PromotionApprovedMail($event->promotion));
        if(!empty($manager->email)){
            Mail::to($manager)->send(new PromotionApprovedMail($event->promotion));
        }
        
    }
}
