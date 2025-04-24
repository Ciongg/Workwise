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
    public $sortField = 'id';
    public $sortDirection = 'asc';

    // Filter properties
    public $searchStatus = '';
    public $searchDepartment = '';
    public $searchName = '';
    public $searchPosition = '';

    protected $listeners = ['employeeSalaryUpdated' => 'recalculateAllPayrolls', 'timeUpdated' => '$refresh'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    // Filter triggers
    public function updatedSearchStatus()
    {
        $this->resetPage();
    }
    public function updatedSearchDepartment()
    {
        $this->resetPage();
    }
    public function updatedSearchName()
    {
        $this->resetPage();
    }
    public function updatedSearchPosition()
    {
        $this->resetPage();
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

    public function mount()
    {
        $latestPayroll = Payroll::orderBy('pay_period_end', 'desc')->first();
        if ($latestPayroll) {
            $currentDate = TimeService::now();
            $payPeriodEnd = \Carbon\Carbon::parse($latestPayroll->pay_period_end);
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
            $newStatus = $payroll->status === 'approved' ? 'paid' : $payroll->status;
            \App\Models\ArchivedPayroll::create([
                'employee_id' => $payroll->employee_id,
                'pay_period_start' => $payroll->pay_period_start,
                'pay_period_end' => $payroll->pay_period_end,
                'salary' => $payroll->employee->workInfo->salary,
                'allowance' => $payroll->allowance,
                'overtime_pay' => $payroll->overtime_pay,
                'gross_pay' => $payroll->gross_pay,
                'deductions' => $payroll->deductions,
                'additional_deductions' => $payroll->additional_deductions,
                'net_pay' => $payroll->net_pay,
                'status' => $newStatus,
            ]);
            $payroll->delete();

            $current_pay_period_start = \Carbon\Carbon::parse($payroll->pay_period_start);
            $new_pay_period_start = $current_pay_period_start->copy()->addMonth()->startOfMonth();
            $new_pay_period_end = $new_pay_period_start->copy()->endOfMonth();

            Payroll::create([
                'employee_id' => $payroll->employee_id,
                'pay_period_start' => $new_pay_period_start,
                'pay_period_end' => $new_pay_period_end,
                'allowance' => $payroll->allowance,
                'overtime_pay' => 0,
                'gross_pay' => $payroll->gross_pay,
                'deductions' => $payroll->deductions,
                'additional_deductions' => 0,
                'net_pay' => $payroll->gross_pay,
                'status' => 'pending',
            ]);
        }

        session()->flash('message', 'All payrolls archived and new pending payrolls created for next month.');
        $this->resetPage();
    }

    public function render()
    {
        $query = Employee::with(['payrollInfo' => function ($query) {
            $query->whereNull('deleted_at');
        }, 'workInfo']);

        // Filter by status (from payrollInfo)
        if (!empty($this->searchStatus)) {
            $query->whereHas('payrollInfo', function ($q) {
                $q->where('status', $this->searchStatus);
            });
        }

        // Filter by department (from workInfo)
        if (!empty($this->searchDepartment)) {
            $query->whereHas('workInfo', function ($q) {
                $q->where('department', 'like', '%' . $this->searchDepartment . '%');
            });
        }

        // Filter by name
        if (!empty($this->searchName)) {
            $query->where(function ($q) {
                $q->where('first_name', 'like', '%' . $this->searchName . '%')
                  ->orWhere('last_name', 'like', '%' . $this->searchName . '%');
            });
        }

        // Filter by position (from workInfo)
        if (!empty($this->searchPosition)) {
            $query->whereHas('workInfo', function ($q) {
                $q->where('position', 'like', '%' . $this->searchPosition . '%');
            });
        }

        // Sorting logic
        if (in_array($this->sortField, ['id', 'first_name', 'last_name'])) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } elseif ($this->sortField === 'name') {
            $query->orderBy('first_name', $this->sortDirection)
                  ->orderBy('last_name', $this->sortDirection);
        } elseif (in_array($this->sortField, ['department', 'position', 'salary'])) {
            $query->join('employee_work_infos', 'employees.id', '=', 'employee_work_infos.employee_id')
                  ->orderBy("employee_work_infos.{$this->sortField}", $this->sortDirection)
                  ->select('employees.*');
        } elseif (in_array($this->sortField, ['allowance', 'overtime_pay', 'gross_pay', 'deductions', 'additional_deductions', 'net_pay', 'status', 'pay_period_start'])) {
            $query->join('payrolls', 'employees.id', '=', 'payrolls.employee_id')
                  ->orderBy('payrolls.' . $this->sortField, $this->sortDirection)
                  ->select('employees.*');
        }

        $employees = $query->paginate(10);

        return view('livewire.payroll-index', compact('employees'));
    }
}
