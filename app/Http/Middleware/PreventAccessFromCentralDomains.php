<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Tenant;

class PreventAccessFromCentralDomains
{
    public function handle(Request $request, Closure $next)
    {
        $centralDomains = config('multitenancy.central_domains', []);

        if (in_array($request->getHost(), $centralDomains)) {
            abort(404); 
        }

        return $next($request);
    }
}
