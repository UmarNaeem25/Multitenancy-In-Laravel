<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\ProvisionTenantJob;
use App\Models\Landlord\OnboardingSession;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Str;

class OnboardingController extends Controller
{
    public function step1(Request $request)
    {
        return inertia('Onboarding/Step1');
    }
    
    
    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique((new OnboardingSession)->getTable(), 'data->account->email')
            ],
        ]);
        
        $sessionId = $request->session()->getId();
        
        $session = OnboardingSession::updateOrCreate(
            ['session_id' => $sessionId], 
            [
                'token' => (string) Str::uuid(),
                'data' => [
                    'account' => [
                        'name'  => $validated['name'],
                        'email' => $validated['email'],
                    ],
                ],
                'current_step' => 2,
                'name'  => $validated['name'],
                'email' => $validated['email'],
                ]
            );
            
            $request->session()->put('onboarding_token', $session->token);
            
            return redirect()->route('onboarding.step2');
        }
        
        
        public function step2(Request $request)
        {
            return inertia('Onboarding/Step2');
        }
        
        public function storeStep2(Request $request)
        {
            $token = $request->session()->get('onboarding_token');
            $session = OnboardingSession::where('token', $token)->firstOrFail();
            
            $validated = $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            
            $data = $session->data;
            $data['account']['password_hash'] = Hash::make($validated['password']);
            
            $session->update([
                'data' => $data,
                'current_step' => 3,
            ]);
            
            return Inertia::location(route('onboarding.step3'));
        }
        
        public function step3(Request $request)
        {
            return inertia('Onboarding/Step3');
        }
        
        public function storeStep3(Request $request)
        {
            $token = $request->session()->get('onboarding_token');
            $session = OnboardingSession::where('token', $token)->firstOrFail();
            
            $validated = $request->validate([
                'company_name' => ['required', 'string', 'max:255'],
                'subdomain'    => [
                    'required', 'string', 'max:50',
                    'regex:/^[a-z0-9]+(-[a-z0-9]+)*$/',
                    function ($attr, $value, $fail) {
                        $reserved = ['www', 'admin', 'landlord', 'api'];
                        if (in_array($value, $reserved, true)) {
                            $fail('This subdomain is reserved.');
                        }
                    },
                ],
                'industry'     => ['nullable', 'string', 'max:120'],
                'company_size' => ['nullable', 'string', 'max:120'],
            ]);
            
            $sub = strtolower(trim($validated['subdomain']));
            
            if (Tenant::query()->where('domain', "{$sub}.myapp.test")->exists()) {
                return back()->withErrors(['subdomain' => 'This subdomain is already taken.']);
            }
            
            $existsSession = OnboardingSession::query()
            ->where('token', '!=', $session->token)
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.company.subdomain')) = ?", [$sub])
            ->exists();
            
            if ($existsSession) {
                return back()->withErrors(['subdomain' => 'This subdomain is already reserved in another onboarding session.']);
            }
            
            $data = $session->data ?? [];
            $data['company'] = [
                'company_name' => $validated['company_name'],
                'subdomain'    => $sub,
                'industry'     => $validated['industry'] ?? null,
                'company_size' => $validated['company_size'] ?? null,
            ];
            
            $session->update([
                'data' => $data,
                'current_step' => 4,
            ]);
            
            return Inertia::location(route('onboarding.step4'));
        }
        
        public function step4(Request $request)
        {
            return inertia('Onboarding/Step4');
        }
        
        public function storeStep4(Request $request)
        {
            $token = $request->session()->get('onboarding_token');
            $session = OnboardingSession::where('token', $token)->firstOrFail();
            
            $validated = $request->validate([
                'billing_name' => ['required', 'string', 'max:255'],
                'address'      => ['required', 'string', 'max:500'],
                'country'      => ['required', 'string', 'max:30'],
                'phone'        => ['required', 'string', 'max:30', 'regex:/^\+?[0-9\-\s]{7,20}$/'],
            ]);
            
            $data = $session->data ?? [];
            $data['billing'] = $validated;
            
            $session->update([
                'data' => $data,
                'current_step' => 5,
            ]);
            
            return Inertia::location(route('onboarding.step5'));
        }
        
        public function step5(Request $request)
        {
            $token = $request->session()->get('onboarding_token');
            $session = OnboardingSession::where('token', $token)->firstOrFail();
            
            $snapshot = $session->data ?? [];
            
            if (isset($snapshot['account']['password_hash'])) {
                unset($snapshot['account']['password_hash']);
            }
            
            return inertia('Onboarding/Step5', [
                'snapshot' => $snapshot,
            ]);
        }
        
        public function storeStep5(Request $request)
        {
            $token = $request->session()->get('onboarding_token');
            $session = OnboardingSession::where('token', $token)->firstOrFail();
            
            $data = $session->data ?? [];
            foreach (['account', 'company', 'billing'] as $k) {
                if (empty($data[$k])) {
                    return back()->withErrors(['general' => 'Missing required onboarding data.']);
                }
            }
            
            ProvisionTenantJob::dispatch($session->session_id)->onQueue('provisioning');
            
            $request->session()->forget('onboarding_token');
            
            $subdomain = $session->data['company']['subdomain'];
         
            return redirect()->away("http://{$subdomain}.myapp.test");
        }
        
        
        public function provisioning()
        {
            return inertia('Onboarding/Provisioning');
        }
    }
    