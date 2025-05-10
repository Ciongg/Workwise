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
            'employee_id' => null, // Automatically link employee_id
            'sss_number' => $this->faker->regexify('[0-9]{2}-[0-9]{7}-[0-9]{1}'), // Format: 34-1234567-8
            'pag_ibig_number' => $this->faker->regexify('[0-9]{4}-[0-9]{4}-[0-9]{4}'), // Format: 1234-5678-9123
            'philhealth_number' => $this->faker->regexify('[0-9]{4}-[0-9]{5}-[0-9]{2}'), // Format: 1234-56789-00
            'tin_number' => $this->faker->regexify('[0-9]{3}-[0-9]{3}-[0-9]{3}-[0-9]{3}'), // Format: 123-456-789-000
        ];
    }
}
