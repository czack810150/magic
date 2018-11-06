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

class EmployeeTerminated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $employee;
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
