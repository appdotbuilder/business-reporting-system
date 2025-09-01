<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $businessType = fake()->randomElement(['accommodation', 'restaurant', 'parking']);
        $businessUnit = $businessType === 'accommodation' 
            ? fake()->randomElement(['goldenkost', 'greendoors', 'divakost'])
            : null;
            
        $categories = [
            'accommodation' => ['electricity', 'water', 'maintenance', 'supplies', 'cleaning', 'internet'],
            'restaurant' => ['ingredients', 'gas', 'electricity', 'equipment', 'supplies'],
            'parking' => ['equipment', 'maintenance', 'security', 'utilities'],
        ];
        
        return [
            'business_type' => $businessType,
            'business_unit' => $businessUnit,
            'category' => fake()->randomElement($categories[$businessType]),
            'description' => fake()->sentence(),
            'amount' => fake()->randomFloat(2, 50000, 2000000),
            'expense_date' => fake()->dateTimeBetween('-60 days', 'now'),
            'receipt_number' => fake()->optional()->bothify('RCP#######'),
            'vendor_name' => fake()->optional()->company(),
            'payment_method' => fake()->randomElement(['cash', 'bank_transfer', 'credit_card', 'check']),
            'status' => fake()->randomElement(['pending', 'approved', 'paid', 'rejected']),
            'created_by' => User::factory(),
            'approved_by' => fake()->boolean(60) ? User::factory() : null,
            'notes' => fake()->optional()->paragraph(),
        ];
    }

    /**
     * Indicate that the expense is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'approved_by' => null,
        ]);
    }

    /**
     * Indicate that the expense is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'approved_by' => User::factory(),
        ]);
    }

    /**
     * Set specific business type.
     */
    public function forBusiness(string $type, string $unit = null): static
    {
        return $this->state(fn (array $attributes) => [
            'business_type' => $type,
            'business_unit' => $unit,
        ]);
    }
}