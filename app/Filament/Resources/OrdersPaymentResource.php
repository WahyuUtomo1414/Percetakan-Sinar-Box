<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrdersPaymentResource\Pages;
use App\Filament\Resources\OrdersPaymentResource\RelationManagers;
use App\Models\OrdersPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersPaymentResource extends Resource
{
    protected static ?string $model = OrdersPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('payment_method_id')
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required(),
                Forms\Components\TextInput::make('desc')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('created_by')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\TextInput::make('updated_by')
                    ->numeric(),
                Forms\Components\TextInput::make('deleted_by')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('desc')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_by')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListOrdersPayments::route('/'),
            'create' => Pages\CreateOrdersPayment::route('/create'),
            'edit' => Pages\EditOrdersPayment::route('/{record}/edit'),
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
