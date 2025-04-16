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
use App\Models\EmployeePositionInfo;
use App\Models\Payroll;
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
            if (!$employee->workInfo) {
                EmployeeWorkInfo::factory()->create([
                    'employee_id' => $employee->id,
                ]);
            }

            EmployeeIdentificationInfo::factory()->create([
                'employee_id' => $employee->id,
            ]);


            EmployeeBankInfo::factory()->create([
                'employee_id' => $employee->id,
             
            ]);

            Payroll::factory()->create([
                'employee_id' => $employee->id,
            ]);

        });
    }


    // public function withWorkInfo()
    // {
    //     return $this->has(EmployeeWorkInfo::factory());
    // }
    
    // public function withIdentificationInfo()
    // {
    //     return $this->has(EmployeeIdentificationInfo::factory());
    // }
 

    // public function withBankInfo(){
    //     return $this->has(EmployeeBankInfo::factory());
    // }

    
}
