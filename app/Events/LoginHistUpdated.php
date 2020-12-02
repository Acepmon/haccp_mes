<?php

namespace App\Events;

use App\LoginHist;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoginHistUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $loginHist;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LoginHist $loginHist)
    {
        $this->loginHist = $loginHist;
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
