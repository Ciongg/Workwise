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
        $deductionSettings = \App\Models\PayrollDeductionSetting::first();

        $employee->loadMissing('workInfo');

        if (!$employee->workInfo) {
            throw new \Exception("Employee does not have work info.");
        }

        $basic_salary = $employee->workInfo->salary;
        $allowance = 1000;

        // Calculate total overtime hours for the current period (example: this month)
        $pay_period_start = now()->startOfMonth();
        $pay_period_end = now()->endOfMonth();
        $overtime_hours = $employee->overtimeLogs()
            ->where('status', 'completed')
            ->whereBetween('ot_time_in', [$pay_period_start, $pay_period_end])
            ->sum('total_hours');

        // Calculate hourly rate
        $daily_rate = $basic_salary / 22;
        $hourly_rate = $daily_rate / 8;

        // Overtime pay calculation
        $overtime_pay = $overtime_hours * $hourly_rate * 1.25;

        $gross = $basic_salary + $allowance + $overtime_pay;

        $sss = $basic_salary * ($deductionSettings->sss_rate ?? 0.045);
        $philhealth = $basic_salary * ($deductionSettings->philhealth_rate ?? 0.03);
        $pagibig = $deductionSettings->pagibig_fixed ?? 100;
        $withholding_tax = $basic_salary * ($deductionSettings->withholding_tax_rate ?? 0.1);
        $additional_deductions = 0; // Set as needed

        $deductions = $sss + $philhealth + $pagibig + $withholding_tax;
        $net = $gross - ($deductions + $additional_deductions);

        return Payroll::updateOrCreate(
            ['employee_id' => $employee->id, 'pay_period_start' => $pay_period_start, 'pay_period_end' => $pay_period_end],
            [
                'allowance' => $allowance,
                'overtime_pay' => $overtime_pay,
                'gross_pay' => $gross,
                'deductions' => $deductions,
                'additional_deductions' => $additional_deductions,
                'net_pay' => $net,
                'status' => 'pending',
            ]
        );
    }
}
