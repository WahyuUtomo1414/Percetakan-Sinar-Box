<?php

namespace App\Models;

use App\Models\Orders;
use App\Models\Status;
use App\Models\PaymentMethod;
use App\Traits\AuditedBySoftDelete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdersPayment extends Model
{
    use HasFactory, Notifiable, SoftDeletes, AuditedBySoftDelete;
    protected $table = 'orders_payment';
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
