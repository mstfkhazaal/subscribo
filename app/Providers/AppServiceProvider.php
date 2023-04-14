<?php

namespace App\Providers;

use Filament\Navigation\NavigationGroup;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;

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
        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament.css');
        });
        Filament::registerNavigationGroups([
            __('nav.basic'),
            __('nav.options'),
            __('filament-shield::filament-shield.nav.group')
        ]);

    }
}
