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
            ['Engineering', 'Electrical Engineer', 25000, 40000],
            ['Engineering', 'Project Engineer', 30000, 45000],
            ['Engineering', 'Technician', 15000, 25000],
            ['Engineering', 'Electrician', 14000, 22000],
            ['Operations', 'Project Manager', 35000, 50000],
            ['Operations', 'Site Supervisor', 28000, 40000],
            ['Operations', 'Foreman', 22000, 32000],
            ['Logistics', 'Driver', 14000, 20000],
            ['Logistics', 'Warehouse Staff', 13000, 18000],
            ['Logistics', 'Delivery Assistant', 12000, 16000],
            ['Procurement', 'Procurement Officer', 27000, 37000],
            ['Procurement', 'Inventory Clerk', 18000, 24000],
            ['Procurement', 'Supply Chain Assistant', 20000, 30000],
            ['Finance', 'Accountant', 30000, 45000],
            ['Finance', 'Bookkeeper', 20000, 30000],
            ['HR', 'HR Officer', 25000, 35000],
            ['HR', 'Admin Assistant', 18000, 25000],
            ['Sales/Marketing', 'Sales Engineer', 28000, 42000],
            ['Sales/Marketing', 'Marketing Officer', 26000, 38000],
            ['Sales/Marketing', 'Business Development', 30000, 45000],
            ['Executive', 'General Manager', 60000, 90000],
            ['Executive', 'Operations Manager', 50000, 80000],
        ];

        $entry = collect($positionSalaries)->random();
        [$department, $position, $minSalary, $maxSalary] = $entry;

        return [
            'employee_id' => null, // Automatically link employee_id
            'work_status' => $this->faker->randomElement(['full_time', 'part_time', 'contract']),
            'department' => $department,
            'position' => $position,
            'salary' => round($this->faker->numberBetween($minSalary, $maxSalary), -3),
            'hire_date' => $this->faker->date(),
            'work_start_time' => '08:00:00', // Default work start time
            'work_end_time' => '17:00:00',   // Default work end time
            'break_start_time' => '12:00:00', // Default break start time
            'break_end_time' => '13:00:00',   // Default break end time
        ];
    }
}
