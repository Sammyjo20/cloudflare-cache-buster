<?php

namespace App\Actions;

use App\Events\FailedToClearCloudflareCache;
use App\Events\SuccessfullyClearedCloudflareCache;
use App\Exceptions\CloudflareApiError;
use App\Exceptions\CloudflareAuthenticationException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Spatie\QueueableAction\QueueableAction;

class ClearCloudflareCache
{
    use QueueableAction;

    /**
     * Attempt to fully clear the cache for a given site (zone).
     *
     * @param string $zoneId
     * @throws CloudflareApiError
     * @throws CloudflareAuthenticationException
     */
    public function execute(string $zoneId): void
    {
        $apiToken = config('services.cloudflare.token', null);

        if (! $apiToken) {
            throw new CloudflareAuthenticationException('API Token is missing. Pleases provide token in the "CLOUDFLARE_TOKEN" env variable.');
        }

        $requestUrl = 'https://api.cloudflare.com/client/v4/zones/' . $zoneId . '/purge_cache';

        $response = Http::withToken($apiToken)->asJson()->post($requestUrl, [
            'purge_everything' => true,
        ]);

        // Handle the response.

        if (! $response->ok()) {
            $this->handleFailure($zoneId, $response);
        }

        $this->handleSuccess($zoneId, $response);
    }

    /**
     * Handle a successful request.
     *
     * @param string $zoneId
     * @param Response $response
     */
    private function handleSuccess(string $zoneId, Response $response): void
    {
        event(new SuccessfullyClearedCloudflareCache($zoneId, $response->json()));
    }

    /**
     * Handle the API error.
     *
     * @param string $zoneId
     * @param Response $response
     * @throws CloudflareApiError
     */
    private function handleFailure(string $zoneId, Response $response): void
    {
        $body = $response->json();
        $errors = $body['errors'] ?? [];

        event(new FailedToClearCloudflareCache($zoneId, $body));

        throw new CloudflareApiError('Could not clear Cloudflare cache. Errors: ' . json_encode($errors));
    }
}
