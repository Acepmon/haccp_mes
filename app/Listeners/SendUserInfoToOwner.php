<?php

namespace App\Listeners;

use App\Events\UserPasswordUpdated;
use App\Mail\NewUserInfo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendUserInfoToOwner implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserPasswordUpdated  $event
     * @return void
     */
    public function handle(UserPasswordUpdated $event)
    {
        Mail::to($event->user->EMAIL)
            ->send(new NewUserInfo($event->user, $event->password, $event->introMessage));
    }
}
