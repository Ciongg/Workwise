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

        $positionSalaries = [
            ['Engineering', 'Electrical Engineer', 30000, 60000],
            ['Engineering', 'Project Engineer', 25000, 45000],
            ['Engineering', 'Technician', 14000, 20000],
            ['Engineering', 'Electrician', 15000, 25000],
            ['Operations', 'Project Manager', 45000, 80000],
            ['Operations', 'Site Supervisor', 25000, 40000],
            ['Operations', 'Foreman', 20000, 30000],
            ['Logistics', 'Driver', 12000, 18000],
            ['Logistics', 'Warehouse Staff', 12000, 16000],
            ['Logistics', 'Delivery Assistant', 11000, 15000],
            ['Procurement', 'Procurement Officer', 18000, 30000],
            ['Procurement', 'Inventory Clerk', 13000, 18000],
            ['Procurement', 'Supply Chain Assistant', 14000, 22000],
            ['Finance', 'Accountant', 20000, 35000],
            ['Finance', 'Bookkeeper', 15000, 25000],
            ['HR', 'HR Officer', 18000, 30000],
            ['HR', 'Admin Assistant', 12000, 18000],
            ['Sales/Marketing', 'Sales Engineer', 25000, 45000],
            ['Sales/Marketing', 'Marketing Officer', 15000, 25000],
            ['Sales/Marketing', 'Business Development', 20000, 35000],
            ['Executive', 'General Manager', 80000, 150000],
            ['Executive', 'Operations Manager', 50000, 90000],
        ];

        $entry = collect($positionSalaries)->random();
        [$department, $position, $minSalary, $maxSalary] = $entry;

        return [
           'employee_id' => Employee::factory(), // Automatically link employee_id
            'work_status' => $this->faker->randomElement(['full_time', 'part_time', 'contract']),
            'department' => $department,
            'position' => $position,
            'salary' => round($this->faker->numberBetween($minSalary, $maxSalary), -3),
            'hire_date' => $this->faker->date(),
        ];
    }
}
