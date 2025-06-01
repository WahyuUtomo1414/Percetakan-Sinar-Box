<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Status;
use App\Models\Shiping;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ShipingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ShipingResource\RelationManagers;

class ShipingResource extends Resource
{
    protected static ?string $model = Shiping::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Order Setting';

    protected static ?string $navigationLabel = 'Shipping';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Shipping Name')
                    ->columnSpanFull()
                    ->maxLength(128),
                Textarea::make('desc')
                    ->label('Description')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->label('Shipping Price')
                    ->columnSpanFull()
                    ->prefix('Rp.')
                    ->numeric(),
                Select::make('status_id')
                    ->required()
                    ->label('Status')
                    ->searchable()
                    ->default(1)
                    ->columnSpanFull()
                    ->options(Status::where('status_type_id', 1)->pluck('name', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('desc')
                    ->label('Description')
                    ->limit(50),
                TextColumn::make('price')
                    ->label('Price')
                    ->prefix('Rp.')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status.name')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->visible(fn () => Auth::user()->role_id === 1),
                TextColumn::make('updatedBy.name')
                    ->label("Updated by")
                    ->visible(fn () => Auth::user()->role_id === 1),
                TextColumn::make('deletedBy.name')
                    ->label("Deleted by")
                    ->visible(fn () => Auth::user()->role_id === 1),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShipings::route('/'),
            'create' => Pages\CreateShiping::route('/create'),
            'edit' => Pages\EditShiping::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
