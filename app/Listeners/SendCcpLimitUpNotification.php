<?php

namespace App\Listeners;

use App\Events\CcpLimitUpExceeded;
use App\Mail\CcpLimitReached;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCcpLimitUpNotification
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
     * @param  CcpLimitUpExceeded  $event
     * @return void
     */
    public function handle(CcpLimitUpExceeded $event)
    {
        Mail::to(env('ADMIN_EMAIL'))
                ->queue(new CcpLimitReached($event->ccpLimit));
    }
}
