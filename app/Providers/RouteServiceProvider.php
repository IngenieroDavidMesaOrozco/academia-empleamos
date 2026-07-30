<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    public function boot(): void
    {
        $this->routes(function () {

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

        });

        Carbon::setLocale('es');
        setlocale(LC_TIME, 'es_CO.UTF-8');
    }
}