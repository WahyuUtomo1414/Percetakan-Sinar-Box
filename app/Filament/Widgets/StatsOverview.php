<?php

namespace App\Filament\Widgets;

use App\Models\Orders;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();
        if ($user && $user->role_id == 2) {
            return [];
        }

        $customers = User::where('role_id', 2)->count();
        $orders = Orders::count();
        $revenue = Orders::sum('total_price');
        $revenueFormatted = 'Rp. ' . number_format($revenue, 0, ',', '.');
        $revenueFormatted = $revenueFormatted === 'Rp. 0' ? 'Rp. 0' : $revenueFormatted;

        return [
            Stat::make('All Customer', $customers)
                ->description('Customer')
                ->descriptionIcon('heroicon-m-user')
                ->chart([2, 3, 35, 18, 15, 26, 15, 30, 25, 30, 25, 50])
                ->color('info'),
            Stat::make('All Orders', $orders)
                ->description('Orders')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->chart([32, 23, 35, 18, 15, 56, 15, 30, 25, 30, 25, 30])
                ->color('warning'),
            Stat::make('Amount Revenue', $revenueFormatted)
                ->description('Revenue')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }
}
