<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeLoanInfo>
 */
class EmployeeLoanInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'loan_type' => $this->faker->randomElement(['personal', 'housing', 'auto']),
            'loan_amount' => $this->faker->numberBetween(10000, 500000),
            'monthly_amortization' => $this->faker->numberBetween(1000, 5000),

        ];
    }  
}
