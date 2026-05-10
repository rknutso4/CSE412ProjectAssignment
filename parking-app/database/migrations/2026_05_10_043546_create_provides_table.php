<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('provides', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('parking_garage_owner_id')->constrained();
            $table->foreignId('parking_garage_id')->constrained();
            $table->time('day_start_time');
            $table->time('day_end_time');
            $table->bigInteger('cost_per_hour');
            $table->bigInteger('minimum_cost_per_hour');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provides');
    }
};