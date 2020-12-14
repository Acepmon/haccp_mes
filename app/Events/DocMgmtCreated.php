<?php

namespace App\Events;

use App\DocMgmt;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocMgmtCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $docMgmt;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DocMgmt $docMgmt)
    {
        $this->docMgmt = $docMgmt;
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
