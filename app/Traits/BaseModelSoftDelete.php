<?php

namespace App\Traits;

use Illuminate\Database\Schema\Blueprint;

trait BaseModelSoftDelete
{
    public function base(Blueprint $table): void
    {
        $table->unsignedBigInteger('status_id');
        $table->unsignedBigInteger('created_by')->default(1);
        $table->unsignedBigInteger('updated_by')->nullable();
        $table->unsignedBigInteger('deleted_by')->nullable();
        $table->timestamps();
        $table->softDeletes();
    }
}
