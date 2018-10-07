<?php

namespace App\Listeners;

use App\Events\EmailConfirmed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\EmailConfirmedMail;
class EmailConfirmedListener implements ShouldQueue
{
 
    public function __construct()
    {
        //
    }

    public function handle(EmailConfirmed $event)
    {
        Mail::to($event->user)->send(new EmailConfirmedMail($event->user));
    }
}
