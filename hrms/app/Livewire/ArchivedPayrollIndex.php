<?php

namespace App\Livewire;

use App\Models\ArchivedPayroll;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;
use App\Services\PayrollService;

class ArchivedPayrollIndex extends Component
{
    use WithPagination;

    public $selectedMonth = null;
    public $selectedYear = null;
    public $searchName = null;
    public $statusFilter = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';

    public $selectedArchivedPayroll = null;
    public $modalKey;

    protected $listeners = [
        'archivedPayrollUpdated' => '$refresh',
        'archivedPayrollSalaryChanged' => 'recalculateArchivedPayroll'
    ];

    protected $paginationTheme = 'tailwind'; // Optional: Use Tailwind pagination styles

    public function selectArchivedPayroll($id)
    {
        $this->selectedArchivedPayroll = ArchivedPayroll::with('employee')->findOrFail($id); // Fetch ArchivedPayroll with related Employee
        $this->modalKey = uniqid(); // Generate a unique key for the modal
        $this->dispatch('open-modal', name: 'view-employee-archived-payroll'); // Trigger the modal
    }

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

    // Add query string support for filters
    protected $queryString = [
        'selectedMonth' => ['except' => null],
        'selectedYear' => ['except' => null],
        'searchName' => ['except' => null],
    ];

    public function updatedSelectedMonth()
    {
        $this->resetPage(); // Reset pagination when the month filter changes
    }

    public function updatedSelectedYear()
    {
        $this->resetPage(); // Reset pagination when the year filter changes
    }

    public function updatedSearchName()
    {
        $this->resetPage(); // Reset pagination when the search term changes
    }
    
    private function getMonths()
    {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
    }

    private function getYears()
    {
        $startYear = now()->year - 5; // Show the last 5 years
        $endYear = now()->year + 1;  // Include next year
        return range($startYear, $endYear);
    }
    
    public function recalculateArchivedPayroll($id, $employee_id)
    {
        $archivedPayroll = ArchivedPayroll::find($id);
        $employee = Employee::withTrashed()->find($employee_id);

        if ($archivedPayroll && $employee && $employee->workInfo) {
            // Use the current salary from the employee's workInfo
            $salary = $archivedPayroll->salary;

            // Recalculate using PayrollService logic (copy/adapt as needed)
            $deductionSettings = \App\Models\PayrollDeductionSetting::first();
            $basic_salary = $salary;
            $allowance = $archivedPayroll->allowance;
            $overtime_pay = $archivedPayroll->overtime_pay;

            $gross = $basic_salary + $allowance + $overtime_pay;

            $sss = $basic_salary * ($deductionSettings->sss_rate ?? 0.045);
            $philhealth = $basic_salary * ($deductionSettings->philhealth_rate ?? 0.03);
            $pagibig = $basic_salary * ($deductionSettings->pagibig_rate ?? 0.01);
            $withholding_tax = $basic_salary * ($deductionSettings->withholding_tax_rate ?? 0.1);
            $additional_deductions = $archivedPayroll->additional_deductions ?? 0;

            $total_deductions = $sss + $philhealth + $pagibig + $withholding_tax + $additional_deductions;
            $net = $gross - $total_deductions;

            $archivedPayroll->update([
                'gross_pay' => $gross,
                'deductions' => $sss + $philhealth + $pagibig + $withholding_tax,
                'net_pay' => $net,
            ]);
        }

        // Refresh the table
        $this->resetPage();
    }

    public function render()
    {
        $query = ArchivedPayroll::withTrashed()->with(['employee' => function ($query) {
            $query->withTrashed(); // Include soft-deleted employees
        }]);

        // Apply filters if month is selected
        if ($this->selectedMonth) {
            $query->whereMonth('pay_period_start', $this->selectedMonth);
        }

        // Apply filters if year is selected
        if ($this->selectedYear) {
            $query->whereYear('pay_period_start', $this->selectedYear);
        }

        // Apply filter for employee name
        if ($this->searchName) {
            $query->whereHas('employee', function ($q) {
                $q->where('first_name', 'like', '%' . $this->searchName . '%')
                  ->orWhere('last_name', 'like', '%' . $this->searchName . '%')
                  ->orWhereRaw("TRIM(first_name || ' ' || last_name) LIKE ?", ['%' . $this->searchName . '%']);
            });
        }

        // Status filter
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Sorting
        if (in_array($this->sortField, ['id', 'net_pay'])) {
            $query->orderBy($this->sortField, $this->sortDirection);
        } elseif ($this->sortField === 'employee_name') {
            $query->join('employees', 'archived_payrolls.employee_id', '=', 'employees.id')
                  ->orderByRaw("CONCAT(employees.first_name, ' ', employees.last_name) {$this->sortDirection}")
                  ->select('archived_payrolls.*');
        } elseif (in_array($this->sortField, ['department', 'position', 'salary'])) {
            $query->join('employees', 'archived_payrolls.employee_id', '=', 'employees.id')
                  ->join('employee_work_infos', 'employees.id', '=', 'employee_work_infos.employee_id')
                  ->orderBy("employee_work_infos.{$this->sortField}", $this->sortDirection)
                  ->select('archived_payrolls.*');
        }

        $archivedPayrolls = $query->paginate(10); // Paginate with 10 items per page

        return view('livewire.archived-payroll-index', [
            'archivedPayrolls' => $archivedPayrolls,
            'months' => $this->getMonths(),
            'years' => $this->getYears(),
        ]);
    }
}
