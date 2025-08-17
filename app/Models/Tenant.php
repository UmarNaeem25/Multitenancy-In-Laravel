<?php

namespace App\Models;

use Spatie\Multitenancy\Models\Tenant as BaseTenant;
use Spatie\Multitenancy\Contracts\IsTenant;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Tenant extends BaseTenant implements IsTenant
{
    use UsesTenantConnection; 

    protected $connection = 'landlord';

    protected $table = 'tenants';

    protected $fillable = [
        'name',
        'domain',
        'database',
        'status',
    ];
}
