<?php

namespace App\Events;

use App\ProcDtlSub;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProcDtlSubUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $procDtlSub;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProcDtlSub $procDtlSub)
    {
        $this->procDtlSub = $procDtlSub;
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
