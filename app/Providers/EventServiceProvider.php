<?php

namespace App\Providers;

use App\Events\FailedToClearCloudflareCache;
use App\Events\SuccessfullyClearedCloudflareCache;
use App\Listeners\LogCacheResult;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        SuccessfullyClearedCloudflareCache::class => [
            LogCacheResult::class,
        ],
        FailedToClearCloudflareCache::class => [
            LogCacheResult::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
