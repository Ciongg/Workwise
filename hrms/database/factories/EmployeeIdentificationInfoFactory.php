<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeIdentificationInfo>
 */
class EmployeeIdentificationInfoFactory extends Factory
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
            'sss_number' => $this->faker->unique()->numerify('SSS-########'),
            'pag_ibig_number' => $this->faker->unique()->numerify('PAG-IBIG-########'),
            'philhealth_number' => $this->faker->unique()->numerify('PHIL-########'),
            'tin_number' => $this->faker->unique()->numerify('TIN-########'),
          
        ];
    }
}
