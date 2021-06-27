<?php

namespace App\Http\Controllers;

use App\Actions\ClearCloudflareCache;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;

class ClearCacheController extends Controller
{
    /**
     * Clear the Cloudflare zone.
     *
     * @param Request $request
     * @param string $zoneId
     * @param ClearCloudflareCache $clearCloudflareCacheAction
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\CloudflareApiError
     * @throws \App\Exceptions\CloudflareAuthenticationException
     */
    public function clearZone(Request $request, string $zoneId, ClearCloudflareCache $clearCloudflareCacheAction)
    {
        $clearCloudflareCacheAction
            ->onQueue()
            ->execute($zoneId);

        return response()->json([
            'status' => 'accepted',
            'message' => 'Attempting to clear the Cloudflare cache.',
            'inspiration' => Inspiring::quote(),
        ], 202);
    }
}
