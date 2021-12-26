<?php

namespace App\Providers;

use App\Models\Tenant;
use Illuminate\Pagination\Paginator;
use Laravel\Cashier\Cashier;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Cashier::useCustomerModel(Tenant::class);
        Paginator::useBootstrap();
    }
}
