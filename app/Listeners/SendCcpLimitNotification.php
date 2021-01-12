<?php

namespace App\Listeners;

use App\Events\CcpLimitDnExceeded;
use App\Mail\CcpLimitReached;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCcpLimitNotification
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
     * @param  CcpLimitDnExceeded  $event
     * @return void
     */
    public function handle(CcpLimitDnExceeded $event)
    {
        Mail::to(env('ADMIN_EMAIL'))
                ->queue(new CcpLimitReached($event->ccpLimit));
    }
}
