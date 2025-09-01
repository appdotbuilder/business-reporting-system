<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccommodationRoom>
 */
class AccommodationRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'business_unit' => fake()->randomElement(['goldenkost', 'greendoors', 'divakost']),
            'room_number' => fake()->unique()->randomElement(['101', '102', '103', '201', '202', '203', '301', '302', '303', '401', '402']),
            'room_type' => fake()->randomElement(['single', 'double', 'suite', 'family']),
            'daily_rate' => fake()->randomFloat(2, 150000, 500000),
            'max_occupancy' => fake()->numberBetween(1, 4),
            'status' => fake()->randomElement(['available', 'occupied', 'maintenance', 'out_of_order']),
            'description' => fake()->optional()->paragraph(),
            'amenities' => fake()->randomElements(['AC', 'TV', 'WiFi', 'Private Bathroom', 'Mini Fridge', 'Balcony'], fake()->numberBetween(2, 5)),
        ];
    }

    /**
     * Indicate that the room is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'available',
        ]);
    }

    /**
     * Indicate that the room is occupied.
     */
    public function occupied(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'occupied',
        ]);
    }

    /**
     * Set specific business unit.
     */
    public function forUnit(string $unit): static
    {
        return $this->state(fn (array $attributes) => [
            'business_unit' => $unit,
        ]);
    }
}