<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Employee;
class PayrollIndex extends Component
{

    public function recalculateAllPayrolls()
    {
        $payrolls = \App\Models\Payroll::all();

        foreach ($payrolls as $payroll) {
            $payroll->recalculateDeductions();
        }

        session()->flash('success', 'Payroll recalculated based on updated deduction settings.');
    }

   
    public function render()
    {
        $employees = Employee::paginate(10);
        return view('livewire.payroll-index', compact('employees'));
    }
}
