<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ArchivedPayroll;

class ArchivedPayrollModal extends Component
{
    public $archivedPayroll;

    // Payroll Info
    public $pay_period_start;
    public $pay_period_end;
    public $salary;
    public $allowance;
    public $overtime_pay;
    public $gross_pay;
    public $deductions;
    public $additional_deductions;
    public $net_pay;
    public $status;

    protected $listeners = ['openArchivedPayrollModal' => 'loadArchivedPayroll', 'archivedPayrollUpdated' => '$refresh'];

    public function mount($archivedPayroll = null)
    {
        if ($archivedPayroll) {
            $this->archivedPayroll = $archivedPayroll;
            $this->pay_period_start = \Carbon\Carbon::parse($archivedPayroll->pay_period_start)->format('Y-m-d');
            $this->pay_period_end = \Carbon\Carbon::parse($archivedPayroll->pay_period_end)->format('Y-m-d');
            $this->salary = $archivedPayroll->salary;
            $this->allowance = $archivedPayroll->allowance;
            $this->overtime_pay = $archivedPayroll->overtime_pay;
            $this->gross_pay = $archivedPayroll->gross_pay;
            $this->deductions = $archivedPayroll->deductions;
            $this->additional_deductions = $archivedPayroll->additional_deductions;
            $this->net_pay = $archivedPayroll->net_pay;
            $this->status = $archivedPayroll->status;

       
        }
    }

    public function loadArchivedPayroll($id)
    {
        $this->archivedPayroll = \App\Models\ArchivedPayroll::findOrFail($id);

        $this->pay_period_start = \Carbon\Carbon::parse($this->archivedPayroll->pay_period_start)->format('Y-m-d');
        $this->pay_period_end = \Carbon\Carbon::parse($this->archivedPayroll->pay_period_end)->format('Y-m-d');
        $this->salary = $this->archivedPayroll->salary;
        $this->allowance = $this->archivedPayroll->allowance;
        $this->overtime_pay = $this->archivedPayroll->overtime_pay;
        $this->gross_pay = $this->archivedPayroll->gross_pay;
        $this->deductions = $this->archivedPayroll->deductions;
        $this->additional_deductions = $this->archivedPayroll->additional_deductions;
        $this->net_pay = $this->archivedPayroll->net_pay;
        $this->status = $this->archivedPayroll->status;

     
    }

    public function save()
    {
        $this->validate([
            'allowance' => 'required|numeric|min:0',
            'overtime_pay' => 'required|numeric|min:0',
            'salary' => 'required|numeric|min:0',
            'gross_pay' => 'required|numeric|min:0',
            'deductions' => 'required|numeric|min:0',
            'additional_deductions' => 'required|numeric|min:0',
            'net_pay' => 'required|numeric|min:0',
            'status' => 'required|in:pending,approved,paid',
        ]);

        $this->archivedPayroll->update([
            'pay_period_start' => $this->pay_period_start,
            'pay_period_end' => $this->pay_period_end,
            'salary' => $this->salary,
            'allowance' => $this->allowance,
            'overtime_pay' => $this->overtime_pay,
            'gross_pay' => $this->gross_pay,
            'deductions' => $this->deductions,
            'additional_deductions' => $this->additional_deductions,
            'net_pay' => $this->net_pay,
            'status' => $this->status,
        ]);

        // Emit event with archived payroll ID and employee ID for recalculation
        $this->dispatch('archivedPayrollSalaryChanged', id: $this->archivedPayroll->id, employee_id: $this->archivedPayroll->employee_id);

        $this->dispatch('close-modal');
        $this->dispatch('archivedPayrollUpdated');
    }

    public function render()
    {
        return view('livewire.archived-payroll-modal');
    }
}
