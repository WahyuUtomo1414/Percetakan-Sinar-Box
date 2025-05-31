<?php

namespace App\Filament\Resources\OrdersPaymentResource\Pages;

use App\Filament\Resources\OrdersPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrdersPayments extends ListRecords
{
    protected static string $resource = OrdersPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
