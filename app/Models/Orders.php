<?php

namespace App\Models;

use App\Models\Status;
use App\Models\Product;
use App\Models\Shiping;
use App\Traits\AuditedBySoftDelete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory, Notifiable, SoftDeletes, AuditedBySoftDelete;
    protected $table = 'orders';
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function shipping()
    {
        return $this->belongsTo(Shiping::class, 'shipping_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function ordersPayment()
    {
        return $this->hasOne(OrdersPayment::class, 'order_id');
    }

    public function calculateTotalPrice(): int
    {
        $productPrice = $this->product?->price ?? 0;
        $shippingPrice = $this->shipping?->price ?? 0;
        $quantity = $this->quantity ?? 0;

        return ($productPrice * $quantity) + $shippingPrice;
    }
}
