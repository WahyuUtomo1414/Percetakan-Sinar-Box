<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait AuditedBySoftDelete
{
    public static function bootAuditedBySoftDelete()
    {
        static::creating(function ($model) {
            if (!$model->isDirty('created_by')) {
                $model->created_by = Auth::user()->id ?? null;
            }
        });

        static::updating(function ($model) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = Auth::user()->id ?? null;
            }
        });

        static::deleting(function ($model) {
            $model->deleted_by = Auth::user()->id ?? null;
            $model->save();
        });

        static::restoring(function ($model) {
            $model->deleted_by = null;
            $model->save();
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getCreatorNameAttribute()
    {
        return $this->createdBy?->name;
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getUpdatedNameAttribute()
    {
        return $this->updatedBy?->name;
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getDeletedNameAttribute()
    {
        return $this->deletedBy?->name;
    }
}
