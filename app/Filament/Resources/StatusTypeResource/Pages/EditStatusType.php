<?php

namespace App\Filament\Resources\StatusTypeResource\Pages;

use App\Filament\Resources\StatusTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatusType extends EditRecord
{
    protected static string $resource = StatusTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
