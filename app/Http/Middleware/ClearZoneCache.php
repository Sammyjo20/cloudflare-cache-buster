<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ClearZoneCache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authQueryParam = trim($request->query('auth', null));

        if ($authQueryParam !== config('services.cloudflare.middleware_auth')) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
