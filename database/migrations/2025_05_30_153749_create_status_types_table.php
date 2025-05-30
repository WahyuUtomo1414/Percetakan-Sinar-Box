<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Traits\BaseModelSoftDeleteDefault;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    use BaseModelSoftDeleteDefault;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('status_type', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->string('desc', 255)->nullable();
            $this->base($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_type');
    }
};
