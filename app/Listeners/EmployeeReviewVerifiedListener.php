<?php

namespace App\Listeners;

use App\Events\EmployeeReviewVerified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\EmployeeReviewVerifiedMail;
use Illuminate\Support\Facades\Mail;
use App\Authorization;

class EmployeeReviewVerifiedListener implements ShouldQueue
{
    
    public function __construct()
    {
        //
    }

   
    public function handle(EmployeeReviewVerified $event)
    {
        $group = Authorization::group(['admin','hr','dm']);
        $email = $event->review->employee->email;
        if($email){
            Mail::to($email)->cc($group)->send(new EmployeeReviewVerifiedMail($event->review));
        } else {
            Mail::to($group)->send(new EmployeeReviewVerifiedMail($event->review));
        }
        
    }
}
