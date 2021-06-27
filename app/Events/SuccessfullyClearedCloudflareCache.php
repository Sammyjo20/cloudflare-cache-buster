<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SuccessfullyClearedCloudflareCache
{
    use Dispatchable, SerializesModels;

    /**
     * @var string
     */
    public string $zoneId;

    /**
     * @var array
     */
    public array $responseBody;

    /**
     * Create a new event instance.
     *
     * @param string $zoneId
     * @param array $responseBody
     */
    public function __construct(string $zoneId, array $responseBody = [])
    {
        $this->zoneId = $zoneId;
        $this->responseBody = $responseBody;
    }
}
