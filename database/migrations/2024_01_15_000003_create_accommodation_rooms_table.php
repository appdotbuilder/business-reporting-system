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
        Schema::create('accommodation_rooms', function (Blueprint $table) {
            $table->id();
            $table->enum('business_unit', ['goldenkost', 'greendoors', 'divakost']);
            $table->string('room_number');
            $table->enum('room_type', ['single', 'double', 'suite', 'family']);
            $table->decimal('daily_rate', 10, 2);
            $table->integer('max_occupancy')->default(2);
            $table->enum('status', ['available', 'occupied', 'maintenance', 'out_of_order'])->default('available');
            $table->text('description')->nullable();
            $table->json('amenities')->nullable()->comment('Array of amenities');
            $table->timestamps();
            
            $table->unique(['business_unit', 'room_number']);
            $table->index(['business_unit', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_rooms');
    }
};