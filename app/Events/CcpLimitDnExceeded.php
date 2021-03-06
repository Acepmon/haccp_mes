<?php

namespace App\Events;

use App\CcpEscData;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CcpLimitDnExceeded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ccpEscData;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CcpEscData $ccpEscData)
    {
        $this->ccpEscData = $ccpEscData;
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
