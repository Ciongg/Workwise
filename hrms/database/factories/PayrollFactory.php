<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EmployeeWorkInfo;
use App\Models\PayrollDeductionSetting;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payroll>
 */
class PayrollFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $deductionSettings = PayrollDeductionSetting::first();
      
        $employee = Employee::inRandomOrder()->first() ?? Employee::factory()->create();
        
     
        if (!$employee->workInfo) {
            $employee->workInfo()->create(EmployeeWorkInfo::factory()->make()->toArray());
            $employee->load('workInfo'); // This refreshes the relationship
        }
        
        
        $basic = $employee->workInfo->salary;
        $allowance = 1000;
        $overtime = round(fake()->numberBetween(0, 300));
        $gross = $basic + $allowance + $overtime;

        $sss = $basic * ($deductionSettings->sss_rate ?? 0.045);
        $philhealth = $basic * ($deductionSettings->philhealth_rate ?? 0.03);
        $pagibig = $deductionSettings->pagibig_fixed ?? 100;
        $withholding_tax = $basic * ($deductionSettings->withholding_tax_rate ?? 0.1);
    
        $deductions = $sss + $philhealth + $pagibig + $withholding_tax;

        $net = $gross - $deductions;

        return [
            'employee_id' => $employee->id,
            'pay_period_start' => now()->startOfMonth(),
            'pay_period_end' => now()->endOfMonth(),
            'basic_salary' => $basic,
            'allowance' => $allowance,
            'overtime_pay' => $overtime,
            'gross_pay' => $gross,
            'deductions' => $deductions,
            'net_pay' => $net,
            'status' => 'pending',
        ];
    }
}
