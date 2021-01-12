<?php

namespace App\Providers;

use App\Events\CcpLimitDnExceeded;
use App\Events\CcpLimitUpExceeded;
use App\Events\UserPasswordUpdated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\SendCcpLimitUpNotification;
use App\Listeners\SendNewUserInfoToAdmin;
use App\Listeners\SendUserInfoToOwner;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserPasswordUpdated::class => [
            SendNewUserInfoToAdmin::class,
            SendUserInfoToOwner::class,
        ],
        Login::class => [
            LogSuccessfulLogin::class,
        ],
        CcpLimitUpExceeded::class => [
            SendCcpLimitUpNotification::class
        ],
        CcpLimitDnExceeded::class => [
            SendCcpLimitDnNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
