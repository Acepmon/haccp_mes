<?php

namespace App\Events;

use App\ItemMst;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemMstUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $itemMst;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ItemMst $itemMst)
    {
        $this->itemMst = $itemMst;
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
