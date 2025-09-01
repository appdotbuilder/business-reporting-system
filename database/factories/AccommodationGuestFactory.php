<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccommodationGuest>
 */
class AccommodationGuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkIn = fake()->dateTimeBetween('-30 days', 'now');
        $checkOut = fake()->boolean(70) ? fake()->dateTimeBetween($checkIn, '+30 days') : null;
        
        return [
            'name' => fake()->name(),
            'email' => fake()->optional()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'id_number' => fake()->optional()->numerify('################'),
            'business_unit' => fake()->randomElement(['goldenkost', 'greendoors', 'divakost']),
            'room_number' => fake()->randomElement(['101', '102', '103', '201', '202', '203', '301', '302', '303']),
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'daily_rate' => fake()->randomFloat(2, 150000, 500000),
            'status' => $checkOut ? fake()->randomElement(['checked_out', 'active']) : 'active',
            'notes' => fake()->optional()->paragraph(),
        ];
    }

    /**
     * Indicate that the guest is currently active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'check_out' => null,
        ]);
    }

    /**
     * Indicate that the guest has checked out.
     */
    public function checkedOut(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'checked_out',
            'check_out' => fake()->dateTimeBetween($attributes['check_in'], 'now'),
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