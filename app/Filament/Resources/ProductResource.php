<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Status;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProductType;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Product Management';

    protected static ?string $navigationLabel = 'Product';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_type_id')
                    ->required()
                    ->options(ProductType::all()->pluck('name', 'id'))
                    ->searchable()
                    ->columnSpanFull()
                    ->label('Product Type'),
                TextInput::make('name')
                    ->required()
                    ->label('Product Name')
                    ->columnSpanFull()
                    ->maxLength(128),
                FileUpload::make('images')
                    ->label('Product Images')
                    ->multiple()
                    ->columnSpanFull()
                    ->preserveFilenames()
                    ->directory('products')
                    ->required(),
                Textarea::make('desc')
                    ->label('Description')
                    ->columnSpanFull(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->columnSpanFull()
                    ->prefix('IDR'),
                Select::make('status_id')
                    ->required()
                    ->label('Status')
                    ->searchable()
                    ->default(1)
                    ->columnSpanFull()
                    ->options(Status::where('status_type_id', 2)->pluck('name', 'id')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('productType.name')
                    ->label('Product Type')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                ImageColumn::make('images')
                    ->label('Images'),
                TextColumn::make('desc')
                    ->limit(50)
                    ->label('Description'),
                TextColumn::make('price')
                    ->label('Price')
                    ->prefix('Rp.')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status.name'),
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
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
