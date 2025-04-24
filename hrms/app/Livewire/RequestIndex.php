<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmployeeRequest;
use Illuminate\Support\Facades\DB;

class RequestIndex extends Component
{
    use WithPagination;

    public $selectedRequest = null;
    public $modalKey;
    public $filter_created_at = '';
    public $filter_request_type = '';
    public $filter_status = '';
    public $sortField = 'id'; //default ascending in the index
    public $sortDirection = 'asc';

    
    protected $listeners = ['employeeRequestUpdated' => '$refresh'];

    public function selectRequest($id)
    {
        $this->selectedRequest = EmployeeRequest::with('employee')->find($id);

        $this->modalKey = uniqid(); // Use the request ID as the modal key
        $this->dispatch('open-modal', name: 'view-employee-request');
    }


    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage(); // <-- Add this line to reset to page 1
    }


    public function render()
    {
        $query = EmployeeRequest::query();

        if ($this->filter_created_at) {
            $query->whereDate('created_at', $this->filter_created_at);
        }
        if ($this->filter_request_type) {
            $query->where('request_type', $this->filter_request_type);
        }
        if ($this->filter_status) {
            $query->where('status', $this->filter_status);
        }

        // Handle sorting for employee_name (join or sort by related model if needed)
        if ($this->sortField === 'employee_name') {
            $driver = DB::getDriverName();
            if ($driver === 'sqlite') {
                // SQLite uses || for concatenation
                $query = $query->join('employees', 'employee_requests.employee_id', '=', 'employees.id')
                    ->orderByRaw("(employees.first_name || ' ' || employees.last_name) {$this->sortDirection}")
                    ->select('employee_requests.*');
            } else {
                // MySQL and others use CONCAT
                $query = $query->join('employees', 'employee_requests.employee_id', '=', 'employees.id')
                    ->orderByRaw("CONCAT(employees.first_name, ' ', employees.last_name) {$this->sortDirection}")
                    ->select('employee_requests.*');
            }
        } else {
            $query = $query->orderBy($this->sortField, $this->sortDirection);
        }

        $employees = $query
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10);

        $requests = $query->with('employee')->paginate(10);

        return view('livewire.request-index', compact('requests'));
    }
}
