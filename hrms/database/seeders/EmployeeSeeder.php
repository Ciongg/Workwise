<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeWorkInfo;
use App\Models\EmployeeBankInfo;
use App\Models\EmployeeIdentificationInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a specific account with the email test@test.com
        Employee::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@test.com',
            'role' => 'employee',
            'password' => Hash::make('password123'), // Default password
        ]);

        Employee::factory()->create([
            'first_name' => 'hr',
            'last_name' => 'User',
            'email' => 'hr@hr.com',
            'role' => 'hr',
            'password' => Hash::make('password123'), // Default password
        ]);

        // Create additional employees using the factory
        Employee::factory()->count(20)->create();
    }
}
