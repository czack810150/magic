<?php

namespace App\Listeners;

use App\Events\ExamSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Mail\ExamSubmittedMail;
use App\Authorization;
class ExamSubmittedListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }
    public function handle(ExamSubmitted $event)
    {
        $group = Authorization::group(['admin','dm','hr']);
        Mail::to($event->exam->employee)->cc($group)->send(new ExamSubmittedMail($event->exam));
    }
}
