<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payroll;
use App\Models\Employee;
class EmployeePayrollModal extends Component
{
    public $employee;

    public $payroll;
    public $activeTab = 'payroll';

    //Personal Info
    public $email, $phone_number;

    //Work Info
    public $department, $salary, $position, $work_status, $hire_date;

    //Bank Info
    public $bank_name, $account_number, $account_type;
      
    // Identification Info
    public $sss_number, $pag_ibig_number, $philhealth_number, $tin_number;
    
    public $pay_period_start, $pay_period_end, $allowance, $overtime_pay, $gross_pay, $deductions, $net_pay, $status, $additional_deductions;

    // Overtime Info
    public $overtimeLogs = [];
    public $totalOvertimeHours = 0;
    public $totalNormalHours = 0;
    public $totalOvertimePay = 0;

    public function mount($employee)
    {
        $this->employee = $employee;

        $this->email = $employee->email;
        $this->phone_number = $employee->phone_number;

        if ($employee->workInfo) {
            $this->department = $employee->workInfo->department;
            $this->position = $employee->workInfo->position;
            $this->salary = $employee->workInfo->salary;
            $this->work_status = $employee->workInfo->work_status;
            $this->hire_date = $employee->workInfo->hire_date;
        }
        if ($employee->bankInfo) {
            $this->bank_name = $employee->bankInfo->bank_name;
            $this->account_number = $employee->bankInfo->account_number;
            $this->account_type = $employee->bankInfo->account_type;
        }
        if ($employee->identificationInfo) {
            $this->sss_number = $employee->identificationInfo->sss_number;
            $this->pag_ibig_number = $employee->identificationInfo->pag_ibig_number;
            $this->philhealth_number = $employee->identificationInfo->philhealth_number;
            $this->tin_number = $employee->identificationInfo->tin_number;
        }

        if ($employee->payrollInfo) {
            $this->payroll = $employee->payrollInfo;

            $this->pay_period_start = \Carbon\Carbon::parse($this->payroll->pay_period_start)->format('Y-m-d');
            $this->pay_period_end = \Carbon\Carbon::parse($this->payroll->pay_period_end)->format('Y-m-d');

            $this->allowance = $this->payroll->allowance;
            $this->overtime_pay = $this->payroll->overtime_pay;
            $this->gross_pay = $this->payroll->gross_pay;
            $this->additional_deductions = $this->payroll->additional_deductions;
            $this->deductions = $this->payroll->deductions;
            $this->net_pay = $this->payroll->net_pay;
            $this->status = $this->payroll->status;
        }
            // Overtime logs for this employee
            
            $this->overtimeLogs = $employee->overtimeLogs()->orderByDesc('ot_time_in')->get();

            $this->totalOvertimeHours = $employee->overtimeLogs()->sum('total_hours');
                // $this->totalOvertimeHours = $employee->overtimeLogs()
                //     ->whereIn('status', ['completed', 'auto_timed_out'])
                //     ->whereBetween('ot_time_in', [
                //         \Carbon\Carbon::parse($this->pay_period_start)->startOfDay(),
                //         \Carbon\Carbon::parse($this->pay_period_end)->endOfDay()
                //     ])
                //     ->sum('total_hours');

            // Calculate hourly rate based on monthly salary
            $monthlySalary = $employee->workInfo->salary ?? 0;
            $dailyRate = $monthlySalary / 22;
            $hourlyRate = $dailyRate / 8;

            // Calculate total overtime pay (1.25x hourly rate)
            $this->totalOvertimePay = $this->totalOvertimeHours * $hourlyRate * 1.25;

            // Calculate total normal hours from attendance
            $this->totalNormalHours = $employee->attendances()
                ->whereNotNull('total_hours')
                ->sum('total_hours');
    }

    public function save()
    {
        // Calculate gross and net pay
        $gross = $this->salary + $this->allowance + $this->overtime_pay;
        $net = $gross - $this->deductions;

        // Update Payroll Info if available
        if ($this->employee->workInfo) {
            $this->employee->workInfo->update([
                'salary' => $this->salary,
            ]);
        } else {
            // Create new Work Info if none exists
            $this->employee->workInfo()->create([
                'salary' => $this->salary,
            ]);
        }
        if ($this->employee->payrollInfo) {
            $this->employee->payrollInfo->update([
                'pay_period_start' => $this->pay_period_start,
                'pay_period_end' => $this->pay_period_end,
                'allowance' => $this->allowance,
                'overtime_pay' => $this->overtime_pay,
                'additional_deductions' => $this->additional_deductions,
                'status' => $this->status,
            ]);
        } else {
            // Create new Payroll Info if none exists
            $this->employee->payrollInfo()->create([
                'pay_period_start' => $this->pay_period_start,
                'pay_period_end' => $this->pay_period_end,
                'allowance' => $this->allowance,
                'overtime_pay' => $this->overtime_pay,
                'additional_deductions' => $this->additional_deductions,
                'status' => $this->status,
            ]);
        }

        $this->employee->refresh();

        session()->flash('message', 'Payroll information updated successfully!');
        $this->dispatch('employeeSalaryUpdated', employeeId: $this->employee->id);
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.employee-payroll-modal');
    }
}
