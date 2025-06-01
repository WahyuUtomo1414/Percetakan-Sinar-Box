<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Orders;
use App\Models\Status;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\OrdersPayment;
use App\Models\PaymentMethod;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
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

    protected static ?string $navigationLabel = 'Payment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('order_id')
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
                Select::make('status_id')
                    ->required()
                    ->label('Status')
                    ->searchable()
                    ->default(function () {
                        return Status::where('status_type_id', 4)
                            ->where('name', 'pending')
                            ->value('id');
                    })
                    ->columnSpanFull()
                    ->options(Status::where('status_type_id', 4)->pluck('name', 'id')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.code')
                    ->label('Order Code')
                    ->sortable(),
                TextColumn::make('order.createdBy.name')
                    ->label('Customer Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('paymentMethod.name')
                    ->label('Payment Method')
                    ->sortable(),
                ImageColumn::make('image')
                    ->label('Payment Proof'),
                TextColumn::make('desc')
                    ->label('Description')
                    ->searchable(),
                TextColumn::make('status.name')
                    ->label('Status')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('createdBy.name')
                    ->label('Created By')
                    ->visible(fn () => Auth::user()->role_id === 1),
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
            'index' => Pages\ListOrdersPayments::route('/'),
            'create' => Pages\CreateOrdersPayment::route('/create'),
            'edit' => Pages\EditOrdersPayment::route('/{record}/edit'),
        ];
    }
}
