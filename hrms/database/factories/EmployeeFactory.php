<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\EmployeePersonalInfo;
use App\Models\EmployeeWorkInfo;
use App\Models\EmployeeIdentificationInfo;
use App\Models\EmployeeBankInfo;
use App\Models\Employee;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;
   
    public function definition(): array
    {
        $roles = ['employee', 'hr', 'manager'];

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'middle_name' => $this->faker->lastName,
            'suffix' => null,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'birthdate' => $this->faker->date('Y-m-d', '-20 years'),
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'marital_status' => $this->faker->randomElement(['single', 'married', 'divorced', 'widowed']),
            'emergency_contact_number' => $this->faker->phoneNumber,
            'role' => $this->faker->randomElement($roles),
            'password' => Hash::make('password123'), // default password
            'remember_token' => Str::random(10),


         
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Employee $employee) {
            // Create related models after the employee is created
            EmployeeWorkInfo::factory()->create([
                'employee_id' => $employee->id,
                'department' => $this->faker->word,
                'position' => $this->faker->word,
                'work_status' => $this->faker->randomElement(['full_time', 'part_time', 'contract']),
                'hire_date' => $this->faker->date(),
            ]);

            EmployeeIdentificationInfo::factory()->create([
                'employee_id' => $employee->id,
                'sss_number' => 'SSS-' . $this->faker->unique()->numberBetween(100000000, 999999999),
                'pag_ibig_number' => 'PAG-IBIG-' . $this->faker->unique()->numberBetween(100000000, 999999999),
                'philhealth_number' => 'PH-' . $this->faker->unique()->numberBetween(1000000000, 9999999999),
                'tin_number' => 'TIN-' . $this->faker->unique()->numberBetween(100000000, 999999999),
            ]);


            EmployeeBankInfo::factory()->create([
                'employee_id' => $employee->id,
                'bank_name' => $this->faker->company,
                'account_number' => $this->faker->unique()->bankAccountNumber,
                'account_type' => $this->faker->randomElement(['savings', 'checking']),
            ]);
        });
    }


    public function withWorkInfo()
    {
        return $this->has(EmployeeWorkInfo::factory());
    }
    
    public function withIdentificationInfo()
    {
        return $this->has(EmployeeIdentificationInfo::factory());
    }
 

    public function withBankInfo(){
        return $this->has(EmployeeBankInfo::factory());
    }

    
}
