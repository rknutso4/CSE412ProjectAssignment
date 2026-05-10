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
        Schema::create('parking_garages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('latitude');
            $table->decimal('longitude');
            $table->bigInteger('total_floors');
            $table->bigInteger('total_parking_spaces_per_floor');
            $table->bigInteger('total_parking_spaces');
            $table->bigInteger('total_available_parking_spaces');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_garages');
    }
};
