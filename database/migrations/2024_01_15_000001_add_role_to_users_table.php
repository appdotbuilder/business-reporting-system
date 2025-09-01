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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['developer', 'owner', 'staff'])->default('staff');
            $table->string('business_type')->nullable()->comment('accommodation, restaurant, parking');
            $table->string('business_unit')->nullable()->comment('For accommodation: goldenkost, greendoors, divakost');
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'business_type', 'business_unit', 'active']);
        });
    }
};