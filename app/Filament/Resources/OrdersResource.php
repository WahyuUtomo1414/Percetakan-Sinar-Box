<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Orders;
use App\Models\Status;
use App\Models\Product;
use App\Models\Shiping;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PaymentMethod;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrdersResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrdersResource\RelationManagers;

class OrdersResource extends Resource
{
    protected static ?string $model = Orders::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Order Management';

    protected static ?string $navigationLabel = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('code')
                    ->required()
                    ->label('Order Code')
                    ->disabled(fn ($context) => $context === 'edit')
                    ->default(function ($context) {
                        if ($context === 'create') {
                            $randomNumber = rand(100, 99999);
                            return 'ORD-' . $randomNumber . '-' . now()->format('Ymd');
                        }
                        return null;
                    }),
                Select::make('product_id')
                    ->required()
                    ->label('Product')
                    ->options(Product::all()->pluck('name', 'id'))
                    ->searchable()
                    ->reactive()
                    ->columnSpanFull()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $set('total_price', app(Orders::class)->fill([
                            'product_id' => $get('product_id'),
                            'shipping_id' => $get('shipping_id'),
                            'quantity' => $get('quantity'),
                        ])->calculateTotalPrice());
                    }),

                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $set('total_price', app(Orders::class)->fill([
                            'product_id' => $get('product_id'),
                            'shipping_id' => $get('shipping_id'),
                            'quantity' => $get('quantity'),
                        ])->calculateTotalPrice());
                    }),

                Select::make('shipping_id')
                    ->required()
                    ->label('Shipping')
                    ->options(Shiping::all()->pluck('name', 'id'))
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $set('total_price', app(Orders::class)->fill([
                            'product_id' => $get('product_id'),
                            'shipping_id' => $get('shipping_id'),
                            'quantity' => $get('quantity'),
                        ])->calculateTotalPrice());
                    }),

                TextInput::make('total_price')
                    ->disabled()
                    ->numeric()
                    ->default(0)
                    ->columnSpanFull()
                    ->prefix('Rp.')
                    ->dehydrated(),
                Select::make('status_id')
                    ->required()
                    ->label('Status')
                    ->searchable()
                    ->default('PENDING')
                    ->disabled(function () {
                        $user = auth()->user();
                        return $user && $user->role_id == 2;
                    })
                    ->columnSpanFull()
                    ->options(Status::where('status_type_id', 3)->pluck('name', 'id')),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->color('primary'),
                TextColumn::make('product.name')
                    ->label('Product')  
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('shipping.name')
                    ->label('Shipping')
                    ->sortable(),
                TextColumn::make('total_price')
                    ->label('Total Price')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp. ' . number_format($state, 0, ',', '.')),
                TextColumn::make('status.name')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('createdBy.name')
                    ->label('Created By'),
                TextColumn::make('updatedBy.name')
                    ->label("Updated by"),
                TextColumn::make('deletedBy.name')
                    ->label("Deleted by"),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrders::route('/create'),
            'edit' => Pages\EditOrders::route('/{record}/edit'),
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
