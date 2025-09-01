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
        Schema::create('parking_shifts', function (Blueprint $table) {
            $table->id();
            $table->date('shift_date');
            $table->enum('shift_type', ['morning', 'afternoon', 'night']);
            $table->foreignId('cashier_id')->nullable()->constrained('restaurant_cashiers');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->decimal('opening_balance', 12, 2)->default(0);
            $table->decimal('closing_balance', 12, 2)->nullable();
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->integer('total_vehicles')->default(0);
            $table->json('vehicle_breakdown')->nullable()->comment('Breakdown by vehicle type');
            $table->enum('status', ['active', 'closed', 'cancelled'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['shift_date', 'shift_type']);
            $table->index('cashier_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_shifts');
    }
};