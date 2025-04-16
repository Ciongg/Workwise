<?php

namespace App\Livewire;

use App\Models\ArchivedPayroll;
use Livewire\Component;
use Livewire\WithPagination;

class ArchivedPayrollIndex extends Component
{
    use WithPagination;

    public $selectedMonth = null;
    public $selectedYear = null;
    public $searchName = null;

    protected $paginationTheme = 'tailwind'; // Optional: Use Tailwind pagination styles

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

    public function render()
    {
        $query = ArchivedPayroll::query();

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
                  ->orWhere('last_name', 'like', '%' . $this->searchName . '%');
            });
        }

        $employees = $query->paginate(10); // Paginate with 10 items per page

        return view('livewire.archived-payroll-index', [
            'employees' => $employees,
            'months' => $this->getMonths(),
            'years' => $this->getYears(),
        ]);
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
}
