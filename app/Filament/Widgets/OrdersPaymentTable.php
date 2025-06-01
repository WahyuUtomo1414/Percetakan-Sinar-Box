<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Status;
use Filament\Tables\Table;
use App\Models\OrdersPayment;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class OrdersPaymentTable extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    protected static ?string $heading = 'List Customer Orders';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                OrdersPayment::query()
                    ->with('order', 'status')
                    ->when(Auth::user()->role_id === 2, function ($query) {
                        $query->whereHas('order', function ($q) {
                            $q->where('created_by', Auth::id());
                        });
                    })
            )
            ->defaultPaginationPageOption(10)
            ->columns([
                TextColumn::make('order.code')
                    ->label('Order Code')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->searchable(),
                TextColumn::make('order.createdBy.name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('order.createdBy.phone_number')
                    ->label('WhatsApp / Phone Number')
                    ->formatStateUsing(function ($state) {
                        // Ubah 08xxxx menjadi 628xxxx
                        return preg_replace('/^0/', '62', $state);
                    })
                    ->url(fn ($state) => 'https://wa.me/' . preg_replace('/^0/', '62', $state), true)
                    ->color('success')
                    ->openUrlInNewTab()
                    ->searchable(),
                TextColumn::make('order.product.name')
                    ->label('Product')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('order.quantity')
                    ->label('Quantity')
                    ->sortable(),
                TextColumn::make('order.shipping.name')
                    ->label('Shipping Method')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('order.total_price')
                    ->label('Total Price')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => 'Rp. ' . number_format($state, 0, ',', '.')),
                TextColumn::make('paymentMethod.name')
                    ->label('Payment Method')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image')
                    ->label('Payment Proof'),
                TextColumn::make('desc')
                    ->label('Description')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('status.name')
                    ->label('Payment Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'PENDING' => 'info',
                        'CONFIRMMED' => 'success',
                        'FAILED' => 'danger',
                    })
                    ->searchable()
                    ->sortable(),
                SelectColumn::make('order.status.name')
                    ->label('Order Status')
                    ->options(Status::where('status_type_id', 3)->pluck('name', 'id'))
                    ->disabled(fn () => Auth::user()->role_id !== 1)
                    ->searchable()
                    ->sortable(),
            ])
            ->searchable();
    }
}
