<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ArchivedPayroll;

class ArchivedPayrollModal extends Component
{
    public $archivedPayroll;

    // Payroll Info
    public $pay_period_start, $pay_period_end, $allowance, $overtime_pay, $gross_pay, $deductions, $additional_deductions, $net_pay, $status;

    protected $listeners = ['openArchivedPayrollModal' => 'loadArchivedPayroll', 'archivedPayrollUpdated' => '$refresh'];

    public function mount($archivedPayroll = null)
    {
        if ($archivedPayroll) {
            $this->archivedPayroll = $archivedPayroll;
            $this->pay_period_start = \Carbon\Carbon::parse($archivedPayroll->pay_period_start)->format('Y-m-d');
            $this->pay_period_end = \Carbon\Carbon::parse($archivedPayroll->pay_period_end)->format('Y-m-d');
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
       

        $this->pay_period_start = \Carbon\Carbon::parse($this->archivedPayroll->pay_period_start)->format('Y-m-d');
        $this->pay_period_end = \Carbon\Carbon::parse($this->archivedPayroll->pay_period_end)->format('Y-m-d');
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
            'gross_pay' => 'required|numeric|min:0',
            'deductions' => 'required|numeric|min:0',
            'additional_deductions' => 'required|numeric|min:0',
            'net_pay' => 'required|numeric|min:0',
            'status' => 'required|in:pending,approved,paid',
        ]);

        $this->archivedPayroll->update([
            'pay_period_start' => $this->pay_period_start,
            'pay_period_end' => $this->pay_period_end,
            'allowance' => $this->allowance,
            'overtime_pay' => $this->overtime_pay,
            'gross_pay' => $this->gross_pay,
            'deductions' => $this->deductions,
            'additional_deductions' => $this->additional_deductions,
            'net_pay' => $this->net_pay,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Archived payroll updated successfully!');
        $this->dispatch('close-modal');
        $this->dispatch('archivedPayrollUpdated');
    }

    public function render()
    {
        return view('livewire.archived-payroll-modal');
    }
}
