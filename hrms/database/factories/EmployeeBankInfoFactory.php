<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeBankInfo>
 */
class EmployeeBankInfoFactory extends Factory
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
            'bank_name' => $this->faker->company,
            'account_number' => $this->faker->unique()->numerify('###########'),
            'account_type' => $this->faker->randomElement(['savings', 'checking']),

        ];
    }
}
