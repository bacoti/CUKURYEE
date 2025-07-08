<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// TAMBAHKAN 3 BARIS INI
use Illuminate\Support\Facades\Gate;
use App\Models\Service;
use App\Policies\ServicePolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // DAFTARKAN POLICY ANDA DI SINI
        Gate::policy(Service::class, ServicePolicy::class);
    }
}
