<?php

namespace App\Listeners;

use App\Events\EmployeeToBeTerminated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\EmployeeToBeTerminatedMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;

class EmployeeToBeTerminatedListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(EmployeeToBeTerminated $event)
    {
        $group = Authorization::group(['admin','hr','dm']);
        Mail::to($group)->send(new EmployeeToBeTerminatedMail($event->employee));
    }
}
