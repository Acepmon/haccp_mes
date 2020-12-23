<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPasswordUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $password;
    public $introMessage;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $password, $introMessage = 'Your password has been updated!')
    {
        $this->user = $user;
        $this->password = $password;
        $this->introMessage = $introMessage;
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
