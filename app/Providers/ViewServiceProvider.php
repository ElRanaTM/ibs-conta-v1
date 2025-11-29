<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Compartir datos del usuario autenticado con todas las vistas
        View::composer('*', function ($view) {
            $view->with('currentUser', Auth::user());
            $view->with('userRole', Auth::check() ? Auth::user()->getRoleName() : null);
        });
    }
}



