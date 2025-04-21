<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;
use App\Models\Payroll;
use App\Services\TimeService;

class PayrollIndex extends Component
{
    use WithPagination;

    public $selectedPayroll = null;
    public $modalKey;

    protected $listeners = ['employeeSalaryUpdated' => 'recalculateAllPayrolls', 'timeUpdated' => '$refresh'];

    public function mount()
    {
        // Check if the current date has passed the payroll period
        $latestPayroll = Payroll::orderBy('pay_period_end', 'desc')->first();

        if ($latestPayroll) {
            $currentDate = TimeService::now();
            $payPeriodEnd = \Carbon\Carbon::parse($latestPayroll->pay_period_end);

            // If the current date is after the payroll period end, generate payslips
            if ($currentDate->greaterThan($payPeriodEnd)) {
                $this->generatePayslips();
                
            }
        }
    }

    public function selectPayroll($id)
    {
        $this->selectedPayroll = Employee::find($id);
        $this->modalKey = uniqid();
        $this->dispatch('open-modal', name: 'view-employee-payroll');
    }

    public function recalculateAllPayrolls()
    {
        $payrolls = Payroll::all();

        foreach ($payrolls as $payroll) {
            $payroll->recalculateDeductions();
        }

        session()->flash('success', 'Payroll recalculated based on updated deduction settings.');
    }

    public function generatePayslips()
    {
        // Fetch all payrolls (approved and others)
        $payrolls = Payroll::all();

        foreach ($payrolls as $payroll) {
            // Save the current payroll to the archived payrolls table
            \App\Models\ArchivedPayroll::create([
                'employee_id' => $payroll->employee_id,
                'pay_period_start' => $payroll->pay_period_start,
                'pay_period_end' => $payroll->pay_period_end,
                'allowance' => $payroll->allowance,
                'overtime_pay' => $payroll->overtime_pay,
                'gross_pay' => $payroll->gross_pay,
                'deductions' => $payroll->deductions,
                'additional_deductions' => $payroll->additional_deductions,
                'net_pay' => $payroll->net_pay,
                'status' => $payroll->status, // Keep the same status (e.g., pending, approved)
            ]);

            // Define the new payroll period based on the current payroll period
            $current_pay_period_start = \Carbon\Carbon::parse($payroll->pay_period_start);
            $new_pay_period_start = $current_pay_period_start->copy()->addMonth()->startOfMonth();
            $new_pay_period_end = $new_pay_period_start->copy()->endOfMonth();

            // Recalculate overtime pay for the new payroll period
            $employee = $payroll->employee;
            $overtime_hours = $employee->overtimeLogs()
                ->whereIn('status', ['completed', 'auto_timed_out'])
                ->whereBetween('ot_time_in', [$new_pay_period_start, $new_pay_period_end])
                ->sum('total_hours');

            $daily_rate = $employee->workInfo->salary / 22;
            $hourly_rate = $daily_rate / 8;
            $overtime_pay = $overtime_hours * $hourly_rate * 1.25;

            // Update the current payroll for the next month
            $payroll->update([
                'pay_period_start' => $new_pay_period_start,
                'pay_period_end' => $new_pay_period_end,
                'overtime_pay' => $overtime_pay, // Reset overtime pay based on new period
                'additional_deductions' => 0, // Reset additional deductions
                'status' => 'pending', // Reset status to pending
            ]);
        }

        session()->flash('message', 'Payslips generated and archived successfully. Payrolls have been reset for the next month.');
        $this->resetPage(); // Reset pagination
        
    }

    public function render()
    {
        $employees = Employee::with('payrollInfo')->paginate(10);
        return view('livewire.payroll-index', compact('employees'));
    }
}
