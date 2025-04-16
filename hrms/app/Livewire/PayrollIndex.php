<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;
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
        $payrolls = \App\Models\Payroll::all();

        foreach ($payrolls as $payroll) {
            $payroll->recalculateDeductions();
        }

        

        session()->flash('success', 'Payroll recalculated based on updated deduction settings.');
    }

   
    public function render()
    {
        $employees = Employee::with('payrollInfo')->paginate(10);
        return view('livewire.payroll-index', compact('employees'));
    }
}
