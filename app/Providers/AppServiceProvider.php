<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Rujukan;
use App\Observers\RujukanObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Dihapus dari sini karena sudah dipindah ke bootstrap/app.php
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Rujukan::observe(RujukanObserver::class);
    }
}