<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilleController;
use App\Http\Controllers\Tenant\RoleController;
use App\Http\Controllers\Tenant\SubscriptionController;
use App\Http\Controllers\Tenant\TenantController;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Cashier;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        $prices = Cashier::stripe()->prices->all();
        foreach ($prices as $key => $value) {
            echo $value;
        }
    });

    Route::get('/_post_tenant_registration/{token}', [TenantController::class, 'postTenantRegistration'])->name('_post_tenant_registration');
    Route::get('/auth/google/callback/{code}', [TenantController::class, 'loginGoogle'])->name('login.google');
    
    Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function(){
        Route::group(['middleware' => ['subscribed']], function(){
            Route::get('/', [TenantController::class, 'dashboard'])->name('dashboard');
        });
        Route::group(['prefix' => 'subscriptions'], function(){
            Route::get('/', [SubscriptionController::class, 'index'])->name('subscriptions.index');
            Route::get('/checkout', [SubscriptionController::class, 'checkout'])->name('subscriptions.checkout');
            Route::post('/store', [SubscriptionController::class, 'store'])->name('subscriptions.store');
            Route::get('/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
            Route::get('/resume', [SubscriptionController::class, 'resume'])->name('subscriptions.resume');
        });
        Route::resource('/roles', RoleController::class);
        Route::resource('/settings', TenantController::class);
        Route::put('/settings', [TenantController::class, 'updateTenant'])->name('settings.updateTenant');
        Route::post('/settings/billing-address/{id?}', [TenantController::class, 'billingAddress'])->name('settings.billingAddress');
        Route::get('/profile/google/revoke', [ProfileController::class, 'revoke'])->name('google.revoke');
        Route::get('/profile/google/link', [ProfileController::class, 'link'])->name('google.link');
    });
});


Route::middleware([
    'web',
    'universal',
    InitializeTenancyByDomain::class,
])->group(function () {
    Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function(){
    Route::resource('/profile', ProfileController::class);
    });
    require __DIR__.'/auth.php';
});
