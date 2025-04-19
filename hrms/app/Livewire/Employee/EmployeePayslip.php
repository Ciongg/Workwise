<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use App\Models\ArchivedPayroll;
use Illuminate\Support\Facades\Auth;

class EmployeePayslip extends Component
{
    public $payslips;

    public function mount()
    {
        // Fetch archived payslips for the logged-in employee
        $this->payslips = Auth::user()->archivedPayrolls()->orderBy('pay_period_start', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.employee.employee-payslip');
    }
}
