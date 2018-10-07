<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Employee;

class EmployeeToBeTerminated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $employee;
    public function __construct(Employee $e)
    {
        $this->employee = $e;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
