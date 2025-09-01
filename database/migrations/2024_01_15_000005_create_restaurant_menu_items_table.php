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
        Schema::create('restaurant_menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique()->comment('Item code for POS system');
            $table->text('description')->nullable();
            $table->enum('category', ['appetizer', 'main_course', 'dessert', 'beverage', 'snack']);
            $table->decimal('price', 10, 2);
            $table->decimal('cost', 10, 2)->nullable()->comment('Cost to make the item');
            $table->boolean('available')->default(true);
            $table->boolean('featured')->default(false);
            $table->string('image_path')->nullable();
            $table->json('ingredients')->nullable()->comment('List of ingredients');
            $table->timestamps();
            
            $table->index('code');
            $table->index(['category', 'available']);
            $table->index('featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_menu_items');
    }
};