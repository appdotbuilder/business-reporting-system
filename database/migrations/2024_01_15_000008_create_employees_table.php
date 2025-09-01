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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('id_number')->comment('National ID or similar');
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
            $table->string('position');
            $table->string('department');
            $table->enum('business_type', ['accommodation', 'restaurant', 'parking']);
            $table->string('business_unit')->nullable()->comment('For accommodation units');
            $table->date('hire_date');
            $table->date('termination_date')->nullable();
            $table->decimal('base_salary', 12, 2);
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->enum('employment_type', ['full_time', 'part_time', 'contract']);
            $table->enum('status', ['active', 'inactive', 'terminated'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('employee_id');
            $table->index(['business_type', 'business_unit']);
            $table->index(['status', 'department']);
            $table->index('hire_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};