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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->enum('business_type', ['accommodation', 'restaurant', 'parking']);
            $table->string('business_unit')->nullable()->comment('For accommodation: goldenkost, greendoors, divakost');
            $table->string('category')->comment('electricity, water, supplies, maintenance, etc');
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->date('expense_date');
            $table->string('receipt_number')->nullable();
            $table->string('vendor_name')->nullable();
            $table->enum('payment_method', ['cash', 'bank_transfer', 'credit_card', 'check']);
            $table->enum('status', ['pending', 'approved', 'paid', 'rejected'])->default('pending');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['business_type', 'business_unit']);
            $table->index(['expense_date', 'category']);
            $table->index(['status', 'created_by']);
            $table->index('receipt_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};