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
        Schema::create('parks_at', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('parking_garage_id')->constrained();
            $table->foreignId('parking_garage_floor_id')->constrained();
            $table->time('start_time');
            $table->time('end_time');
            $table->bigInteger('total_hours');
            $table->bigInteger('total_cost');
            $table->bigInteger('applied_cost_per_hour');
            $table->bigInteger('applied_discount_amount');
            $table->string('vehicle_license_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parks_at');
    }
};