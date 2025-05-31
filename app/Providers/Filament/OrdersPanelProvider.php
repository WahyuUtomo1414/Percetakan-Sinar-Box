<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use App\Filament\Widgets\ProductTable;
use App\Filament\Widgets\StatsOverview;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Pages\Auth\RegisterCustom;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class OrdersPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('orders')
            ->path('orders')
            ->font('poppins')
            ->brandLogo($this->getBrandLogo())
            ->brandLogoHeight($this->getBrandLogoHeight())
            ->favicon(asset('images/2.jpg'))
            ->login()
            ->registration(RegisterCustom::class)
            ->colors([
                'primary' => Color::Blue,
            ])
            ->darkMode(false)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    protected function getBrandLogo(): ?string
    {
        if (request()->is('orders/login')) {
            return asset('images/1.jpg');
        }

        return asset('images/1.jpg');
    }

    protected function getBrandLogoHeight(): string
    {
        if (request()->is('orders/login')) {
            return '5rem';
        }

        return '3rem';
    }
}
