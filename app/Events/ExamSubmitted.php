<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Exam;
class ExamSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $exam;
    public function __construct(Exam $exam)
    {
        $this->exam = $exam;
    }
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
