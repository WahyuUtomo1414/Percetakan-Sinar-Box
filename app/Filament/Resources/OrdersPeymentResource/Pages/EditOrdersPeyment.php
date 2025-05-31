<?php

namespace App\Filament\Resources\OrdersPeymentResource\Pages;

use App\Filament\Resources\OrdersPeymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrdersPeyment extends EditRecord
{
    protected static string $resource = OrdersPeymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
