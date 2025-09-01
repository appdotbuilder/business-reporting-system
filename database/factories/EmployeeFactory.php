<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
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
            
        $positions = [
            'accommodation' => ['Front Desk', 'Housekeeping', 'Maintenance', 'Security'],
            'restaurant' => ['Chef', 'Waiter', 'Cashier', 'Kitchen Staff'],
            'parking' => ['Attendant', 'Security', 'Supervisor'],
        ];
        
        $departments = [
            'accommodation' => ['Operations', 'Housekeeping', 'Maintenance'],
            'restaurant' => ['Kitchen', 'Service', 'Management'],
            'parking' => ['Operations', 'Security'],
        ];
        
        $hireDate = fake()->dateTimeBetween('-3 years', 'now');
        
        return [
            'employee_id' => fake()->unique()->bothify('EMP####'),
            'name' => fake()->name(),
            'email' => fake()->optional()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'address' => fake()->optional()->address(),
            'id_number' => fake()->numerify('################'),
            'birth_date' => fake()->dateTimeBetween('-50 years', '-18 years'),
            'gender' => fake()->randomElement(['male', 'female']),
            'position' => fake()->randomElement($positions[$businessType]),
            'department' => fake()->randomElement($departments[$businessType]),
            'business_type' => $businessType,
            'business_unit' => $businessUnit,
            'hire_date' => $hireDate,
            'termination_date' => fake()->boolean(10) ? fake()->dateTimeBetween($hireDate, 'now') : null,
            'base_salary' => fake()->randomFloat(2, 2500000, 8000000),
            'hourly_rate' => fake()->optional()->randomFloat(2, 15000, 50000),
            'employment_type' => fake()->randomElement(['full_time', 'part_time', 'contract']),
            'status' => fake()->randomElement(['active', 'inactive', 'terminated']),
            'notes' => fake()->optional()->paragraph(),
        ];
    }

    /**
     * Indicate that the employee is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'termination_date' => null,
        ]);
    }

    /**
     * Indicate that the employee is terminated.
     */
    public function terminated(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'terminated',
            'termination_date' => fake()->dateTimeBetween($attributes['hire_date'], 'now'),
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