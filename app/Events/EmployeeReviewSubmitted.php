<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


class EmployeeReviewSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $review;
    public function __construct($review)
    {
        $this->review = $review;
    }
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
