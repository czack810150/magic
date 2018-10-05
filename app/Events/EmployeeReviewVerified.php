<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\EmployeeReview;

class EmployeeReviewVerified
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $review;
    public function __construct(EmployeeReview $review)
    {
        $this->review = $review;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
