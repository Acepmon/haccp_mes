<?php

namespace App\Events;

use App\ProcDtl;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProcDtlCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $procDtl;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ProcDtl $procDtl)
    {
        $this->procDtl = $procDtl;
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
