<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;
use App\Models\Payroll;
class PayrollIndex extends Component
{

    use WithPagination;

    public $selectedPayroll = null;
    public $modalKey;

    protected $listeners = ['employeeSalaryUpdated' => 'recalculateAllPayrolls'];

    
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
        // Fetch only approved payrolls
        $approvedPayrolls = Payroll::where('status', 'approved')->get();

        foreach ($approvedPayrolls as $payroll) {
            // Save the approved payroll to the archived payrolls table
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
                'status' => 'paid', // Change status to paid
            ]);

            // Update the status of the current payroll to paid
            $payroll->update(['status' => 'paid']);
        }

        // Update all current payrolls for the next month
        Payroll::where('status', 'pending')->orWhere('status', 'paid')->update([
            'pay_period_start' => now()->startOfMonth()->addMonth(),
            'pay_period_end' => now()->endOfMonth()->addMonth(),
        ]);

        session()->flash('message', 'Payslips generated and archived successfully.');
    }

    public function generatePayslipForEmployee($employeeId)
    {
        $payroll = Payroll::where('employee_id', $employeeId)->where('status', 'approved')->first();

        if ($payroll) {
            // Save the approved payroll to the archived payrolls table
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
                'status' => 'paid', // Change status to paid
            ]);

            // Update the status of the current payroll to paid
            $payroll->update(['status' => 'paid']);

            session()->flash('message', 'Payslip generated and archived successfully for the employee.');
        } else {
            session()->flash('error', 'No approved payroll found for this employee.');
        }
    }

   
    public function render()
    {
        $employees = Employee::with('payrollInfo')->paginate(10);
        return view('livewire.payroll-index', compact('employees'));
    }
}
