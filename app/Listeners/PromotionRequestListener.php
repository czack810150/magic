<?php

namespace App\Listeners;

use App\Events\PromotionRequested;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use App\Mail\PromotionRequestedMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;
// use Nexmo\Laravel\Facade\Nexmo;


class PromotionRequestListener implements ShouldQueue
{
   
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  PromotionRequested  $event
     * @return void
     */
    public function handle(PromotionRequested $event)
    {
        $staffs = Authorization::group(['hr','dm','gm','admin']);
        $manager = $event->promotion->employee->location->manager;
        Mail::to($event->promotion->employee)->cc($staffs)->send(new PromotionRequestedMail($event->promotion));
        Mail::to($manager)->send(new PromotionRequestedMail($event->promotion));
        // Nexmo::message()->send([
        //     'to'   => '14168348612',
        //     'from' => '12266023048',
        //     'text' => $event->promotion->employee->name.'申请晋级.',
        //     'type' => 'unicode',
        // ]);
    }
}
