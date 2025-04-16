<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollDeductionSetting;
use Illuminate\Support\Facades\Log;

class PayrollService
{
    public static function generatePayrollForEmployee(Employee $employee): Payroll
    {
        $deductionSettings = PayrollDeductionSetting::first();

        $employee->loadMissing('workInfo');

        if (!$employee->workInfo) {
            throw new \Exception("Employee does not have work info.");
        }

        $basic_salary = $employee->workInfo->salary;
        $allowance = 1000;
        $overtime = rand(0, 300); // You can customize this as needed
        $gross = $basic_salary + $allowance + $overtime;

        $sss = $basic_salary * ($deductionSettings->sss_rate ?? 0.045);
        $philhealth = $basic_salary * ($deductionSettings->philhealth_rate ?? 0.03);
        $pagibig = $deductionSettings->pagibig_fixed ?? 100;
        $withholding_tax = $basic_salary * ($deductionSettings->withholding_tax_rate ?? 0.1);
        $additional_deductions = rand(0, 300);

        $deductions = $sss + $philhealth + $pagibig + $withholding_tax;
        $net = $gross - ($deductions + $additional_deductions);

        return Payroll::create([
            'employee_id' => $employee->id,
            'pay_period_start' => now()->startOfMonth(),
            'pay_period_end' => now()->endOfMonth(),
            'allowance' => $allowance,
            'overtime_pay' => $overtime,
            'gross_pay' => $gross,
            'deductions' => $deductions,
            'additional_deductions' => $additional_deductions,
            'net_pay' => $net,
            'status' => 'pending',
        ]);
    }
}
