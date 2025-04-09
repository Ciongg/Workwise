<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeWorkInfo>
 */
class EmployeeWorkInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(), // Automatically link employee_id
            'department' => $this->faker->word,
            'position' => $this->faker->randomElement(['manager', 'developer', 'designer']),
            'work_status' => $this->faker->randomElement(['full-time', 'part-time', 'contract']),
            'hire_date' => $this->faker->date(),
        ];
    }
}
