<?php

declare(strict_types=1);

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

    Route::get('_post_tenant_registration/{token}', [TenantController::class, 'postTenantRegistration'])->name('_post_tenant_registration');
    
    Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function(){
        Route::group(['middleware' => ['subscribed']], function(){
            Route::get('/', [TenantController::class, 'index'])->name('dashboard');
        });
        Route::get('subscriptions', [SubscriptionController::class, 'account'])->name('subscriptions.index');
        Route::get('subscriptions/checkout', [SubscriptionController::class, 'index'])->name('subscriptions.checkout');
        Route::post('subscriptions/store', [SubscriptionController::class, 'store'])->name('subscriptions.store');
        Route::get('subscriptions/premium', [SubscriptionController::class, 'premium'])->name('subscriptions.premium')->middleware(['subscribed']);
        Route::get('subscriptions/invoice/{invoice}', [SubscriptionController::class, 'downloadInvoice'])->name('subscriptions.invoice.download');
        Route::get('subscriptions/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
        Route::get('subscriptions/resume', [SubscriptionController::class, 'resume'])->name('subscriptions.resume');
    });
});


Route::middleware([
    'web',
    'universal',
    InitializeTenancyByDomain::class,
])->group(function () {
    require __DIR__.'/auth.php';
});
