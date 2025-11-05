<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Route::prefix('api/v_1/')
            ->middleware('api')
            ->name('api.v1.')
            ->group(base_path('routes/includes/Api/v_1/app.php'));
    }
}
