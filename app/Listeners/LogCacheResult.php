<?php

namespace App\Listeners;

use App\Events\FailedToClearCloudflareCache;
use App\Events\SuccessfullyClearedCloudflareCache;
use Illuminate\Support\Facades\Log;

class LogCacheResult
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (config('services.cloudflare.logging', true) === false) {
            return;
        }

        switch (get_class($event)) {
            case SuccessfullyClearedCloudflareCache::class:
                $this->handleSuccess($event);
                break;
            case FailedToClearCloudflareCache::class:
                $this->handleFailure($event);
                break;
        }
    }

    /**
     * Create a log entry for successfully clearing the cache.
     *
     * @param SuccessfullyClearedCloudflareCache $event
     */
    private function handleSuccess(SuccessfullyClearedCloudflareCache $event): void
    {
        Log::channel('cloudflare-cache')->info('SUCCESSFULLY CLEARED CACHE FOR ZONE: ' . $event->zoneId . '. Response: ' . json_encode($event->responseBody));
    }

    /**
     * Create a log entry for failing to clear the cache.
     *
     * @param FailedToClearCloudflareCache $event
     */
    private function handleFailure(FailedToClearCloudflareCache $event): void
    {
        Log::channel('cloudflare-cache')->info('FAILED TO CLEAR CACHE FOR ZONE: ' . $event->zoneId . '. Response: ' . json_encode($event->responseBody));
    }
}
