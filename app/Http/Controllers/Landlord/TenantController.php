<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Tenant;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all(); 
        return Inertia::render('TenantIndex', compact('tenants'));
    }

    public function show(Tenant $tenant)
    {
        return Inertia::render('TenantShow', compact('tenant'));
    }
}
