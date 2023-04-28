<?php

namespace App\Providers;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Support\Facades\Auth;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        Filament::serving(function () {
            // Using Vite
            Filament::registerViteTheme('resources/css/filament.css');

            if (Auth::check() && Auth::user()->hasRole('admin')) {
                Filament::registerUserMenuItems([
                    UserMenuItem::make()
                        ->label('Settings')
                        ->url(UserResource::getUrl())
                        ->icon('heroicon-s-cog'),
                    // ...
                ]);
            }
        });
    }
}
