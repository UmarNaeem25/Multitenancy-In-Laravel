<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\Landlord\TenantController;

Route::domain('myapp.test')->group(function () {
    
    Route::get('/', fn () => inertia('Welcome'))->name('welcome');

   
    Route::get('/onboarding/step1', [OnboardingController::class, 'step1'])->name('onboarding.step1');
    Route::post('/onboarding/step1', [OnboardingController::class, 'storeStep1'])->name('onboarding.storeStep1');


    Route::middleware('onboarding.session')->group(function () {
        Route::get('/onboarding/step2', [OnboardingController::class, 'step2'])->name('onboarding.step2');
        Route::post('/onboarding/step2', [OnboardingController::class, 'storeStep2'])->name('onboarding.storeStep2');

        Route::get('/onboarding/step3', [OnboardingController::class, 'step3'])->name('onboarding.step3');
        Route::post('/onboarding/step3', [OnboardingController::class, 'storeStep3'])->name('onboarding.storeStep3');

        Route::get('/onboarding/step4', [OnboardingController::class, 'step4'])->name('onboarding.step4');
        Route::post('/onboarding/step4', [OnboardingController::class, 'storeStep4'])->name('onboarding.storeStep4');

        Route::get('/onboarding/step5', [OnboardingController::class, 'step5'])->name('onboarding.step5');
        Route::post('/onboarding/step5', [OnboardingController::class, 'storeStep5'])->name('onboarding.storeStep5');
        Route::get('/onboarding/provisioning', [OnboardingController::class, 'provisioning'])->name('onboarding.provisioning');
    });
});


Route::domain('landlord.myapp.test')->group(function () {
    Route::get('/', [TenantController::class, 'index'])->name('landlord.dashboard');
    Route::get('/tenants', [TenantController::class, 'index'])->name('landlord.tenants.index');
    Route::get('/tenants/{tenant}', [TenantController::class, 'show'])->name('landlord.tenants.show');
});

Route::domain('{tenant}.myapp.test')
    ->middleware(['web', 'tenant']) 
    ->group(function () {
        Route::get('/', function ($tenant) {
            
            $tenant->makeCurrent(); 
            return inertia('Tenant/Welcome', [
                'tenant' => $tenant
            ]);
        })->name('tenant.dashboard');
    });

