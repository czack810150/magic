<?php

namespace App\Listeners;

use App\Events\EmployeeReviewSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\EmployeeReviewSubmittedMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;

class EmployeeReviewSubmittedListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }
    public function handle(EmployeeReviewSubmitted $event)
    {
        $group = Authorization::group(['admin','hr','dm']);
        Mail::to('suhiro@gmail.com')->send(new EmployeeReviewSubmittedMail($event->review));
    }
}
