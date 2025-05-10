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
            $employee->load('workInfo');
        }

        $basic_salary = $employee->workInfo->salary;
        $allowance = 1000;
        $overtime = 0;
        $gross = $basic_salary + $allowance + $overtime;

        $sss = $basic_salary * ($deductionSettings->sss_rate ?? 0.045);
        $philhealth = $basic_salary * ($deductionSettings->philhealth_rate ?? 0.03);
        $pagibig = $basic_salary * ($deductionSettings->pagibig_rate ?? 0.01);
        $withholding_tax = $basic_salary * ($deductionSettings->withholding_tax_rate ?? 0.1);
        $additional_deductions = 0;
        $deductions = $sss + $philhealth + $pagibig + $withholding_tax;

        $net = $gross - ($deductions + $additional_deductions);

        // Dynamic payroll period based on current date
        $pay_period_start = now()->startOfMonth()->toDateString();
        $pay_period_end = now()->endOfMonth()->toDateString();

        return [
            'employee_id' => null,
            'pay_period_start' => $pay_period_start,
            'pay_period_end' => $pay_period_end,
            'allowance' => $allowance,
            'overtime_pay' => $overtime,
            'gross_pay' => $gross,
            'deductions' => $deductions,
            'additional_deductions' => $additional_deductions,
            'net_pay' => $net,
            'status' => 'approved',
        ];
    }
}
