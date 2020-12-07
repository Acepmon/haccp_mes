<?php

namespace App\Events;

use App\HaccpMstFile;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HaccpMstFileCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $haccpMstFile;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(HaccpMstFile $haccpMstFile)
    {
        $this->haccpMstFile = $haccpMstFile;
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
