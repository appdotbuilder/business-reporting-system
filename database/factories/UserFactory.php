<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['developer', 'owner', 'staff']),
            'business_type' => fake()->optional()->randomElement(['accommodation', 'restaurant', 'parking']),
            'business_unit' => fake()->optional()->randomElement(['goldenkost', 'greendoors', 'divakost']),
            'active' => true,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is a developer.
     */
    public function developer(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'developer',
            'business_type' => null,
            'business_unit' => null,
        ]);
    }

    /**
     * Indicate that the user is an owner.
     */
    public function owner(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'owner',
            'business_type' => null,
            'business_unit' => null,
        ]);
    }

    /**
     * Indicate that the user is staff.
     */
    public function staff(string $businessType = null, string $businessUnit = null): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'staff',
            'business_type' => $businessType,
            'business_unit' => $businessUnit,
        ]);
    }
}
