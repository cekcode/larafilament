<?php

namespace App\Providers;

use App\Filament\Resources\PermissionResource;
use App\Filament\Resources\RoleResource;
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
            if (Auth::check()) {
                if (Auth::user()->hasRole('admin')) {
                    Filament::registerUserMenuItems([
                        UserMenuItem::make()
                            ->label('Settings')
                            ->url('/admin/users/' . Auth::user()->id . '/edit')
                            ->icon('heroicon-s-cog'),
                        UserMenuItem::make()
                            ->label('Manage Users')
                            ->url(RoleResource::getUrl())
                            ->icon('heroicon-s-user-group'),
                        UserMenuItem::make()
                            ->label('Roles')
                            ->url(RoleResource::getUrl())
                            ->icon('heroicon-s-lock-closed'),
                        UserMenuItem::make()
                            ->label('Permissions')
                            ->url(PermissionResource::getUrl())
                            ->icon('heroicon-s-key')
                    ]);
                } else {
                    Filament::registerUserMenuItems([
                        UserMenuItem::make()
                            ->label('Settings')
                            ->url('/admin/users/' . Auth::user()->id . '/edit')
                            ->icon('heroicon-s-cog')
                    ]);
                }
            }
        });
    }
}
