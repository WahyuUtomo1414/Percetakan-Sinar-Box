<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Orders;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\OrdersPayment;
use App\Models\PaymentMethod;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrdersPaymentResource\Pages;
use App\Filament\Resources\OrdersPaymentResource\RelationManagers;

class OrdersPaymentResource extends Resource
{
    protected static ?string $model = OrdersPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Order Management';

    protected static ?string $navigationLabel = 'Orders Payments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('orders_id')
                    ->required()
                    ->label('Orders')
                    ->columnSpanFull()
                    ->options(Orders::all()->pluck('code', 'id'))
                    ->searchable(),
                Section::make('Payment Details')
                    ->description('Select a payment method to auto-fill account details.')
                    ->icon('heroicon-o-credit-card')
                    ->schema([
                        Select::make('payment_method_id')
                            ->required()
                            ->label('Payment Method')
                            ->options(fn () => PaymentMethod::pluck('name', 'id')->toArray())
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state) {
                                    $paymentMethod = PaymentMethod::find($state);
                                    if ($paymentMethod) {
                                        $set('account_number', $paymentMethod->account_number);
                                        $set('account_name', $paymentMethod->account_name);
                                        $set('payment_procedures', $paymentMethod->payment_procedures);
                                    }
                                } else {
                                    $set('account_number', null);
                                    $set('account_name', null);
                                    $set('payment_procedures', null);
                                }
                            }),
                        TextInput::make('account_number')
                            ->label('Account Number'),
                        TextInput::make('account_name')
                            ->disabled()
                            ->label('Account Name'),
                        Textarea::make('payment_procedures')
                            ->label('Payment Procedures')
                            ->disabled()
                            ->rows(10)
                            ->columnSpanFull(),
                    ]),
                FileUpload::make('image')
                    ->required()
                    ->label('Payment Proof Image')
                    ->preserveFilenames()
                    ->columnSpanFull()
                    ->directory('orders-payments')
                    ->image()
                    ->columnSpanFull(),
                Textarea::make('desc')
                    ->label('Description')
                    ->columnSpanFull(),
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
