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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->date('pay_period_start');
            $table->date('pay_period_end');
            $table->decimal('base_salary', 12, 2);
            $table->decimal('overtime_hours', 8, 2)->default(0);
            $table->decimal('overtime_rate', 10, 2)->default(0);
            $table->decimal('overtime_pay', 12, 2)->default(0);
            $table->decimal('allowances', 12, 2)->default(0)->comment('Transport, meal, etc');
            $table->decimal('deductions', 12, 2)->default(0)->comment('Tax, insurance, etc');
            $table->decimal('gross_pay', 12, 2);
            $table->decimal('net_pay', 12, 2);
            $table->date('pay_date')->nullable();
            $table->enum('status', ['draft', 'approved', 'paid', 'cancelled'])->default('draft');
            $table->foreignId('processed_by')->nullable()->constrained('users');
            $table->json('breakdown')->nullable()->comment('Detailed breakdown of pay components');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['employee_id', 'pay_period_start', 'pay_period_end']);
            $table->index(['pay_period_start', 'pay_period_end']);
            $table->index(['status', 'pay_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};