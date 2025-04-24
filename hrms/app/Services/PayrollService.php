<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollDeductionSetting;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\TimeService;

class PayrollService
{
    public static function generatePayrollForEmployee(Employee $employee): Payroll
    {
        if ($employee->trashed()) {
            throw new \Exception("Cannot generate payroll for a deleted employee.");
        }

        $deductionSettings = PayrollDeductionSetting::first();

        $employee->loadMissing('workInfo');

        if (!$employee->workInfo) {
            throw new \Exception("Employee does not have work info.");
        }

        $basic_salary = $employee->workInfo->salary;
        $allowance = 1000;

        // Use TimeService for pay period
        $pay_period_start = TimeService::now()->startOfMonth()->startOfDay();
        $pay_period_end = TimeService::now()->endOfMonth()->endOfDay();

        // Calculate total overtime hours within the period
        $overtime_hours = $employee->overtimeLogs()
            ->whereIn('status', ['completed', 'auto_timed_out'])
            ->whereBetween('ot_time_in', [$pay_period_start, $pay_period_end])
            ->sum('total_hours');

        // Calculate overtime pay
        $daily_rate = $basic_salary / 22;
        $hourly_rate = $daily_rate / 8;
        $overtime_pay = $overtime_hours * $hourly_rate * 1.25;

        // Calculate gross
        $gross = $basic_salary + $allowance + $overtime_pay;

        // Calculate deductions
        $sss = $basic_salary * ($deductionSettings->sss_rate ?? 0.045);
        $philhealth = $basic_salary * ($deductionSettings->philhealth_rate ?? 0.03);
        $pagibig = $basic_salary * ($deductionSettings->pagibig_rate ?? 0.01);
        $withholding_tax = $basic_salary * ($deductionSettings->withholding_tax_rate ?? 0.1);
        $additional_deductions = 0; // You can customize this if needed

        $total_deductions = $sss + $philhealth + $pagibig + $withholding_tax + $additional_deductions;

        // Calculate net pay
        $net = $gross - $total_deductions;

        // Find existing payroll first
        $payroll = Payroll::where('employee_id', $employee->id)
            ->whereDate('pay_period_start', $pay_period_start)
            ->whereDate('pay_period_end', $pay_period_end)
            ->first();

        if ($payroll) {
            // Update existing payroll
            $payroll->update([
                'allowance' => $allowance,
                'overtime_pay' => $overtime_pay,
                'gross_pay' => $gross,
                'deductions' => $sss + $philhealth + $pagibig + $withholding_tax,
                'additional_deductions' => $additional_deductions,
                'net_pay' => $net,
                'status' => 'pending',
            ]);
        } else {
            // Create new payroll
            $payroll = Payroll::create([
                'employee_id' => $employee->id,
                'pay_period_start' => $pay_period_start,
                'pay_period_end' => $pay_period_end,
                'allowance' => $allowance,
                'overtime_pay' => $overtime_pay,
                'gross_pay' => $gross,
                'deductions' => $sss + $philhealth + $pagibig + $withholding_tax,
                'additional_deductions' => $additional_deductions,
                'net_pay' => $net,
                'status' => 'pending',
            ]);
        }

        return $payroll;
    }
}
