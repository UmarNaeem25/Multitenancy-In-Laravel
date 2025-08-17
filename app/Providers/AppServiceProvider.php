<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
    * Register any application services.
    */
    public function register(): void
    {
        //
    }
    
    /**
    * Bootstrap any application services.
    */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        
        if ($tenant = Tenant::current()) {
            URL::forceRootUrl(request()->getSchemeAndHttpHost());
        }
    }
}
