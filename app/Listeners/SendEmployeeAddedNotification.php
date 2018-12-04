<?php
namespace App\Listeners;

use App\Events\EmployeeAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Mail\Mailer;
use App\Mail\EmployeeAddedMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;


class SendEmployeeAddedNotification implements ShouldQueue
{
  

    public function __construct()
    {
        
    }

    public function handle(EmployeeAdded $event)
    {
        $staffs = Authorization::group(['hr','dm','gm','admin']);
        Mail::to($event->employee->location->manager)
            ->cc($staffs)
            ->send(new EmployeeAddedMail($event->employee));
    }
}
