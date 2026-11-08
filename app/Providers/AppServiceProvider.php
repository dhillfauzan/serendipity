<?php

namespace App\Providers;

use Illuminate\Support\Facades\View; // Tambahkan ini
use Illuminate\Support\ServiceProvider;
use App\Models\Order; // Jangan lupa import model Order


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
    public function boot()
    {
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

        View::composer('*', function ($view) {
            $pendingOrdersCount = Order::where('payment_status', 'pending_verification')->count();
            $view->with('pendingOrdersCount', $pendingOrdersCount);
        });
    }
}
