<?php

namespace App\Filament\Resources\OrdersPeymentResource\Pages;

use App\Filament\Resources\OrdersPeymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrdersPeyments extends ListRecords
{
    protected static string $resource = OrdersPeymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
