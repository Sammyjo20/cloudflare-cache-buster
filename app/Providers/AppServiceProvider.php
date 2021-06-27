<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @throws \Exception
     */
    public function boot()
    {
        if (! config('services.cloudflare.middleware_auth', null)) {
            throw new \Exception('You must specify a CLOUDFLARE_MIDDLEWARE_AUTH token. This should be a randomly generated string.');
        }
    }
}
