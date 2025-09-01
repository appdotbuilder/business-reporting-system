<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RestaurantCashier>
 */
class RestaurantCashierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'employee_id' => fake()->unique()->bothify('EMP####'),
            'email' => fake()->optional()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'hire_date' => fake()->dateTimeBetween('-2 years', 'now'),
            'shift' => fake()->randomElement(['morning', 'afternoon', 'evening']),
            'hourly_rate' => fake()->randomFloat(2, 15000, 50000),
            'status' => fake()->randomElement(['active', 'inactive', 'terminated']),
            'notes' => fake()->optional()->paragraph(),
        ];
    }

    /**
     * Indicate that the cashier is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the cashier works morning shift.
     */
    public function morningShift(): static
    {
        return $this->state(fn (array $attributes) => [
            'shift' => 'morning',
        ]);
    }

    /**
     * Indicate that the cashier works afternoon shift.
     */
    public function afternoonShift(): static
    {
        return $this->state(fn (array $attributes) => [
            'shift' => 'afternoon',
        ]);
    }

    /**
     * Indicate that the cashier works evening shift.
     */
    public function eveningShift(): static
    {
        return $this->state(fn (array $attributes) => [
            'shift' => 'evening',
        ]);
    }
}