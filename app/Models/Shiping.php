<?php

namespace App\Models;

use App\Traits\AuditedBySoftDelete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shiping extends Model
{
    use HasFactory, Notifiable, SoftDeletes, AuditedBySoftDelete;
    protected $table = 'shipping';
    protected $guarded = ['id'];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
