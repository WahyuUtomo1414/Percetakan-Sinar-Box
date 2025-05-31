<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Actions\DeleteAction as ActionsDeleteAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Actions\ViewAction as ActionsViewAction;
use Filament\Tables\Table;
use Tables\Actions\EditAction;
use Tables\Actions\ViewAction;
use Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class ProductTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(Product::query()->with('productType', 'status'))
            ->defaultPaginationPageOption(5)
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
            ])
            ->searchable();
    }
}
