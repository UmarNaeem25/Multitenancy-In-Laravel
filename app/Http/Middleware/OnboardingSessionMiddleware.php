<?php

namespace App\Http\Middleware;

use App\Models\Landlord\OnboardingSession;
use Closure;
use Illuminate\Http\Request;

class OnboardingSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
       
        if ($request->routeIs('onboarding.step1', 'onboarding.storeStep1')) {
            return $next($request);
        }

        $token = $request->session()->get('onboarding_token');

        if (!$token) {
            return redirect()->route('onboarding.step1');
        }
       
        $session = OnboardingSession::where('token', $token)->first();
        
        if (!$session) {
            return redirect()->route('onboarding.step1');
        }
    
                
        $stepMap = [
            'onboarding.step2' => 1,
            'onboarding.step3' => 2,
            'onboarding.step4' => 3,
            'onboarding.step5' => 4,
        ];

        $requiredStep = $stepMap[$request->route()->getName()] ?? null;
        
        if ($requiredStep && $session->current_step < $requiredStep) {
            return redirect()->route('onboarding.step' . ($session->current_step + 1));
        }

    
        $request->attributes->set('onboardingSession', $session);

        return $next($request);
    }
}
