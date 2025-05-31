<?php

namespace App\Filament\Resources\ShipingResource\Pages;

use App\Filament\Resources\ShipingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShiping extends EditRecord
{
    protected static string $resource = ShipingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
