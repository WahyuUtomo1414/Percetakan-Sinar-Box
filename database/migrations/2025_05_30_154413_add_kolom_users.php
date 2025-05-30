<?php

use App\Traits\BaseModelSoftDelete;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use BaseModelSoftDelete;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number', 16)->nullable(false);
            $table->string('address', 255)->nullable();
            $table->foreignId('role_id')->constrained('role');
            $this->base($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number', 16)->nullable(false);
            $table->string('address', 255)->nullable();
            $table->foreignId('role_id')->constrained('role');
            $this->base($table);
        });
    }
};
