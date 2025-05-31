<?php

namespace App\Filament\Resources\OrdersPaymentResource\Pages;

use App\Filament\Resources\OrdersPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrdersPayment extends EditRecord
{
    protected static string $resource = OrdersPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
