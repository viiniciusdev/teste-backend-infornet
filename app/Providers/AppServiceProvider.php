<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Carrega as rotas de API
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        // Carrega as rotas web
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
