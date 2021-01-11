<?php

namespace App\Events;

use App\CcpLimit;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CcpLimitUpExceeded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ccpLimit;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CcpLimit $ccpLimit)
    {
        $this->ccpLimit = $ccpLimit;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
