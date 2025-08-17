<?php

namespace App\Jobs;

use App\Models\Landlord\OnboardingSession;
use App\Models\Tenant; 
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Multitenancy\Jobs\NotTenantAware;

class ProvisionTenantJob implements ShouldQueue, NotTenantAware
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $sessionId;

    public function __construct(string $sessionId)
    {
        $this->onQueue('provisioning');
        $this->sessionId = $sessionId;
    }

    public function handle(): void
    {
        Log::info("ProvisionTenantJob started for session: {$this->sessionId}");

        $session = OnboardingSession::on('landlord')->where('session_id', $this->sessionId)->first();

        if (!$session) {
            Log::error("OnboardingSession not found for session_id: {$this->sessionId}");
            return;
        }

        $data = $session->data;
        $subdomain = $data['company']['subdomain'] ?? null;

        if (!$subdomain) {
            Log::error("No subdomain found in session data: " . json_encode($data));
            return;
        }

        $domain = "{$subdomain}.myapp.test";
        $dbName = substr('tenant_' . Str::slug($subdomain, '_'), 0, 64);

        Log::info("Provisioning tenant DB: {$dbName}");

        $tenant = Tenant::on('landlord')->updateOrCreate(
            ['database' => $dbName],
            [
                'name'   => $data['company']['company_name'] ?? 'Unknown',
                'domain' => $domain,
                'status' => 'completed',
            ]
        );

        try {
            DB::statement("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            Log::info("Database check done: {$dbName}");
        } catch (\Throwable $e) {
            Log::warning("Skipping database creation, might already exist: " . $e->getMessage());
        }

     
        Config::set('database.connections.tenant.database', $dbName);
        DB::purge('tenant');
        DB::reconnect('tenant');
        Log::info("Connected to tenant DB: " . DB::connection('tenant')->getDatabaseName());

        
        try {
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path'     => 'database/migrations/tenant',
                '--force'    => true,
            ]);
            Log::info("Migrations completed for tenant DB: {$dbName}");
        } catch (\Throwable $e) {
            Log::error("Migration failed for tenant DB {$dbName}: " . $e->getMessage());
            return;
        }

        $tenant->update(['status' => 'active']);
        Log::info("Tenant {$tenant->id} marked as active.");
    }
}
