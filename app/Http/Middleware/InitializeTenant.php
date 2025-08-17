<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;

class InitializeTenant
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost(); 

        $tenant = Tenant::where('domain', $host)->first();

        if (!$tenant) {
            return redirect()->away('http://myapp.test');
        }

        $tenant->makeCurrent();
        $request->attributes->set('tenant', $tenant);

        return $next($request);
    }
}
