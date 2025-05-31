<?php

namespace App\Filament\Resources\StatusTypeResource\Pages;

use App\Filament\Resources\StatusTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatusTypes extends ListRecords
{
    protected static string $resource = StatusTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
