<?php

namespace App\Listeners;

use App\Events\EmployeePendingReview;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\EmployeePendingReviewMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;

class EmployeePendingReviewListener implements ShouldQueue
{
    
    public function __construct()
    {
        //
    }
    public function handle(EmployeePendingReview $event)
    {
        $group = Authorization::group(['admin','hr','dm']);
        Mail::to($group)->send(new EmployeePendingReviewMail($event->employees));
    }
}
