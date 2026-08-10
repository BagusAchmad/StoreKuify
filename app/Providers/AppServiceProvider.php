<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Product;

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
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Scoped View Composer for partials.header (stock notifications)
        View::composer('partials.header', function ($view) {
            if (Auth::check()) {
                $lowStockProducts = Product::with('category')
                    ->where('is_active', true)
                    ->where('stock', '<=', 5)
                    ->orderByRaw('CASE WHEN stock = 0 THEN 0 ELSE 1 END, stock ASC')
                    ->get();

                $view->with('globalLowStockProducts', $lowStockProducts);
            }
        });
    }
}
