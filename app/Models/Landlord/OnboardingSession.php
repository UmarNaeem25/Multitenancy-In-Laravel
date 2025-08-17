<?php

namespace App\Models\Landlord;

use Illuminate\Database\Eloquent\Model;

class OnboardingSession extends Model
{
    protected $connection = 'landlord';

    protected $table = 'onboarding_sessions';

    protected $fillable = [
        'name',
        'email',
        'session_id',
        'current_step',
        'data',
        'token',
    ];

    protected $casts = [
        'data' => 'array',
    ];
}
