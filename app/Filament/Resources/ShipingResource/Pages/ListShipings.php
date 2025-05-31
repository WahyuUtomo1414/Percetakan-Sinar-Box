<?php

namespace App\Filament\Resources\ShipingResource\Pages;

use App\Filament\Resources\ShipingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShipings extends ListRecords
{
    protected static string $resource = ShipingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
