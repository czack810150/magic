<?php

namespace App\Listeners;

use App\Events\ExamCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ExamCreatedMail;
use App\Authorization;


class ExamCreatedListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(ExamCreated $event)
    {
       $group = Authorization::group(['admin','hr','dm']);
       Mail::to($event->exam->employee)->cc($group)->send(new ExamCreatedMail($event->exam));
    }
}
