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
        Schema::create('accommodation_guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('id_number')->nullable()->comment('Identity card number');
            $table->enum('business_unit', ['goldenkost', 'greendoors', 'divakost']);
            $table->string('room_number');
            $table->date('check_in');
            $table->date('check_out')->nullable();
            $table->decimal('daily_rate', 10, 2);
            $table->enum('status', ['active', 'checked_out', 'cancelled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['business_unit', 'status']);
            $table->index(['check_in', 'check_out']);
            $table->index('room_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodation_guests');
    }
};