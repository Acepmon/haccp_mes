<?php

namespace App\Listeners;

use App\Events\CcpLimitDnExceeded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        //
    }
}
