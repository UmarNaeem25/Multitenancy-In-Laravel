<?php
namespace App\Multitenancy;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class DomainTenantFinder extends TenantFinder
{
    public function findForRequest(Request $request): ?IsTenant
    {
        $host = $request->getHost();
        
        return Tenant::on(config('multitenancy.landlord_database_connection_name'))
                     ->where('domain', $host)
                     ->first();
    }
}
