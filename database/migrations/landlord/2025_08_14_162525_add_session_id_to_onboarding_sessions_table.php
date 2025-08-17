<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('landlord')->table('onboarding_sessions', function (Blueprint $table) {
            $table->text('session_id')->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::connection('landlord')->table('onboarding_sessions', function (Blueprint $table) {
            $table->dropColumn('session_id');
        });
    }
};
