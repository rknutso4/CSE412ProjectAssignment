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
        Schema::create('parking_garage_floors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('parking_garage_id')->constrained();
            $table->bigInteger('total_parking_spaces');
            $table->bigInteger('total_available_parking_spaces');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_garage_floors');
    }
};