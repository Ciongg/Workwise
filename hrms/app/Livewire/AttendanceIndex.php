<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Attendance;
use App\Models\Employee;

class AttendanceIndex extends Component
{
    use WithPagination;

    public $selectedAttendance = null;
    public $showCreateAttendance = false;

    public $modalKey;
    public $createModalKey;

    public $sortField = 'id';
    public $sortDirection = 'asc';

    public $searchEmployeeName = '';
    public $searchEmployeeId = '';
    public $searchDate = '';

    protected $listeners = [
        'attendanceUpdated' => '$refresh',
        'closeCreateAttendance' => 'closeCreateAttendance'
    ];

    public function selectAttendance($id)
    {
        $this->selectedAttendance = Attendance::with('employee')->findOrFail($id);
        $this->modalKey = uniqid();
    
        // Dispatch a browser event to open the modal AFTER data is ready
          $this->dispatch('open-modal', name: 'view-attendance');
    }

    public function openCreateAttendance()
    {
        $this->createModalKey = uniqid();
        $this->showCreateAttendance = true;
    }

    public function closeCreateAttendance()
    {
        $this->showCreateAttendance = false;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSearchEmployeeName()
    {
        $this->resetPage();
    }

    public function updatedSearchEmployeeId()
    {
        $this->resetPage();
    }

    public function updatedSearchDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Attendance::with('employee');

        if (!empty($this->searchEmployeeName)) {
            $query->whereHas('employee', function ($q) {
                $q->where('first_name', 'like', '%' . $this->searchEmployeeName . '%')
                  ->orWhere('last_name', 'like', '%' . $this->searchEmployeeName . '%');
            });
        }

        if (!empty($this->searchEmployeeId)) {
            $query->where('employee_id', $this->searchEmployeeId);
        }

        if (!empty($this->searchDate)) {
            $query->where('date', $this->searchDate);
        }

        $attendances = $query
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.attendance-index', [
            'attendances' => $attendances,
        ]);
    }
}
