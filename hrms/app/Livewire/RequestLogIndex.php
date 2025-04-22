<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmployeeRequest;
use Illuminate\Support\Facades\Auth;

class RequestLogIndex extends Component
{
    use WithPagination;

    protected $listeners = [
        'overtimeCompleted' => '$refresh',
    ];

    public $showOvertimeLogModal = false;
    public $selectedOvertimeRequest;
    public $modalKey;

    public $searchType = '';    
    public $searchStatus = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $startPeriod = ''; // Only one filter for Start Period
    public $employeeIdFilter = ''; // Add this property if it's not already defined

    public function openOvertimeLog($requestId)
    {
        $this->selectedOvertimeRequest = EmployeeRequest::find($requestId);
        $this->showOvertimeLogModal = true;
        $this->modalKey = uniqid();
        $this->dispatch('open-modal', ['name' => 'overtime-log']);
    }


    //edit to allow delete
    public function deleteRequest($id)
    {
        $request = EmployeeRequest::find($id);
        if ($request && in_array($request->status, ['rejected', 'cancelled', 'pending'])) {
            $request->delete();
            session()->flash('success', 'Request deleted successfully.');
        }
    }

    public function updatedSearchType()
    {
        $this->resetPage(); // Reset pagination when the type filter changes
    }

    public function updatedSearchStatus()
    {
        $this->resetPage(); // Reset pagination when the status filter changes
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

    public function render()
    {
        $query = EmployeeRequest::query()->with('employee'); // Ensure 'employee' relationship is loaded

        // Filter by employee ID
        if (!empty($this->employeeIdFilter)) {
            $query->where('employee_id', $this->employeeIdFilter);
        }

        // Filter by request type
        if (!empty($this->searchType)) {
            $query->where('request_type', $this->searchType);
        }

        // Filter by status
        if (!empty($this->searchStatus)) {
            $query->where('status', $this->searchStatus);
        }

        // Filter by exact start period (date only)
        if (!empty($this->startPeriod)) {
            $query->whereDate('start_time', '=', $this->startPeriod);
        }

        $requests = $query
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.request-log-index', [
            'requests' => $requests,
        ]);
    }
}
