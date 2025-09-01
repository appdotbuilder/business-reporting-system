<?php

namespace Database\Factories;

use App\Models\RestaurantCashier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParkingShift>
 */
class ParkingShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shiftTimes = [
            'morning' => ['06:00', '14:00'],
            'afternoon' => ['14:00', '22:00'],
            'night' => ['22:00', '06:00'],
        ];
        
        $shiftType = fake()->randomElement(['morning', 'afternoon', 'night']);
        $times = $shiftTimes[$shiftType];
        $openingBalance = fake()->randomFloat(2, 50000, 200000);
        $totalRevenue = fake()->randomFloat(2, 100000, 800000);
        $closingBalance = $openingBalance + $totalRevenue;
        
        return [
            'shift_date' => fake()->dateTimeBetween('-30 days', 'now'),
            'shift_type' => $shiftType,
            'cashier_id' => RestaurantCashier::factory(),
            'start_time' => $times[0],
            'end_time' => fake()->boolean(80) ? $times[1] : null,
            'opening_balance' => $openingBalance,
            'closing_balance' => fake()->boolean(80) ? $closingBalance : null,
            'total_revenue' => $totalRevenue,
            'total_vehicles' => fake()->numberBetween(20, 150),
            'vehicle_breakdown' => [
                'car' => fake()->numberBetween(15, 80),
                'motorcycle' => fake()->numberBetween(30, 100),
                'truck' => fake()->numberBetween(0, 10),
            ],
            'status' => fake()->randomElement(['active', 'closed', 'cancelled']),
            'notes' => fake()->optional()->paragraph(),
        ];
    }

    /**
     * Indicate that the shift is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'end_time' => null,
            'closing_balance' => null,
        ]);
    }

    /**
     * Indicate that the shift is closed.
     */
    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'closed',
            'closing_balance' => $attributes['opening_balance'] + $attributes['total_revenue'],
        ]);
    }

    /**
     * Set specific shift type.
     */
    public function shiftType(string $type): static
    {
        $times = [
            'morning' => ['06:00', '14:00'],
            'afternoon' => ['14:00', '22:00'],
            'night' => ['22:00', '06:00'],
        ];
        
        return $this->state(fn (array $attributes) => [
            'shift_type' => $type,
            'start_time' => $times[$type][0],
            'end_time' => $times[$type][1],
        ]);
    }
}