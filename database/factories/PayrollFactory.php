<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payroll>
 */
class PayrollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $baseSalary = fake()->randomFloat(2, 2500000, 8000000);
        $overtimeHours = fake()->randomFloat(2, 0, 20);
        $overtimeRate = fake()->randomFloat(2, 20000, 50000);
        $overtimePay = $overtimeHours * $overtimeRate;
        $allowances = fake()->randomFloat(2, 0, 500000);
        $deductions = fake()->randomFloat(2, 100000, 800000);
        $grossPay = $baseSalary + $overtimePay + $allowances;
        $netPay = $grossPay - $deductions;
        
        $payPeriodStart = fake()->dateTimeBetween('-3 months', '-1 month');
        $payPeriodEnd = (clone $payPeriodStart)->modify('+1 month')->modify('-1 day');
        
        return [
            'employee_id' => Employee::factory(),
            'pay_period_start' => $payPeriodStart,
            'pay_period_end' => $payPeriodEnd,
            'base_salary' => $baseSalary,
            'overtime_hours' => $overtimeHours,
            'overtime_rate' => $overtimeRate,
            'overtime_pay' => $overtimePay,
            'allowances' => $allowances,
            'deductions' => $deductions,
            'gross_pay' => $grossPay,
            'net_pay' => $netPay,
            'pay_date' => fake()->boolean(70) ? fake()->dateTimeBetween($payPeriodEnd, 'now') : null,
            'status' => fake()->randomElement(['draft', 'approved', 'paid', 'cancelled']),
            'processed_by' => fake()->boolean(80) ? User::factory() : null,
            'breakdown' => [
                'base_salary' => $baseSalary,
                'overtime_pay' => $overtimePay,
                'allowances' => [
                    'transport' => fake()->randomFloat(2, 0, 200000),
                    'meal' => fake()->randomFloat(2, 0, 150000),
                ],
                'deductions' => [
                    'tax' => fake()->randomFloat(2, 50000, 400000),
                    'insurance' => fake()->randomFloat(2, 50000, 200000),
                ],
            ],
            'notes' => fake()->optional()->paragraph(),
        ];
    }

    /**
     * Indicate that the payroll is draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'pay_date' => null,
            'processed_by' => null,
        ]);
    }

    /**
     * Indicate that the payroll is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'pay_date' => fake()->dateTimeBetween($attributes['pay_period_end'], 'now'),
            'processed_by' => User::factory(),
        ]);
    }
}