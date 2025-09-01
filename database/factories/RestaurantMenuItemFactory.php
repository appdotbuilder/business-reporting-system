<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RestaurantMenuItem>
 */
class RestaurantMenuItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'appetizer' => ['Spring Rolls', 'Kerupuk', 'Gado-gado', 'Sate'],
            'main_course' => ['Nasi Gudeg', 'Ayam Bakar', 'Ikan Gurame', 'Rendang', 'Rawon'],
            'dessert' => ['Es Cendol', 'Klepon', 'Dodol', 'Es Campur'],
            'beverage' => ['Teh Manis', 'Kopi Tubruk', 'Jus Alpukat', 'Es Jeruk'],
            'snack' => ['Pisang Goreng', 'Tahu Isi', 'Bakwan', 'Tempe Mendoan'],
        ];
        
        $category = fake()->randomElement(array_keys($categories));
        $name = fake()->randomElement($categories[$category]);
        
        return [
            'name' => $name,
            'code' => fake()->unique()->bothify('???###'),
            'description' => fake()->optional()->sentence(),
            'category' => $category,
            'price' => fake()->randomFloat(2, 10000, 75000),
            'cost' => fake()->randomFloat(2, 5000, 40000),
            'available' => fake()->boolean(85),
            'featured' => fake()->boolean(20),
            'image_path' => fake()->optional()->imageUrl(300, 200, 'food'),
            'ingredients' => fake()->randomElements(['Rice', 'Chicken', 'Vegetables', 'Coconut milk', 'Spices'], fake()->numberBetween(2, 4)),
        ];
    }

    /**
     * Indicate that the item is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'available' => true,
        ]);
    }

    /**
     * Indicate that the item is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'featured' => true,
        ]);
    }

    /**
     * Set specific category.
     */
    public function category(string $category): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => $category,
        ]);
    }
}