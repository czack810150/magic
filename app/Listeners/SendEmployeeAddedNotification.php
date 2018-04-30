<?php
namespace App\Listeners;

use App\Events\EmployeeAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use App\Mail\EmployeeAddedMail;
use Illuminate\Support\Facades\Mail;


class SendEmployeeAddedNotification
{
  

    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  EmployeeAdded  $event
     * @return void
     */
    public function handle(EmployeeAdded $event)
    {
       
        Mail::to('suhiro@gmail.com')
            ->cc(['haga.gu@magicnoodle.ca','hiro.su@magicnoodle.ca'])
            ->send(new EmployeeAddedMail($event->employee));
    }
}
