<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeWorkInfo;
use App\Models\EmployeeBankInfo;
use App\Models\EmployeeLoanInfo;
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
        
        // Create additional employees using the factory
        Employee::factory()->count(10)->create();
    }
}
