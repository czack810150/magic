<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\JobPromotion;

class PromotionRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $promotion;

    public function __construct(JobPromotion $promotion)
    {
        $this->promotion = $promotion;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
