<?php

namespace App\Filament\Resources\OrdersResource\Pages;

use Filament\Actions;
use Illuminate\Http\RedirectResponse;
use App\Filament\Resources\OrdersResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrders extends CreateRecord
{
    protected static string $resource = OrdersResource::class;

    protected function afterCreate(): void
    {
        $this->redirect('/orders/orders-payments/create');
    }
}
