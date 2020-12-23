<?php

namespace App\Listeners;

use App\Events\UserPasswordUpdated;
use App\Mail\NewUserInfo;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewUserInfoToAdmin
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
        if (false) {
            Mail::to(env('ADMIN_EMAIL'))
                ->queue(new NewUserInfo($event->user, $event->password, 'New user just registered'));
        }
    }
}
