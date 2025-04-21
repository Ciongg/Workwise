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

    public function mount()
    {
        // Check if the current date has passed the latest payroll period
        $latestPayroll = Payroll::orderBy('pay_period_end', 'desc')->first();
    
        if ($latestPayroll) {
            $currentDate = TimeService::now();
            $payPeriodEnd = \Carbon\Carbon::parse($latestPayroll->pay_period_end);
    
            // If the current date is after the payroll period end, generate payslips
            if ($currentDate->greaterThan($payPeriodEnd)) {
                $this->generatePayslips();
                $this->resetPage();
            }
        }
    }
    
    public function generatePayslips()
    {
        $payrolls = Payroll::all();

        foreach ($payrolls as $payroll) {
            // Archive all payrolls regardless of status
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
                'status' => $payroll->status,
            ]);
            // Delete from main payroll table
            $payroll->delete();

            // Create a new pending payroll for the next month
            $current_pay_period_start = \Carbon\Carbon::parse($payroll->pay_period_start);
            $new_pay_period_start = $current_pay_period_start->copy()->addMonth()->startOfMonth();
            $new_pay_period_end = $new_pay_period_start->copy()->endOfMonth();

            Payroll::create([
                'employee_id' => $payroll->employee_id,
                'pay_period_start' => $new_pay_period_start,
                'pay_period_end' => $new_pay_period_end,
                'allowance' => $payroll->allowance,
                'overtime_pay' => $payroll->overtime_pay, // carry over
                'gross_pay' => $payroll->gross_pay,       // carry over
                'deductions' => $payroll->deductions,     // carry over
                'additional_deductions' => $payroll->additional_deductions, // carry over
                'net_pay' => $payroll->net_pay,            // carry over
                'status' => 'pending',
            ]);
            
        }

        session()->flash('message', 'All payrolls archived and new pending payrolls created for next month.');
        $this->resetPage();
    }
    


    public function render()
    {
        $employees = Employee::with('payrollInfo')->paginate(10);
        return view('livewire.payroll-index', compact('employees'));
    }
}
